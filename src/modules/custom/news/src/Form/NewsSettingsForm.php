<?php

namespace Drupal\news\Form;

use Drupal\block_content\Entity\BlockContent;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
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
    return 'news_settings_form';
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
    $conf = $this->config('news.settings');
    $form['apikey'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Key'),
      '#description' => $this->t('This key will be used for getting articles for specific news source.'),
      '#default_value' => $conf->get('apikey'),
      '#required' => TRUE,
    ];

    $form['sourceurl'] = [
      '#type' => 'url',
      '#title' => $this->t('Sources URL'),
      '#description' => $this->t('Setup the URL for getting news sources.'),
      '#default_value' => $conf->get('sourceurl'),
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('news.settings')
      ->set('apikey', $form_state->getValue('apikey'))
      ->set('sourceurl', $form_state->getValue('sourceurl'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
