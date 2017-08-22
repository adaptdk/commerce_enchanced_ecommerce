<?php

namespace Drupal\commerce_enchanced_ecommerce;

use Drupal\commerce_product\Entity\Product;
use Drupal\commerce_product\Entity\ProductVariation;

/**
 * Class EnchancedECommerce
 *
 * Handle ecommerce data.
 */
class EnchancedECommerce {

  public $title = '';

  public $brand = '';

  public $category = '';

  public $price = 0.00;

  public $variant = '';

  public $productId = 0;

  public $variantId = 0;

  public $quantity = '';

  /**
   * Constructs a new ShipmentItem object.
   *
   * @param array $definition
   *   The definition.
   */
  public function __construct(Product $product, ProductVariation $variation, int $quantity = 1) {

    $this->title = $product->label();
    $this->price = round($variation->getPrice()->getNumber(), 2);
    $this->variant = $variation->label();
    $this->productId = $product->id();
    $this->variantId = $variation->id();
    if ($product->hasField('field_brand') && !$product->field_brand->isEmpty()) {
      $this->brand = $product->field_brand->entity->label();
    }
    if ($product->hasField('field_category') && !$product->field_category->isEmpty()) {
      $this->category = $product->field_category->entity->label();
    }
    $this->quantity = $quantity;
  }

  public function getProductDetails() {
    $details = new \stdClass();
    $details->title = $this->title;
    $details->variant = $this->variant;
    $details->price = $this->price;
    if ($this->brand !== '') {
      $details->brand = $this->brand;
    }
    if ($this->category !== '') {
      $details->category = $this->category;
    }
    return $details;
  }

  public function getCartActionDetails() {
    $details = new \stdClass();
    $details->title = $this->title;
    $details->variant = $this->variant;
    $details->price = $this->price;
    $details->id = $this->variantId;
    $details->quantity = $this->quantity;
    if ($this->brand !== '') {
      $details->brand = $this->brand;
    }
    if ($this->category !== '') {
      $details->category = $this->category;
    }
    return $details;
  }
}