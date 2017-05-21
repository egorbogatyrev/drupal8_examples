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
    return ['#markup' => '<pre>' . json_encode($service->get(), JSON_PRETTY_PRINT) . '</pre>'];
  }

}
