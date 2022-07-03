<?php

use SimpleImporter\Controller\PostTypes\Podcast;

get_header(); 
?>

<div class="ContentWrapper">
  <?php 
  $query = new WP_Query(
    [
      'post_type' => Podcast::type,
      'post_status' => 'publish',
      'post_per_page' => 5,
    ]
  );
  if( $query->have_posts() ) : 
  ?> 

    <ol class="PostList">
      <?php 
      while( $query->have_posts() ) {
        $query->the_post();

        get_template_part( 'template-parts/article' );
      } 
      ?>
  </ol>

  <?php endif; ?>
  <?php wp_reset_query() && wp_reset_postdata(); ?>
</div>

<?php get_footer(); ?>