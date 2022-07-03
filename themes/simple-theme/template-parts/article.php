<?php

use SimpleImporter\Controller\Taxonomies\PodcastPublisher;

$total_episodes = get_field( 'total_episodes', get_the_ID() );
$itunes = get_field( 'itunes_id', get_the_ID() );
$website = get_field( 'website', get_the_ID() );
$rss = get_field( 'rss', get_the_ID() );
?>
<li class="Post">
<div class="Post-contentWrapper">
  <div class="Post-thumbnail">
    <?php 
    the_post_thumbnail(
      'full',
      [
        'alt' => get_the_title(),
        'title' => get_the_title(),
      ]
    )
    ?>
  </div>
  <div class="Post-content">
    <div class="Post-heading">
      <h2><?php echo get_the_title() ?></h2>
      <div class="Post-subheading">
        by <span class="Post-subheadingName"><?php echo PodcastPublisher::format( get_the_ID() ) ?></span>
      </div>
      <?php 
      $ep_count = $total_episodes ?: 1;
      echo "$ep_count episode" . ( $ep_count > 1 ? 's' : '' );
      ?>
      <div class="Post-sublinks">
        <?php if( ! empty( $itunes ) ): ?>
        <a class="Post-sublink Post-sublink--itunes" href="https://podcasts.apple.com/podcast/<?php echo $itunes ?>" nofollow>Itunes</a>
        <?php endif ?>

        <?php if( ! empty( $website ) ): ?>
        <a class="Post-sublink Post-sublink--web" href="<?php echo $website ?>" nofollow>Web</a>
        <?php endif ?>

        <?php if( ! empty( $rss ) ): ?>
        <a class="Post-sublink Post-sublink--rss" href="<?php echo $rss ?>" nofollow>RSS</a>
        <?php endif ?>
      </div>
    </div>
    <div class="Post-description">
      <?php the_content() ?>
    </div>
  </div>
</div>
</li>