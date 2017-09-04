<?php

namespace Drupal\commerce_enchanced_ecommerce\Model;

/**
 * Format the data payload to google analytics.
 *
 * @package Drupal\commerce_enchanced_ecommerce\Model
 */
class EnchancedECommerceCheckout {

  public $event = 'checkout';
  public $ecommerce;

  /**
   * GoogleCheckoutPayload constructor.
   *
   * @param string $stepId
   *   StepId.
   * @param array $products
   *   Array of products.
   */
  public function __construct($stepId, array $products) {
    $this->ecommerce = new \stdClass();
    $checkout = $this->ecommerce->checkout = new \stdClass();

    $checkout->actionField = new \stdClass();
    $checkout->actionField->step = $this->stepIdToNumber($stepId);

    $checkout->products = $products;
  }

  /**
   * Get numeric step id from step.
   *
   * @param string $stepId
   *   StepId.
   *
   * @return bool|mixed
   *   False if none, else numeric id.
   */
  public function stepIdToNumber($stepId) {
    $map = [
      'delivery' => 1,
      'billing' => 2,
      'review' => 3,
      'payment' => 4,
      'complete' => 5,
    ];

    if (isset($map[$stepId])) {
      return $map[$stepId];
    }
    else {
      return FALSE;
    }

  }

}