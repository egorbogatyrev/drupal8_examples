<?php

namespace Drupal\lesson3\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class MyFirstModuleController.
 *
 * @package Drupal\myfirstmodule\Controller
 */
class Lesson3Controller extends ControllerBase {

  /**
   * Outputs the currencies page.
   */
  public function outputCurrencies() {
    $service = \Drupal::service('lesson3.currencies_service');
    return $service->getCurrenciesTable();
  }

}
