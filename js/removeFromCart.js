(function($) {

    Drupal.behaviors.ceeAddToCart = {
        attach: function(context, settings) {
            $('#edit-submit', context).on('mousedown', function (evt) {
                var detailsObj = settings.ceeAddToCart,
                    product = $.getAdjustCartInformation(detailsObj);
                dataLayer.push({
                    'event': 'removeFromCart',
                    'ecommerce': {
                        'remove': {
                            'products': [product]
                        }
                    }
                });
            });
        }
    };

})(jQuery);
