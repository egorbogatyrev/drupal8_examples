<?php
/**
 * @file
 */

namespace Drupal\lesson8;

/**
 * Class Lesson8Service
 * @package Drupal\lesson8
 */
class Lesson8Service {

  protected $factory;

  public function __construct($factory) {
    $this->loggerFactory = $factory;
  }

  public function logToOtherChannels($message) {
    $this->loggerFactory->get('lesson8')->notice($message);
//    $this->loggerFactory->get('system')->error($message);
  }
}
