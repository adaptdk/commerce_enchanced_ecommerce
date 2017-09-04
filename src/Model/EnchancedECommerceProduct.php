<?php

namespace Drupal\commerce_enchanced_ecommerce\Model;

use Drupal\commerce_product\Entity\Product;
use Drupal\commerce_product\Entity\ProductVariation;

/**
 * Class EnchancedECommerceProduct
 *
 * Handle ecommerce data.
 *
 * @package Drupal\commerce_enchanced_ecommerce\Model
 */
class EnchancedECommerceProduct {

  public $title = '';

  public $id = '';

  public $brand = '';

  public $category = '';

  public $price = 0.00;

  public $variant = '';

  public $quantity = 0;

  /**
   * Constructs a new ShipmentItem object.
   *
   * @param array $definition
   *   The definition.
   */
  public function __construct(Product $product, ProductVariation $variation, int $quantity = 1) {

    $this->title = $product->label();
    $this->id = $variation->getSku();
    $this->price = round($variation->getPrice()->getNumber(), 2);
    $this->variant = $variation->label();
    if ($product->hasField('field_brand') && !$product->field_brand->isEmpty()) {
      $this->brand = $product->field_brand->entity->label();
    }
    if ($product->hasField('field_category') && !$product->field_category->isEmpty()) {
      $this->category = $product->field_category->entity->label();
    }
    $this->quantity = $quantity;
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