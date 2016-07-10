<?php
/**
 * @file
 */

namespace Drupal\lesson8\Logger;

use \Psr\Log\LoggerInterface;
use \Drupal\Core\Logger\RfcLoggerTrait;

/**
 * Class Lesson8Logger
 * @package Drupal\lesson8\Logger
 */
class Lesson8Logger implements LoggerInterface {
  use RfcLoggerTrait;

  /**
   * {@inheritdoc}
   */
  public function log($level, $message, array $context = array()) {
    drupal_set_message('Level - ' . $level . '. The message ' . $message);
  }
}
