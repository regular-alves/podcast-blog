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
}