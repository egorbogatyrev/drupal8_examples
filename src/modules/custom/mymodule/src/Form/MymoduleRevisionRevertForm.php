<?php

namespace Drupal\mymodule\Form;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\mymodule\Entity\MymoduleInterface;
use Drupal\mymodule\Entity\MymoduleType;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for reverting a mymodule revision.
 */
class MymoduleRevisionRevertForm extends ConfirmFormBase {

  /**
   * The mymodule revision.
   *
   * @var \Drupal\mymodule\Entity\MymoduleInterface
   */
  protected $revision;

  /**
   * The mymodule storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $mymoduleStorage;

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Constructs a new MymoduleRevisionRevertForm.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $mymodule_storage
   *   The mymodule storage.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   */
  public function __construct(EntityStorageInterface $mymodule_storage, DateFormatterInterface $date_formatter) {
    $this->mymoduleStorage = $mymodule_storage;
    $this->dateFormatter = $date_formatter;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager')->getStorage('mymodule'),
      $container->get('date.formatter')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mymodule_revision_revert_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure you want to revert to the revision from %revision-date?', ['%revision-date' => $this->dateFormatter->format($this->revision->getRevisionCreationTime())]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.mymodule.version_history', ['mymodule' => $this->revision->id()]);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Revert');
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return '';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $mymodule_revision = NULL) {
    $this->revision = $this->mymoduleStorage->loadRevision($mymodule_revision);
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // The revision timestamp will be updated when the revision is saved. Keep
    // the original one for the confirmation message.
    $original_revision_timestamp = $this->revision->getRevisionCreationTime();

    $this->revision = $this->prepareRevertedRevision($this->revision, $form_state);
    $this->revision->revision_log = t('Copy of the revision from %date.', ['%date' => $this->dateFormatter->format($original_revision_timestamp)]);
    $this->revision->setRevisionCreationTime(\Drupal::time()->getRequestTime());
    $this->revision->setChangedTime(\Drupal::time()->getRequestTime());
    $this->revision->save();

    $this->logger('content')->notice('@type: reverted %title revision %revision.', [
      '@type' => $this->revision->bundle(),
      '%title' => $this->revision->label(),
      '%revision' => $this->revision->getRevisionId(),
    ]);

    $type = MymoduleType::load($this->revision->bundle());
    drupal_set_message(t('@type %title has been reverted to the revision from %revision-date.', [
      '@type' => $type ? $type->label() : FALSE,
      '%title' => $this->revision->label(),
      '%revision-date' => $this->dateFormatter->format($original_revision_timestamp),
    ]));

    $form_state->setRedirect(
      'entity.mymodule.version_history',
      ['mymodule' => $this->revision->id()]
    );
  }

  /**
   * Prepares a revision to be reverted.
   *
   * @param \Drupal\mymodule\Entity\MymoduleInterface $revision
   *   The revision to be reverted.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return \Drupal\mymodule\Entity\MymoduleInterface
   *   The prepared revision ready to be stored.
   */
  protected function prepareRevertedRevision(MymoduleInterface $revision, FormStateInterface $form_state) {
    $revision->setNewRevision();
    $revision->isDefaultRevision(TRUE);

    return $revision;
  }

}
