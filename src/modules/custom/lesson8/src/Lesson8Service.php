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

  /**
   * Lesson8Service constructor.
   *
   * @param $factory
   */
  public function __construct($factory) {
    $this->loggerFactory = $factory;
  }

  public function logToOtherChannels($message) {
    // Send a log message using lesson8 channel.
    $this->loggerFactory->get('lesson8')->emergency($message);
    // Send a log message using system channel.
    $this->loggerFactory->get('mytype')->warning($message);
  }
}
