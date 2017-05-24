<?php

namespace Drupal\news\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Url;

/**
 * Class NewsSettingsForm.
 *
 * @package Drupal\news\Form
 */
class NewsSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'news_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return ['system.cron'];
  }

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    parent::__construct($config_factory);
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    drupal_set_message(t('Drupal test message.'));

    $form = parent::buildForm($form, $form_state);
    // HTML 5 elements.
    $form['tel'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone'),
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
    ];
    $form['number'] = [
      '#type' => 'number',
      '#title' => $this->t('Number'),
    ];
    $form['date'] = [
      '#type' => 'date',
      '#title' => $this->t('Date'),
    ];
    $form['url'] = [
      '#type' => 'url',
      '#title' => $this->t('Url'),
    ];
    $form['search'] = [
      '#type' => 'search',
      '#title' => $this->t('Search'),
      '#attributes' => ['placeholder' => $this->t('Search field. Type something...')],
    ];
    $form['range'] = [
      '#type' => 'range',
      '#title' => $this->t('Range'),
      '#min' => 0,
      '#max' => 100,
      '#step' => 50,
    ];

    $form['separator'] = [
      '#type' => 'html_tag',
      '#tag' => 'hr',
    ];
    // New other elements.
    $form['color'] = [
      '#type' => 'color',
      '#title' => $this->t('Color'),
      '#default_value' => '#f00f00',
    ];
    $form['details'] = [
      '#type' => 'details',
      '#title' => $this->t('Details'),
    ];
    $form['dropbutton'] = [
      '#type' => 'dropbutton',
      '#title' => $this->t('Dropbutton'),
      '#links' => array(
        'link1' => [
          'title' => $this->t('Google'),
          'url'   => Url::fromUri('https:google.com'),
        ],
        'link2' => [
          'title' => $this->t('Yandex'),
          'url'   => Url::fromUri('https:yandex.ru'),
        ],
      ),
    ];
    $form['fieldgroup'] = [
      '#type' => 'fieldgroup',
      '#title' => $this->t('Fieldgroup'),
    ];
    $form['html_tag'] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $this->t('This text is wrapped by html_tag'),
    ];
    $form['inline_template'] = [
      '#type' => 'inline_template',
      '#template' => "{% trans %} This is {% endtrans %} <strong>{{name}}</strong>",
      '#context' => [
        'name' => 'example',
      ],
    ];
    $form['language_select'] = [
      '#type' => 'language_select',
      '#title' => $this->t('Language Select'),
      '#languages' => LanguageInterface::STATE_CONFIGURABLE | LanguageInterface::STATE_SITE_DEFAULT,
      //'#languages' => LanguageInterface::STATE_ALL,
    ];
    $form['more_link'] = [
      '#type' => 'more_link',
      '#url' => Url::fromUri('https:yandex.ru'),
    ];

    $links['delete'] = [
      'title' => $this->t('Delete'),
      'url' => Url::fromUri('https:yandex.ru'),
    ];
    $links['delete_items'] = [
      'title' => $this->t('Delete items'),
      'url' => Url::fromUri('https:yandex.ru'),
    ];
    $links['update'] = [
      'title' => $this->t('Update items'),
      'url' => Url::fromUri('https:yandex.ru'),
    ];
    $form['operations'] = [
      '#type' => 'operations',
      '#links' => $links,
      '#title' => $this->t('operations'),
    ];

    $form['page'] = [
      '#type' => 'page',
      '#show_messages' => FALSE,
      'content' => 'THIS IS PAGE',
    ];

    $form['status_messages'] = [
      '#type' => 'status_messages',
    ];

    $form['status_report'] = [
      '#type' => 'status_report',
      '#requirements' => 'djasjdlkajsdljsalkl',
      '#prefix' => $this->t('status_report'),
    ];

    $form['system_compact_link'] = [
      '#type' => 'system_compact_link',
      '#title' => $this->t('system_compact_link'),
    ];

    return $form;
  }

}
