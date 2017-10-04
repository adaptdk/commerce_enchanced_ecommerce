(function($) {
    productVariant = '';
    $.getListProducts = function () {
        var details = [],
            count = 1;
        $('.item-list .product-teaser:visible').each(function() {
            var product = {
                    'name': $('.field--name-title', this).text(),
                    'id': $(this).attr('data-sku'),
                    'price': $('.price--sum').attr('content'),
                    'variant': $(this).attr('data-variation'),
                    'list': $('h1:first').text(),
                    'position': count
                },
                catAttr = $(this).attr('data-category'),
                brandAttr = $(this).attr('data-brand');
            if (typeof catAttr !== typeof undefined && catAttr !== false) {
                // Element has this attribute.
                product.category = catAttr;
            }
            if (typeof brandAttr !== typeof undefined && brandAttr !== false) {
                // Element has this attribute.
                product.brand = brandAttr;
            }
            details.push(product);
            count += 1;
        });
        return details;
    };
    $.getListProductDetails = function (tgt) {
        var product = {
                'name': $('.field--name-title', tgt).text(),
                'id': $(tgt).attr('data-sku'),
                'price': $('.price--sum').attr('content'),
                'variant': $(tgt).attr('data-variation'),
                'position': parseInt($(tgt).closest('li').index()) + 1
            },
            catAttr = $(tgt).attr('data-category'),
            brandAttr = $(tgt).attr('data-brand');
        if (typeof catAttr !== typeof undefined && catAttr !== false) {
            // Element has this attribute.
            product.category = catAttr;
        }
        if (typeof brandAttr !== typeof undefined && brandAttr !== false) {
            // Element has this attribute.
            product.brand = brandAttr;
        }
        return product;
    };
    $.getProductDetails = function (detailsObj) {
        details = {
            'actionField': {},
            'products': [{
                'name': detailsObj.title,
                'id': detailsObj.id,
                'price': detailsObj.price,
                'variant': detailsObj.variant
            }]
        };
        if (typeof detailsObj.brand !== 'undefined') {
            details.products[0].brand = detailsObj.brand;
        }
        if (typeof detailsObj.category !== 'undefined') {
            details.products[0].category = detailsObj.category;
        }
        return details;
    };
    $.getAdjustCartInformation = function (productObj) {
        details = {                        //  adding a product to a shopping cart.
            'name': productObj.title,
            'id': productObj.id,
            'price': productObj.price,
            'variant': productObj.variant,
            'quantity': productObj.quantity
        };
        if (typeof productObj.brand !== 'undefined') {
            details.brand = productObj.brand;
        }
        if (typeof productObj.category !== 'undefined') {
            details.category = productObj.category;
        }
        return details;
    };

})(jQuery);
