<?php

namespace SimpleImporter\Controller\Taxonomies;

use SimpleImporter\Controller\PostTypes\Podcast;

class PodcastType
{
  public const type = 'podcast-type';

  public function __construct()
  {
    add_action( 'init', [ $this, 'register' ], 7 );
  }

  public function register(): void
  {
    $labels = array(
      'name' => 'Types',
      'singular_name' => 'Type',
      'search_items' => 'Search Types',
      'all_items' => 'All Types',
      'edit_item' => 'Edit Type',
      'update_item' => 'Update Type',
      'add_new_item' => 'Add New Type',
      'new_item_name' => 'New Type Name',
      'menu_name' => 'Type',
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