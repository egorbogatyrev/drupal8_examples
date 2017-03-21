<?php

namespace Drupal\news\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Class NewsBlock.
 *
 * @Block(
 *   id = "newsblock",
 *   admin_label = @Translation("News Block")
 * )
 */
class NewsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array('#markup' => $this->t('This is a news block'));
  }

}
