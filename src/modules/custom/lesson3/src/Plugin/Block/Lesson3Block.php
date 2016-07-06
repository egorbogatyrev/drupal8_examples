<?php
/**
 * @file
 * Contains \Drupal\lesson3\Plugin\Block\Lesson3Block.
 */

namespace Drupal\lesson3\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class Lesson3Block
 *
 * @package Drupal\lesson3\Plugin\Block
 *
 * @Block(
 *   id = "lesson3block",
 *   admin_label = @Translation("Lesson 3 custom block")
 * )
 */
class Lesson3Block extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'label_display' => FALSE,
      'lesson3_desc' => $this->t('Default description of block'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return ['#markup' => $this->t('Simple block from Lesson 3')];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['lesson3_desc'] = [
      '#type' => 'textarea',
      '#title' => t('Description of custom block'),
      '#description' => $this->t('This this a block description.'),
      '#default_value' => $this->configuration['lesson3_desc'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['lesson3_desc'] = $form_state->getValue('lesson3_desc');
  }
}
