<?php

namespace Drupal\commerce_enchanced_ecommerce\Model;

use Drupal\commerce_order\Entity\OrderItemInterface;
use Drupal\commerce_shipping\ShipmentItem;

/**
 * Class EnchancedECommerce
 *
 * Handle ecommerce data.
 *
 * @package Drupal\commerce_enchanced_ecommerce\Model
 */
class EnchancedECommerceItem {

  public $name = '';

  public $brand = '';

  public $category = '';

  public $price = 0.00;

  public $variant = '';

  public $id = 0;

  public $quantity = '';

  protected $coupon = '';

  /**
   * Constructs a new ShipmentItem object.
   */
  public function __construct(OrderItemInterface $orderItem, ShipmentItem $shipmentItem = NULL) {
    /** @var \Drupal\commerce_product\Entity\ProductVariationInterface $variation */
    $variation = $orderItem->getPurchasedEntity();
    /** @var \Drupal\commerce_product\Entity\ProductInterface $variation */
    $product = $variation->getProduct();
    $this->name = $product->label();
    if (is_null($shipmentItem)) {
      $this->price = round($orderItem->getTotalPrice()->getNumber(), 2);
    }
    else {
      $this->price = round($shipmentItem->getDeclaredValue()->getNumber(), 2);
    }
    $this->variant = $variation->label();
    $this->id = $variation->getSku();
    if ($product->hasField('field_brand') && !$product->field_brand->isEmpty()) {
      $this->brand = $product->field_brand->entity->label();
    }
    if ($product->hasField('field_category') && !$product->field_category->isEmpty()) {
      $this->category = $product->field_category->entity->label();
    }
    if (is_null($shipmentItem)) {
      $this->quantity = $orderItem->getQuantity();
    }
    else {
      $this->quantity = $shipmentItem->getQuantity();
    }

    // @todo implement coupon.
    // $this->coupon = $orderItem->coupon;
  }

  /**
   * Export function.
   *
   * @return \stdClass
   *   The information
   */
  public function toExport() {
    $return = new \stdClass();
    $reflection = new \ReflectionObject($this);
    $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);

    foreach ($properties as $property) {
      $return->{$property->getName()} = $property->getValue($this);
    }

    return $return;
  }

}