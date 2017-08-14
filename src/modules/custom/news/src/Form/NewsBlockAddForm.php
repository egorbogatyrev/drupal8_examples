<?php

namespace Drupal\news\Form;

use Drupal\block_content\Entity\BlockContent;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class NewsBlockAddForm.
 *
 * @package Drupal\news\Form
 */
class NewsBlockAddForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'news_blockadd_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['desc'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Block description'),
      '#required' => TRUE,
    ];

    $formats = filter_formats();
    $form['body'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Body'),
      '#description' => $this->t('Body of block. Depends on format you can use html tags.'),
      '#default_value' => '',
      '#format' => 'basic_html',
      '#allowed_formats' => array_combine(array_keys($formats), array_keys($formats)),
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    ];

    $form['actions']['cancel'] = [
      '#type' => 'link',
      '#title' => $this->t('Cancel'),
      '#url' => Url::fromRoute('news.news_blocklist'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $block_content = BlockContent::create([
      'info' => $form_state->getValue('desc'),
      'type' => 'basic',
      'body' => [
        'value' => $form_state->getValue('body')['value'],
        'format' => $form_state->getValue('body')['format'],
      ],
    ]);
    $block_content->save();
    // Set the success message and redirect back to the list of modules.
    drupal_set_message($this->t('New block %name has been created.', ['%name' => $form_state->getValue('desc')]));
    $form_state->setRedirect('news.news_blocklist');
  }

}
