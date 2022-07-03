<?php
if ( ! function_exists( 'add_action' ) ) {
  exit;
}
?>
<div class="wrap">
  <?php do_action( 'admin_notices' ); ?>
  <h1 class="wp-heading-inline">Simple Importer</h1>

  <form 
    action="<?php echo admin_url( 'admin-ajax.php?action=submit-json-podcasts' )?>"
    id="simple-importer"
    class="SimpleImporter"
  >
    <?php 
      wp_nonce_field(
        'submit-json-podcasts',
        'importer-nonce',
        true,
        true
      )
    ?>
    <p>Select a json file to import the podcasts.</p>
    <input 
      type="file"
      name="podcast"
      class="SimpleImporter-input"
      accept="application/json, plain/text"
    />
    
    <br/><br/>

    <button type="submit" class="SimpleImporter-submit button button-primary">Submit</button>
  </form>
</div>