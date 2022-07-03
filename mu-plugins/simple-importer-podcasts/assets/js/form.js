(function( $ ) {
  const showNotice = (message, type) => {
    $( `<div class="notice ${type}"><p>${message}</p></div>` )
      .insertAfter('h1.wp-heading-inline');
  }

  $(document).ready(function() {
    $('#simple-importer').on('submit', function(e) {
      e.preventDefault();

      if(
        $('#simple-importer').hasClass('SimpleImporter--isLoading') ||
        $('.SimpleImporter-submit').hasClass('disabled')
      ) {
        return;
      }

      const data = new FormData();

      $.each($('.SimpleImporter-input')[0].files, (i, file) => {
        data.append(`podcast`, file);
      });
      
      data.append('importer-nonce', $('input[name=importer-nonce]').val());
      data.append('_wp_http_referer', $('input[name=_wp_http_referer]').val());

      $('#simple-importer').addClass('SimpleImporter--isLoading');
      $('.SimpleImporter-submit').addClass('disabled');

      $.ajax({
        method: 'POST',
        url: $(this).attr('action'),
        data,
        cache: false,
        contentType: false,
        processData: false,
        success: data => {
          showNotice( 'Podcasts imported successfully', 'updated' );

          $('#simple-importer').removeClass('SimpleImporter--isLoading');
          $('.SimpleImporter-submit').removeClass('disabled');
        },
        error: data => {
          showNotice( 'Error importing podcasts', 'error' );

          $('#simple-importer').removeClass('SimpleImporter--isLoading');
          $('.SimpleImporter-submit').removeClass('disabled');
        }
      });
    });
  });

})( jQuery );