<?php

namespace Drupal\news\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class NewsSourcesForm.
 *
 * @package Drupal\news\Form
 */
class NewsSourcesForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'news_sources_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) { }

}
