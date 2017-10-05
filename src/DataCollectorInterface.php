<?php

namespace Drupal\commerce_enchanced_ecommerce;

use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_order\Entity\OrderItemInterface;
use Drupal\commerce_product\Entity\ProductInterface;
use Drupal\commerce_shipping\Entity\ShipmentInterface;
use Drupal\commerce_shipping\ShipmentItem;

/**
 * class DataCollector
 */
interface DataCollectorInterface  {

  public function getProductData(ProductInterface $product);

  public function getCartProductData(OrderItemInterface $orderItem);

  public function getShipmentProduct(ShipmentItem $item, ShipmentInterface $shipment);

  public function getOrderComplete(OrderInterface $order, array &$form);

  public function getCheckoutStep($stepId, array $products);

}