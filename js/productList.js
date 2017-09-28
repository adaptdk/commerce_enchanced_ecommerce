(function($) {

    productVariant = '';
    Drupal.behaviors.ceeProductDetails = {
        attach: function(context, settings) {
            if ($('body', context).size()) {
                window.dataLayer = window.dataLayer || {};
                var listData = $.getListProducts(),
                    _data = {
                        'event': 'productListView',
                        'ecommerce': {
                            'currencyCode': 'DKK',
                            'impressions': listData
                        }
                    };
                dataLayer.push(_data);
                $('.product-teaser a', context).each(function () {
                    $(this).click(function (evt) {
                        dataLayer.push({
                            'event': 'productClick',
                            'ecommerce': {
                                'click': {
                                    'actionField': {
                                        'list': $('h1:first').text()
                                    },
                                    'products': [$.getListProductDetails(this)]
                                }
                            },
                            'eventCallback': function() {
                                document.location = productObj.url
                            }
                        });
                    });
                });
            }
        }
    };
})(jQuery);
