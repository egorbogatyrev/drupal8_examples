<?php
/**
 * @file
 */

namespace Drupal\myfirstmodule\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MyFirstModuleForm
 *
 * @package Drupal\myfirstmodule\Form
 */
class MyFirstModuleForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'myfirstmodule_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your name.'),
      '#required' => TRUE,
    );

    $form['resume'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Your brief resume.'),
      '#required' => TRUE,
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message(t('Your name is @name and your brief resume is @resume', array(
      '@name'   => $form_state->getValue('name'),
      '@resume' => $form_state->getValue('resume'),
    )));
  }
}
