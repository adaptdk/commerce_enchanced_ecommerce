/**
 * @file
 * Defines behaviors for the adapt shipping checkout pane.
 */
(function ($, Drupal, drupalSettings) {

    'use strict';

    /**
     * Attaches the adaptShippingCheckout behavior.
     *
     * @type {Drupal~behavior}
     *
     * @prop {Drupal~behaviorAttach} attach
     *   Attaches the adaptShippingCheckout behavior.
     */
    Drupal.behaviors.googleECommerce = {
        attach: function (context, settings) {
            if ($('body', context).size()) {
                window.dataLayer = window.dataLayer || [];
                if (typeof settings.checkout !== 'undefined' ) {
                    dataLayer.push(settings.checkout);
                }
            }
        }
    };

})(jQuery, Drupal, drupalSettings);
