<?php

/**
 * @file
 * Controller class file for MyFirstModule module.
 */

namespace Drupal\myfirstmodule\Controller;
use Drupal\Core\Controller\ControllerBase;

/**
 * Class MyFirstModuleController
 *
 * @package Drupal\myfirstmodule\Controller
 */
class MyFirstModuleController extends ControllerBase {

  /**
   * SayHello method.
   *
   * @return mixed
   *   Array of content properties.
   */
  public function sayHello() {
    $output['#title']  = 'SayHello page';
    $output['#markup'] = 'Come on guy! Say Hello!';
    return $output;
  }
}
