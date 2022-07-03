<?php
use SimpleImporter\Controller\Taxonomies\PodcastGenre;

$term = get_queried_object();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php wp_head(); ?>
  <title><?php echo get_bloginfo( 'name' ) . wp_title( ' - ', false, 'left' ); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.00, maximum-scale=2.00, minimum-scale=1.00" />
</head>
<body <?php body_class()?>>
  <header class="Header">
    <div class="Header-content">
      <h1>
        Top 5 
        <span class="Header-genre"><?php echo is_tax( PodcastGenre::type ) ? "{$term->name} " : '' ?></span>
        Podcasts
      </h1>
    </div>
  </header>