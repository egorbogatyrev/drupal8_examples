<?php

namespace Drupal\news\Form;

use Drupal\Core\Form\FormBase;
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
    // Initialize header of table.
    $header = [
      '',
      $this->t('Name'),
      $this->t('Description'),
      $this->t('Operations'),
    ];

    // Fill out the rows.
    $rows = [];
    for ($i = 0; $i < 3; $i++) {
      $cells = [
        ['data' => '', 'class' => ['field-multiple-drag']],
        ['data' => ['#markup' => 'AAAAA']],
        ['data' => ['#markup' => 'JKHFKJHASDKFHAS ASHFKJHASKJF']],
        ['data' => [
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
          ]],
        ],
        ['data' => [
          '#type' => 'weight',
          '#title' => $this->t('Weight'),
          '#default_value' => '',
          '#delta' => 10,
          '#attributes' => [
            'class' => [
//              'newsblock-tabledrag',
              'delta-order',
            ],
          ],
        ]],
      ];
      $rows[] = [
        'data' => $cells,
        'class' => ['draggable', 'newsblock-tabledrag'],
      ];

//
//      $cells[$i][]['data'] = [
//        '#markup' => 'AAAAA',
//        '#attributes' => [
////          'class' => ['draggable'],
//        ],
//      ];
//      $cells[$i][]['data'] = [
//        '#markup' => 'JKHFKJHASDKFHAS ASHFKJHASKJF',
//        '#attributes' => [
////          'class' => ['draggable'],
//        ],
//      ];
//      $cells[$i][]['data'] = [
//        '#type' => 'dropbutton',
//        '#title' => $this->t('Dropbutton'),
//        '#links' => [
//          'edit' => [
//            'title' => $this->t('Edit'),
//            'url'   => Url::fromUri('https:google.com'),
//          ],
//          'delete' => [
//            'title' => $this->t('Delete'),
//            'url'   => Url::fromUri('https:yandex.ru'),
//          ],
//        ],
//        '#attributes' => [
////          'class' => ['draggable'],
//        ],
//      ];
//      $cells[$i][]['data'] = [
//        '#type' => 'weight',
//        '#title' => $this->t('Weight'),
//        '#default_value' => '',
//        '#delta' => 10,
//        '#attributes' => [
//          'class' => [
//            'newsblock-tabledrag',
//          ],
//        ],
//      ];
    }

//    $cells = [
//      ['data' => '', 'class' => ['field-multiple-drag']],
//      ['data' => $item],
//      ['data' => $delta_element, 'class' => ['delta-order']],
//    ];
//    $rows[] = [
//      'data' => $cells,
//      'class' => ['draggable'],
//    ];

    $a = 1;
    $form['blocklist'] = [
      '#theme'  => 'table',
      '#rows'   => $rows,
      '#header' => $header,
      '#tabledrag' => [
        [
          'action' => 'order',
          'relationship' => 'sibling',
          'group' => 'newsblock-tabledrag',
        ],
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
//    $this->config('news.settings')
//      ->set('tel', $form_state->getValue('tel'))
//      ->save();

    parent::submitForm($form, $form_state);
  }

}
