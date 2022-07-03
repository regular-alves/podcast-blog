<?php
namespace Rodrigo\SimpleTheme;

class Theme {
  public function __construct()
  {
    add_filter( 'the_generator', '__return_false' );
    add_action( 'wp_enqueue_scripts', [ $this, 'enqueueScripts' ] );
  }

  public function enqueueScripts()
  {
    wp_enqueue_style(
      'reset',
      get_template_directory_uri() . '/assets/stylesheet/reset.css',
      [],
      filemtime( get_template_directory() . '/assets/stylesheet/reset.css' ),
    );

    wp_enqueue_style(
      'main',
      get_template_directory_uri() . '/assets/stylesheet/style.css',
      [ 'reset' ],
      filemtime( get_template_directory() . '/assets/stylesheet/style.css' ),
    );
  }
}