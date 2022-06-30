<?php
namespace Rodrigo\SimpleTheme;

class Theme {
  public function __construct()
  {
    add_filter( 'the_generator', '__return_false' );
  }
}