<?php

namespace Drupal\commerce_enchanced_ecommerce\Model;

use Drupal\commerce_order\Entity\OrderItem;
use Drupal\commerce_price\Calculator;
use Drupal\commerce_shipping\Entity\Shipment;
use Drupal\commerce_shipping\ShipmentItem;
use Drupal\interflora_international_product\Service\OnlineIddService;

/**
 * Format a shipment item for google analytics.
 *
 * @package Drupal\commerce_enchanced_ecommerce\Model
 */
class EnchancedECommerceShipmentProduct {

  /**
   * Shipment item.
   *
   * @var \Drupal\commerce_shipping\ShipmentItem
   */
  private $shipmentItem;
  
  /**
   * Shipment.
   *
   * @var \Drupal\commerce_shipping\Entity\Shipment
   */
  private $shipment;

  /**
   * Name.
   *
   * @var string
   */
  public $name;
  
  /**
   * Id.
   *
   * @var string
   */
  public $id;
  
  /**
   * Price.
   *
   * @var string
   */
  public $price;

  /**
   * Variant.
   *
   * @var string
   */
  public $variant;
  
  /**
   * Category.
   *
   * @var string
   */
  public $category;
  
  /**
   * Quantity.
   *
   * @var string
   */
  public $quantity;

  /**
   * GoogleShipmentProduct constructor.
   *
   * @param \Drupal\commerce_shipping\ShipmentItem $shipmentItem
   *   The shipment item.
   * @param \Drupal\commerce_shipping\Entity\Shipment $shipment
   *   The shipment.
   */
  public function __construct(ShipmentItem $shipmentItem, Shipment $shipment) {

    $this->shipmentItem = $shipmentItem;
    $this->shipment = $shipment;

    $orderItemId = $this->shipmentItem->getOrderItemId();

    $entity_manager = \Drupal::entityTypeManager();
    $orderItem = $entity_manager->getStorage('commerce_order_item')->load($orderItemId);
    if (!is_null($orderItem)) {
      $this->formatDefaultShipment($orderItem);
    }
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

  /**
   * Format default shipment.
   *
   * @param \Drupal\commerce_order\Entity\OrderItem $orderItem
   *   Order item.
   *
   * @return $this
   *   Instance of object.
   */
  protected function formatDefaultShipment(OrderItem $orderItem) {
    /** @var \Drupal\commerce_product\Entity\ProductVariation $productVariation */
    $productVariation = $orderItem->getPurchasedEntity();

    $this->variant = $productVariation->getTitle();

    $product = $productVariation->getProduct();

    $this->name = $product->getTitle();

    $this->id = $productVariation->getSku();
    if ($product->hasField('field_category') && !$product->get('field_category')->isEmpty()) {
      /** @var \Drupal\taxonomy\Entity\Term $productGroup */
      $productGroup = $product->get('field_category')->first()->entity;
      $this->category = $productGroup->getName();
    }

    return $this
      ->setPrice()
      ->setQuantity();
  }

  /**
   * Set price.
   *
   * @return $this
   *   Instance of object.
   */
  protected function setPrice() {
    $this->price = Calculator::divide($this->shipmentItem->getDeclaredValue()
      ->getNumber(), $this->shipmentItem->getQuantity());

    return $this;
  }

  /**
   * Set quantity.
   *
   * @return $this
   *   Instance of object.
   */
  protected function setQuantity() {
    $this->quantity = $this->shipmentItem->getQuantity();

    return $this;
  }

}
