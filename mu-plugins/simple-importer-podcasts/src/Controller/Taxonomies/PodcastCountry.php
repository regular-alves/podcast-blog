<?php

namespace SimpleImporter\Controller\Taxonomies;

use SimpleImporter\Controller\PostTypes\Podcast;

class PodcastCountry
{
  public const type = 'podcast-country';

  public function __construct()
  {
    add_action( 'init', [ $this, 'register' ] );
  }

  public function register(): void
  {
    $labels = array(
      'name'              => 'Countries',
      'singular_name'     => 'Country',
      'search_items'      => 'Search Countries',
      'all_items'         => 'All Countries',
      'edit_item'         => 'Edit Country',
      'update_item'       => 'Update Country',
      'add_new_item'      => 'Add New Country',
      'new_item_name'     => 'New Country Name',
      'menu_name'         => 'Country',
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