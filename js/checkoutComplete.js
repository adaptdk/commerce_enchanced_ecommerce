(function($) {
    Drupal.behaviors.ceeProductDetails = {
        attach: function(context, settings) {
            if (settings.stepId === 'complete') {
                var timeSincePlaced = Math.round(Date.now() / 1000) - parseInt(settings.orderPlaced),
                    items = settings.orderItems,
                    details = settings.orderDetails;
                // Check if the order was placed within the last 30 minutes.
                if (timeSincePlaced < 1800) {
                    dataLayer.push({
                        'event': 'checkoutComplete',
                        'ecommerce': {
                            'purchase': {
                                'actionField': details,
                                'products': items
                            }
                        }
                    });
                }
            }
        }
    };
})(jQuery);
