<?php

namespace Drupal\myfirstmodule\Controller;
use Drupal\Core\Controller\ControllerBase;

class MyFirstModuleController extends ControllerBase {

  public function sayHello() {
    $output['#title'] = 'SayHello page';
    $output['#markup'] = 'Common guy! Say Hello!';
    return $output;
  }
}
