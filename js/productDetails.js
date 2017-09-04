(function($) {

    productVariant = '';
    Drupal.behaviors.ceeProductDetails = {
        attach: function(context, settings) {
            console.log("bum");
            console.log($('body.path-product', context));
            if ($('body.path-product', context).size() > 0) {
                var detailsObj = settings.commerceEnchancedECommerce,
                    details = $.getProductDetails(detailsObj);
                productVariant = detailsObj.variant;
                dataLayer.push({
                    'event': 'productDetails',
                    'ecommerce': {
                        'detail': details
                    }
                });
            }
            if (productVariant !== '' && settings.commerceEnchancedECommerce.variant !== productVariant) {
                var detailsObj = settings.commerceEnchancedECommerce,
                    details = $.getProductDetails(detailsObj);
                productVariant = detailsObj.variant;
                dataLayer.push({
                    'event': 'productDetails',
                    'ecommerce': {
                        'detail': details
                    }
                });
            }
        }
    };
})(jQuery);
