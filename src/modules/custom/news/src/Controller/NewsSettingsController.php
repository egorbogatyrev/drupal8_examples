<?php

namespace Drupal\news\Controller;

/**
 * Class NewsSettingsController.
 *
 * @package Drupal\news\Controller
 */
class NewsSettingsController {

  /**
   * Returns settings page.
   */
  public function getSettingsPage() {
    $service = \Drupal::service('news.sources');
    $sources = $service->get();
    return $sources;
  }

}
