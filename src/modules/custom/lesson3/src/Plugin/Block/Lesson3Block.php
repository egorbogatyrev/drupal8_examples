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
    // Example query.
    $header_0 = array(
      array('data' => 'wid'),
      array('data' => 'type'),
      array('data' => 'timestamp'),
    );
    $query_0 = db_select('watchdog', 'd')->extend('Drupal\Core\Database\Query\PagerSelectExtender')->element(0);
    $query_0->fields('d', array('wid', 'type', 'timestamp'));
    $result_0 = $query_0
      ->limit(5)
      ->orderBy('d.wid')
      ->execute();
    $rows_0 = array();
    foreach ($result_0 as $row) {
      $rows_0[] = array('data' => (array) $row);
    }
    $build['pager_table_0'] = array(
      '#theme' => 'table',
      '#header' => $header_0,
      '#rows' => $rows_0,
      '#empty' => $this->t("There are no watchdog records found in the db"),
    );
    
    
    $service = \Drupal::service('lesson3.currencies_service');
    return ['#markup' => $service->getCurrencies()];
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
