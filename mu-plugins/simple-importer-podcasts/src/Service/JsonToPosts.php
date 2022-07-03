<?php

namespace SimpleImporter\Service;

use Exception;
use SimpleImporter\Controller\PostTypes\Podcast;
use \WP_Error;
use SimpleImporter\Controller\Taxonomies\PodcastLanguage;
use SimpleImporter\Controller\Taxonomies\PodcastCountry;
use SimpleImporter\Controller\Taxonomies\PodcastGenre;
use SimpleImporter\Controller\Taxonomies\PodcastPublisher;
use SimpleImporter\Controller\Taxonomies\PodcastType;

class JsonToPosts
{
  private $fileLocation;
  private $fileContent;
  private $genres;

  public function __construct( string $fileLocation )
  {
    $this->location = $fileLocation;

    if ( ! file_exists( $fileLocation ) ) {
      throw new Exception( 'File not found' );
    }

    $this->readFile();
    $this->getGenres();
    $this->createPosts();
  }

  private function readFile(): void
  {
    $content = file_get_contents( $this->location );
    $content = json_decode( $content, true );

    if ( ! $content ) {
      throw new Exception( 'Invalid file content' );
    }

    $this->fileContent = $content;
  }

  private function getGenres(): void
  {
    $genres = [];

    foreach( $this->fileContent as $genre ) {
      $genres[ $genre['id'] ] = $genre['name'];
    }

    $this->genres = $genres;
  }

  private function setTerms( int $post_id, array $post_data ): void
  {
    if ( ! empty( $post_data['type'] ) ) {
      wp_set_post_terms( 
        $post_id, 
        $post_data['type'],
        PodcastType::type,
        true
      );
    }

    if ( ! empty( $post_data['language'] ) ) {
      wp_set_post_terms( 
        $post_id, 
        $post_data['language'],
        PodcastLanguage::type,
        true
      );
    }

    if ( ! empty( $post_data['country'] ) ) {
      wp_set_post_terms( 
        $post_id, 
        $post_data['country'],
        PodcastCountry::type,
        true
      );
    }

    foreach( $post_data['genre_ids'] as $genre ) {
      if ( ! isset( $this->genres[ $genre ] ) ) {
        continue;
      }

      wp_set_post_terms( 
        $post_id, 
        $this->genres[ $genre ],
        PodcastGenre::type,
        true
      );
    }

    $publishers = str_replace(
      [ ', and', '&'],
      ', ',
      $post_data['publisher']
    );

    $publishers = array_map(
      fn($publi) => trim( $publi ),
      explode( ',', $publishers )
    );

    if ( ! empty( $publishers ) ) {
      wp_set_post_terms(
        $post_id, 
        $publishers,
        PodcastPublisher::type,
        true
      );
    }
  }

  private function setMetas( int $post_id, array $post_data ): void
  {
    add_post_meta( $post_id, 'listennotes_url', $post_data['listennotes_url'], true );
    add_post_meta( $post_id, 'total_episodes', $post_data['total_episodes'], true );
    add_post_meta( $post_id, 'itunes_id', $post_data['itunes_id'], true );
    add_post_meta( $post_id, 'rss', $post_data['rss'], true );
    add_post_meta( $post_id, 'website', $post_data['website'], true );
    add_post_meta( $post_id, 'is_claimed', $post_data['is_claimed'] ? 1 : 0, true );
  }

  private function setFeaturedImage( int $post_id, array $post_data ): void
  {
    $attach_id = media_sideload_image(
      $post_data['image'],
      $post_id,
      $post_data['title'],
      'id'
    );

    if ( ! is_numeric( $attach_id ) ) {
      return;
    }

    set_post_thumbnail( $post_id, $attach_id );
  }

  private function createPosts():void 
  {
    $podcasts = [];

    foreach ( $this->fileContent as $genre ) {
      $podcasts = array_merge( $podcasts, $genre['podcasts'] );
    }

    foreach ( $podcasts as $podcast ) {
      $post_id = wp_insert_post(
        [
          'post_title' => $podcast['title'],
          'post_content' => $podcast['description'],
          'post_type' => Podcast::type,
          'post_status' => 'publish',
        ]
      );

      if ( $post_id instanceof WP_Error ) {
        continue;
      }

      $this->setFeaturedImage( $post_id, $podcast );
      $this->setTerms( $post_id, $podcast );
      $this->setMetas( $post_id, $podcast );
    };
  }
}