<?php

namespace Drupal\news\Form;

use Drupal\block_content\Entity\BlockContent;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class NewsBlockListForm.
 *
 * @package Drupal\news\Form
 */
class NewsBlockListForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'news_blocklist_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return ['news.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $conf = $this->config('news.settings')->get('blocklist');

    // Rename the save button.
    $form['actions']['submit']['#value'] = $this->t('Save');

    // Initialize header of table.
    $header = [
      $this->t('Name'),
      $this->t('Description'),
      $this->t('Operations'),
      $this->t('Weight'),
    ];

    // Initialize the table.
    $form['blocklist'] = [
      '#type' => 'table',
      '#header' => $header,
      '#attributes' => [
        'id' => 'news-blocklist',
      ],
      '#tabledrag' => [
        [
          'action' => 'order',
          'relationship' => 'sibling',
          'group' => 'newsblock-tabledrag',
        ],
      ],
    ];

    $blocks = BlockContent::loadMultiple();
    /** @var  BlockContent $block */
    foreach ($blocks as $i => $block) {
      $weight = isset($conf[$i]['weight']) ? $conf[$i]['weight'] : 0;
      $form['blocklist'][$i]['#attributes']['class'][] = 'draggable';
      $form['blocklist'][$i]['#weight'] = $weight;
      $form['blocklist'][$i]['name']['#markup'] = $block->get('info')->getString();
      $form['blocklist'][$i]['desc']['#markup'] = $block->get('info')->getString();
      $form['blocklist'][$i]['options'] = [
        '#type' => 'dropbutton',
        '#title' => $this->t('Dropbutton'),
        '#links' => [
          'edit' => [
            'title' => $this->t('Edit'),
            'url'   => Url::fromUri('https:google.com'),
          ],
          'delete' => [
            'title' => $this->t('Delete'),
            'url'   => Url::fromUri('https:yandex.ru'),
          ],
        ],
      ];
      $form['blocklist'][$i]['weight'] = [
        '#type' => 'weight',
        '#title' => $this->t('Weight'),
        '#title_display' => 'invisible',
        '#default_value' => $weight,
        '#delta' => 10,
        '#attributes' => ['class' => ['newsblock-tabledrag']],
      ];
    }

    // Sort table rows.
    uasort($form['blocklist'], [$this, 'sortRows']);

    return $form;
  }

  /**
   * Sorts table rows by weight.
   */
  protected function sortRows($a, $b) {
    return !isset($a['#weight'], $b['#weight']) ? FALSE : ($a['#weight'] - $b['#weight']);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('news.settings')
      ->set('blocklist', $form_state->getValue('blocklist'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
