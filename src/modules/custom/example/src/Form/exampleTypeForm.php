<?php

namespace Drupal\example\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class exampleTypeForm.
 */
class exampleTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $example_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $example_type->label(),
      '#description' => $this->t("Label for the Example type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $example_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\example\Entity\exampleType::load',
      ],
      '#disabled' => !$example_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $example_type = $this->entity;
    $status = $example_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Example type.', [
          '%label' => $example_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Example type.', [
          '%label' => $example_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($example_type->toUrl('collection'));
  }

}
