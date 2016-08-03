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

  const LESSON8_CID = 123;

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
    $cache = \Drupal::cache('lesson8')->get($this::LESSON8_CID, TRUE);
    $message = t('There are no any cache items');
    if ($cache) {
      $is_valid = $cache->valid;
      $message = 'Cache item: ';
      $message .= $cache->data . ' - ' . ($is_valid ? 'valid' : 'invalid');
    }
    drupal_set_message($message);

    $form['message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Type a message'),
      '#required' => TRUE,
    ];

    $form['save'] = [
      '#type'  => 'submit',
      '#value' => $this->t('Save message in log & cache'),
    ];

    $form['invalidate'] = [
      '#type'  => 'submit',
      '#submit' => ['::invalidateCacheSubmit'],
      '#limit_validation_errors' => [],
      '#value' => $this->t('Invalidate cache'),
    ];

    $form['delete'] = [
      '#type'  => 'submit',
      '#submit' => ['::deleteCacheSubmit'],
      '#limit_validation_errors' => [],
      '#value' => $this->t('Delete cache'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $message = $form_state->getValue('message');
    \Drupal::cache('lesson8')->set($this::LESSON8_CID, $message);
    \Drupal::service('lesson8.service_to_log_to_multiple_channels')->logToOtherChannels($message);
    drupal_get_messages();
  }

  /**
   * Invalidate cache submit callback.
   *
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   */
  public function invalidateCacheSubmit(array &$form, FormStateInterface $form_state) {
    \Drupal::cache('lesson8')->invalidate($this::LESSON8_CID);
    drupal_get_messages();
  }

  /**
   * Invalidate cache submit callback.
   *
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   */
  public function deleteCacheSubmit(array &$form, FormStateInterface $form_state) {
    \Drupal::cache('lesson8')->delete($this::LESSON8_CID);
    drupal_get_messages();
  }
}
