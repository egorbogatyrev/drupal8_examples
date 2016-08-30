<?php

namespace Drupal\lesson4\Plugin\Block;

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
    $output['#markup'] = t('Render array example');
    $output['lesson4element'] = [
      '#type' => 'lesson4element',
      '#label' => 'Lesson4 element',
      '#options1' => range(0, 10),
      '#options2' => range(10, 20),
    ];

    return $output;
  }

}
