<?php

namespace Drupal\commerce_enchanced_ecommerce\Model;

use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_product\Entity\ProductVariationInterface;

/**
 * Provides the completion message pane.
 *
 * @package Drupal\commerce_enchanced_ecommerce\Model
 */
class EnchancedECommerceOrder {

  protected $order;

  /**
   * Constructs a new EnchancedECommerceOrder object.
   */
  public function __construct(OrderInterface $order) {
    $this->order = $order;
  }

  /**
   * {@inheritdoc}
   */
  public function getOrderCompleteData(&$form) {
    $paymentStorage = \Drupal::service('entity.manager')->getStorage('commerce_payment');
    $payments = $paymentStorage->loadMultipleForOrder($this->order);
    $store = $this->order->getStore()->label();
    $revenue = $this->order->getTotalPrice()->getNumber();
    $tax = 0.00;
    $shipping = 0.00;
    /** @var \Drupal\commerce_order\Adjustment $adjustment */
    foreach ($this->order->getAdjustments() as $adjustment) {
      if ($adjustment->getType() == 'tax') {
        $tax = $adjustment->getAmount()->getNumber();
      }
      if ($adjustment->getType() == 'shipping') {
        $shipping = $adjustment->getAmount()->getNumber();
      }
    }
    $orderItems = [];
    if ($this->order->hasField('shipments') && !$this->order->get('shipments')->isEmpty()) {
      $shipments = $this->order->get('shipments')->referencedEntities();
      /** @var \Drupal\commerce_shipping\Entity\Shipment $shipment */
      foreach ($shipments as $shipment) {
        $items = $shipment->getItems();
        /** @var \Drupal\commerce_shipping\ShipmentItem $shipmentItem */
        foreach ($items as $shipmentItem) {
          $orderItem = \Drupal::entityTypeManager()->getStorage('commerce_order_item')->load($shipmentItem->getOrderItemId());
          $purchased_entity = $orderItem->getPurchasedEntity();
          if (!$purchased_entity instanceof ProductVariationInterface) {
            continue;
          }
          $enchanchedEcommerce = new EnchancedECommerceItem($orderItem, $shipmentItem);
          $orderItems[] = $enchanchedEcommerce->toExport();
        }
      }
    }
    else {
      $items = $this->order->getItems();
      /** @var \Drupal\commerce_order\Entity\OrderItemInterface $orderItem */
      foreach ($items as $orderItem) {
        $purchased_entity = $orderItem->getPurchasedEntity();
        if (!$purchased_entity instanceof ProductVariationInterface) {
          continue;
        }
        $enchanchedEcommerce = new EnchancedECommerceItem($orderItem);
        $orderItems[] = $enchanchedEcommerce->toExport();
      }
    }
    $payment = reset($payments);
    $paymentId = (!empty($payment->remote_id->value)) ? $payment->remote_id->value : $payment->id();
    $orderData = new \stdClass();
    $orderData->id = $paymentId;
    $orderData->affiliation = $store;
    $orderData->revenue = round($revenue, 2);
    $orderData->tax = round($tax, 2);
    $orderData->shipping = round($shipping, 2);
    // @todo implement coupon.
    // $orderData->coupon': 'SUMMER_SALE'';
    $form['#attached']['drupalSettings']['orderDetails'] = $orderData;
    $form['#attached']['drupalSettings']['orderItems'] = $orderItems;
    // Get placed time.
    $form['#attached']['drupalSettings']['orderPlaced'] = $this->order->getPlacedTime();
    $form['#attached']['drupalSettings']['stepId'] = $this->order->get('checkout_step');
    $form['#attached']['library'][] = 'commerce_enchanced_ecommerce/checkout_complete';
    return $form;
  }

}
