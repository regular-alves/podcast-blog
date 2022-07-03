<?php

namespace SimpleImporter\Controller\Taxonomies;

use SimpleImporter\Controller\PostTypes\Podcast;

class PodcastLanguage
{
  public const type = 'podcast-language';

  public function __construct()
  {
    add_action( 'init', [ $this, 'register' ] );
  }

  public function register(): void
  {
    $labels = array(
      'name' => 'Languages',
      'singular_name' => 'Language',
      'search_items' => 'Search Languages',
      'all_items' => 'All Languages',
      'edit_item' => 'Edit Language',
      'update_item' => 'Update Language',
      'add_new_item' => 'Add New Language',
      'new_item_name' => 'New Language Name',
      'menu_name' => 'Language',
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