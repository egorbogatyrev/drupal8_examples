<?php

namespace Drupal\lesson4\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class Lesson4Controller.
 *
 * @package Drupal\lesson4\Controller
 */
class Lesson4Controller extends ControllerBase {

  /**
   * Outputs the currencies page.
   */
  public function pageOutput() {
    return [
      '#markup' => t('This is the test page'),
      '#prefix' => '<span class="lesson4">',
      '#suffix' => '</span>',
      '#attached' => [
        'library' => [
          'lesson4/lesson4-library',
        ],
      ],
    ];
  }

}
