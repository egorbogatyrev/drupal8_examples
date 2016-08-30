<?php

namespace Drupal\lesson4\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

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

  /**
   * Sends the response.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   Response object.
   */
  public function sendResponse() {
    $response = new Response(
      'Content',
      Response::HTTP_OK,
      array('content-type' => 'text/html')
    );
    $response->setContent('Lesson 4 Response example');

    return $response;
  }

}
