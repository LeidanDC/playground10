(function ($, Drupal) {
  Drupal.behaviors.playground_product_cta = {
    attach: function (context, settings) {
      $('.product-cta', context).click(function(e) {
        $.ajax({
          url: Drupal.url('api/product/cta'),
          type: "POST",
          data: { id: $(this).attr('data-id') },
          success: function(response) {
            window.location = response.url;
          },
          error: function(xhr, status, error) {
              // Handle errors here
              console.log("Error: ", error);

          }
        });

      });
    }
  }

})(jQuery, Drupal);
