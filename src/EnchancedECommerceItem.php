<?php

namespace Drupal\commerce_enchanced_ecommerce;

use Drupal\commerce_order\Entity\OrderItemInterface;
use Drupal\commerce_shipping\ShipmentItem;

/**
 * Class EnchancedECommerce
 *
 * Handle ecommerce data.
 */
class EnchancedECommerceItem {

  public $title = '';

  public $brand = '';

  public $category = '';

  public $price = 0.00;

  public $variant = '';

  public $productId = 0;

  public $sku = 0;

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
    $this->title = $product->label();
    if (is_null($shipmentItem)) {
      $this->price = round($orderItem->getTotalPrice()->getNumber(), 2);
    }
    else {
      $this->price = round($shipmentItem->getDeclaredValue()->getNumber(), 2);
    }
    $this->variant = $variation->label();
    $this->productId = $product->id();
    $this->sku = $variation->getSku();
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

  public function getOrderItemDetails() {
    $details = new \stdClass();
    $details->name = $this->title;
    $details->variant = $this->variant;
    $details->price = $this->price;
    $details->id = $this->sku;
    $details->quantity = $this->quantity;
    if ($this->brand !== '') {
      $details->brand = $this->brand;
    }
    if ($this->category !== '') {
      $details->category = $this->category;
    }
    // @todo implement coupon.
    // $details->coupon = $this->coupon;
    return $details;
  }
}