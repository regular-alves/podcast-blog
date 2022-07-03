<?php 
/*
Plugin Name: Simple Importer Podcasts
Description: Imports posts from a JSON file.
Version: 1.0
Author: Rodrigo Alves <rodrigo.gois@live.com>
Author URI: https://github.com/regular-alves
*/

namespace SimpleImporter;

use function \plugin_dir_path;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

class SimpleImporter
{
  public const SLUG = 'simple-importer';

  public function __construct() 
  {
    new Controller\Admin();
    new Controller\Importer();
    new Controller\Taxonomies();
    new Controller\PostTypes();
  }

  static function getPath(): string 
  {
    return plugin_dir_path( __FILE__ );
  }

  static function getUrl(): string 
  {
    return plugin_dir_url( __FILE__ );
  }
}

new SimpleImporter();
