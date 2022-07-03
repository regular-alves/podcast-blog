<?php

namespace SimpleImporter\Controller\Taxonomies;

use SimpleImporter\Controller\PostTypes\Podcast;

class PodcastPublisher
{
  public const type = 'podcast-publisher';

  public function __construct()
  {
    add_action( 'init', [ $this, 'register' ] );
  }

  public function register(): void
  {
    $labels = array(
      'name' => 'Publishers',
      'singular_name' => 'Publisher',
      'search_items' => 'Search Publishers',
      'all_items' => 'All Publishers',
      'edit_item' => 'Edit Publisher',
      'update_item' => 'Update Publisher',
      'add_new_item' => 'Add New Publisher',
      'new_item_name' => 'New Publisher Name',
      'menu_name' => 'Publisher',
    );

    register_taxonomy(
      self::type,
      Podcast::type,
      [
        'labels' => $labels,
        'public' => true,
        'rewrite' => true,
        'hierarchical' => false,
        'show_in_rest' => true,
      ] 
    );
  }

  static public function format( int $post ): string
  {
    $terms = get_the_terms( $post, PodcastPublisher::type );

    if ( ! is_array( $terms ) ) {
      return '';
    }

    $terms = array_map(
      fn( $term ) => $term->name,
      $terms
    );

    if ( count( $terms ) <= 2 ) {
      return implode(' and ', $terms);
    }

    $last = array_pop( $terms );

    return implode( ', ', $terms ) . ", and $last";
  }
}