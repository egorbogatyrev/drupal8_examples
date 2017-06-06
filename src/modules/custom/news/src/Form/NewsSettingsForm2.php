<?php

namespace Drupal\news\Form;

use Drupal\Core\Asset\AssetCollectionOptimizerInterface;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\PerformanceForm;

/**
 * Class NewsSettingsForm2.
 *
 * @package Drupal\news\Form
 */
class NewsSettingsForm2 extends ConfigFormBase {

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
    return ['news.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!preg_match('/\+81[\d]{9}/', $form_state->getValue('tel'))) {
      $form_state->setErrorByName('tel', $this->t('Incorrect phone number. Please verify the format +81xxxxxxxxx.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('news.settings')
      ->set('tel', $form_state->getValue('tel'))
      ->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = \Drupal::formBuilder()->getForm('Drupal\system\Form\PerformanceForm');

    $container = \Drupal::getContainer();
    /** @var ConfigFactoryInterface $config_factory */
    $config_factory = $container->get('config.factory');
    /** @var CacheBackendInterface $render_cache */
    $render_cache = $container->get('cache.render');
    /** @var DateFormatterInterface $date_formatter */
    $date_formatter = $container->get('date.formatter');
    /** @var AssetCollectionOptimizerInterface $css_collection_optimizer */
    $css_collection_optimizer = $container->get('asset.css.collection_optimizer');
    /** @var AssetCollectionOptimizerInterface $js_collection_optimizer */
    $js_collection_optimizer = $container->get('asset.js.collection_optimizer');

    $form_builder = \Drupal::formBuilder();
    $form_object  = new PerformanceForm($config_factory, $render_cache, $date_formatter, $css_collection_optimizer, $js_collection_optimizer);
    $form = $form_builder->getForm($form_object);

//    $form = parent::buildForm($form, $form_state);
//    $form['tel'] = [
//      '#type' => 'tel',
//      '#title' => $this->t('Phone'),
//      '#description' => $this->t('The phone number should be in Japan format +81xxxxxxxxx.'),
//      '#placeholder' => '+81xxxxxxxxx',
//      '#required' => TRUE,
//      '#default_value' => $this->config('news.settings')->get('tel'),
//    ];

    return $form;
  }

}
