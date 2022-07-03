<?php

use SimpleImporter\Controller\PostTypes\Podcast;

get_header();
?>

<div class="ContentWrapper">
  <?php if( have_posts() ) : ?> 
    <ol class="PostList">
      <?php 
      while( have_posts() ) {
        the_post();
        get_template_part( 'template-parts/article' );
      } 
      ?>
  </ol>
  <?php endif; ?>
</div>

<?php get_footer(); ?>