<?php

namespace \Drupal\lesson4\Plugin\Block;

use \Drupal\Core\Block\BlockBase;

/**
 * Class Lesson4Block.
 *
 * @Block(
 *   id = "lesson4block",
 *   admin_label = @Translation("Lesson 4 block")
 * )
 */
class Lesson4Block extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $output = [
      '#markup' => t('Render array example'),
    ];
    return $output;
  }

}
