<?php

namespace SimpleImporter\Controller\PostTypes;

use Exception;
use \WP_Query;
use SimpleImporter\Controller\Taxonomies\PodcastCountry;
use SimpleImporter\Controller\Taxonomies\PodcastLanguage;
use SimpleImporter\Controller\Taxonomies\PodcastPublisher;
use SimpleImporter\Controller\Taxonomies\PodcastType;
use SimpleImporter\Controller\Taxonomies\PodcastGenre;
use SimpleImporter\Service\JsonToPosts;

class Podcast 
{
  public const type = 'podcast';
  public $tax = [
    PodcastGenre::type,
    PodcastType::type,
    PodcastLanguage::type,
    PodcastCountry::type,
    PodcastPublisher::type
  ];

  public function __construct()
  {
    add_action( 'init', [ $this, 'register' ], 1 );
    add_action( 'acf/init', [ $this, 'addPostFields' ] );
    add_action( 'wp_ajax_submit-json-podcasts', [ $this, 'processFile' ] );
    add_action( 'wp_ajax_nopriv_submit-json-podcasts', [ $this, 'processFile' ] );
    add_filter( 'pre_get_posts', [ $this, 'fixQueryPostType' ] );
  }
  
  public function register(): void
  {
    $labels = [
      'name' => 'Podcasts',
      'singular_name' => 'Podcast',
      'menu_name' => 'Podcasts',
      'name_admin_bar' => 'Podcast',
      'add_new' => 'Add New',
      'add_new_item' => 'Add New podcast',
      'new_item' => 'New podcast',
      'edit_item' => 'Edit podcast',
      'view_item' => 'View podcast',
      'all_items' => 'All podcasts',
      'search_items' => 'Search podcasts',
      'not_found' => 'No podcasts found.',
      'not_found_in_trash' => 'No podcasts found in Trash.',
    ];

    $args = [
      'labels' => $labels,
      'description' => 'Podcast custom post type.',
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => 10.1,
      'supports' => [ 'title', 'editor', 'author', 'thumbnail' ],
      'taxonomies' => $this->tax,
      'rewrite' => [
        'slug' => 'podcasts'
      ],
      'show_in_rest' => true,
      'menu_icon' => 'dashicons-microphone',
      'show_ui' => true,
      'show_in_menu' => true,
    ];

    register_post_type( self::type, $args );
  }

  public function addPostFields()
  {
    acf_add_local_field_group(
      [
        'key' => self::type . '-post-extra-fields',
        'title' => 'Podcast fields',
        'fields' => [
          [
            'key' => self::type . '-listennotes-url',
            'label' => 'Listen notes URL',
            'name' => 'listennotes_url',
            'type' => 'url',
            'required' => true,
            'wrapper' => [
              'width' => '30%',
            ],
          ],
          [
            'key' => self::type . '-total-episodes',
            'label' => 'Total Episodes',
            'name' => 'total_episodes',
            'type' => 'number',
            'min' => 1,
            'required' => true,
            'wrapper' => [
              'width' => '30%',
            ],
          ],
          [
            'key' => self::type . '-itunes-id',
            'label' => 'Itunes ID',
            'name' => 'itunes_id',
            'type' => 'text',
            'required' => true,
            'wrapper' => [
              'width' => '30%',
            ],
          ],
          [
            'key' => self::type . '-rss',
            'label' => 'RSS URL',
            'name' => 'rss',
            'type' => 'url',
            'required' => true,
            'wrapper' => [
              'width' => '30%',
            ],
          ],
          [
            'key' => self::type . '-website',
            'label' => 'Website',
            'name' => 'website',
            'type' => 'url',
            'required' => true,
            'wrapper' => [
              'width' => '30%',
            ],
          ],
          [
            'key' => self::type . '-is-claimed',
            'name' => 'is_claimed',
            'label' => 'Is claimed?',
            'required' => true,
            'wrapper' => [
              'width' => '30%',
            ],
            'type' => 'true_false',
          ],
        ],
        'location' => [
          [
            [
              'param' => 'post_type',
              'operator' => '==',
              'value' => self::type,
            ]
          ]
        ]
      ]
    );
  }

  public function processFile()
  {
    if ( ! isset( $_POST['importer-nonce'] ) ) {
      http_response_code( 400 );
      die( 'Bad Request.' );
    }

    if ( ! wp_verify_nonce( $_POST['importer-nonce'], 'submit-json-podcasts' ) ) {
      http_response_code( 400 );
      die( 'Bad Request.' );
    }

    try {
      new JsonToPosts( $_FILES['podcast']['tmp_name'] );
      
    } catch( Exception $err ) {
      die( $err->getMessage() );
    }

    http_response_code( 204 );
    die();
  }
  
  public function fixQueryPostType( WP_Query $query ): WP_Query
  {
    if ( ! is_tax( $this->tax ) ) {
      return $query;
    }

    $query->set( 'post_type', Podcast::type );

    return $query;
  }
}