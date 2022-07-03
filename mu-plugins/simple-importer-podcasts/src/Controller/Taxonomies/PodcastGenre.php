<?php

namespace SimpleImporter\Controller\Taxonomies;

use SimpleImporter\Controller\PostTypes\Podcast;

class PodcastGenre
{
  public const type = 'podcast-Genre';

  public function __construct()
  {
    add_action( 'init', [ $this, 'register' ] );
  }

  public function register(): void
  {
    $labels = array(
      'name' => 'Genres',
      'singular_name' => 'Genre',
      'search_items' => 'Search Genres',
      'all_items' => 'All Genres',
      'edit_item' => 'Edit Genre',
      'update_item' => 'Update Genre',
      'add_new_item' => 'Add New Genre',
      'new_item_name' => 'New Genre Name',
      'menu_name' => 'Genre',
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
}