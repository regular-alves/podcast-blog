<?php

namespace SimpleImporter\Controller;

use SimpleImporter\SimpleImporter;

class Importer
{
  public function __construct()
  {
    add_action( 'simple-importer-form-page', [ $this, 'form' ] );
    add_action( 'admin_enqueue_scripts', [ $this, 'scripts' ] );
  }

  public function form(): void
  {
    require SimpleImporter::getPath() . 'assets/template-parts/importer-form.php';

    return;
  }

  public function scripts( string $hook ): void
  {
    if ( ! isset( $_GET['page'] ) ) {
      return;
    }

    if ( $_GET['page'] !== 'simple-importer' ) {
      return;
    }

    wp_enqueue_script(
      'admin',
      SimpleImporter::getUrl() . 'assets/js/form.js',
      [ 'jquery' ],
      filemtime( SimpleImporter::getPath() . 'assets/js/form.js' )
    );
  }
}