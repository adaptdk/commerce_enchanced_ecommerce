<?php

namespace Drupal\commerce_enchanced_ecommerce\EventSubscriber;

use Drupal\commerce_product\Event\ProductEvents;
use Drupal\commerce_product\Event\ProductVariationAjaxChangeEvent;
use Drupal\Core\Ajax\SettingsCommand;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ProductAjaxChange.
 */
class ProductAjaxChange implements EventSubscriberInterface {


  /**
   * Constructs a new ProductAjaxChange object.
   */
  public function __construct() {

  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events = [
      ProductEvents::PRODUCT_VARIATION_AJAX_CHANGE => 'onAjaxChange',
    ];
    return $events;
  }

  /**
   * Handle ajax change event.
   *
   * @param \Drupal\commerce_product\Event\ProductVariationAjaxChangeEvent $event
   */
  public function onAjaxChange(ProductVariationAjaxChangeEvent $event) {
    /** @var \Drupal\commerce_product\Entity $product */
    $variant = $event->getProductVariation();
    $product = $variant->getProduct();
    $details = new \stdClass();
    $details->title = $product->label();
    if ($product->hasField('field_brand') && !$product->field_brand->isEmpty()) {
      $details->brand = $product->field_brand->entity->label();
    }
    if ($product->hasField('field_category') && !$product->field_category->isEmpty()) {
      $details->category = $product->field_category->entity->label();
    }
    $details->variant = $variant->label();
    $details->price = round($variant->getPrice()->getNumber(), 2);
    $response = $event->getResponse();
    $settings = [
      'commerceEnchancedECommerce' => $details,
    ];
    $response->addCommand(new SettingsCommand($settings, TRUE));
  }

}
