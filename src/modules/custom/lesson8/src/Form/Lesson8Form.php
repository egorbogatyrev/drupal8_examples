<?php

/**
 * @file
 *
 */

namespace Drupal\lesson8\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class Lesson8FormController
 * @package Drupal\lesson8\Form
 */
class Lesson8Form extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'lesson8-form-id';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Type a message'),
      '#required' => TRUE,
    ];

    $form['save'] = [
      '#type'  => 'submit',
      '#value' => $this->t('Send'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $message = $form_state->getValue('message');
//    drupal_set_message($message);

    \Drupal::service('lesson8.logger')->error($message);

    \Drupal::service('lesson8.service_to_log_to_multiple_channels')->logToOtherChannels($message);

    // Send message to log.
//    \Drupal::logger('lesson8')->emergency($message);
//    \Drupal::logger('lesson8')->alert($message);
//    \Drupal::logger('lesson8')->critical($message);
//    \Drupal::logger('lesson8')->error($message);
//    \Drupal::logger('lesson8')->warning($message);
//    \Drupal::logger('lesson8')->notice($message);
//    \Drupal::logger('lesson8')->info($message);
//    \Drupal::logger('lesson8')->debug($message);
  }
}

