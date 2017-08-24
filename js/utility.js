(function($) {
    productVariant = '';
    $.getProductDetails = function (detailsObj) {
        details = {
            'actionField': {},
            'products': [{
                'name': detailsObj.title,
                'price': detailsObj.price,
                'brand': 'Google',
                'category': 'Apparel',
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
    }
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
    }

})(jQuery);
