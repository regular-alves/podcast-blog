<?php

namespace SimpleImporter\Controller;

class Admin
{
  public function __construct()
  {
    add_action( 'admin_menu', [ $this, 'adminMenu' ] );
  }

  public function adminMenu()
  {
    add_menu_page(
      'Simple Importer',
      'Simple Importer',
      'manage_options',
      'simple-importer',
      fn() => do_action( 'simple-importer-form-page' ),
      'dashicons-database-import',
      30
    );
  } 
}