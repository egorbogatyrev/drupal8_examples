<?php

namespace Drupal\mymodule\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MymoduleTypeForm.
 *
 * @package Drupal\mymodule\Form
 */
class MymoduleTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $mymodule_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $mymodule_type->label(),
      '#description' => $this->t("Label for the Example type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $mymodule_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\mymodule\Entity\MymoduleType::load',
      ],
      '#disabled' => !$mymodule_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $mymodule_type = $this->entity;
    $status = $mymodule_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Mymodule type.', [
          '%label' => $mymodule_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Mymodule type.', [
          '%label' => $mymodule_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($mymodule_type->toUrl('collection'));
  }

}
