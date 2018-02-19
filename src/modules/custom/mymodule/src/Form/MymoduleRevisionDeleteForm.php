<?php

namespace Drupal\mymodule\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for reverting a mymodule revision.
 */
class MymoduleRevisionDeleteForm extends ConfirmFormBase {

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
   * The mymodule type storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $mymoduleTypeStorage;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * Constructs a new MymoduleRevisionDeleteForm.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $mymodule_storage
   *   The mymodule storage.
   * @param \Drupal\Core\Entity\EntityStorageInterface $mymodule_type_storage
   *   The mymodule type storage.
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   */
  public function __construct(EntityStorageInterface $mymodule_storage, EntityStorageInterface $mymodule_type_storage, Connection $connection) {
    $this->mymoduleStorage = $mymodule_storage;
    $this->mymoduleTypeStorage = $mymodule_type_storage;
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $entity_manager = $container->get('entity.manager');
    return new static(
      $entity_manager->getStorage('mymodule'),
      $entity_manager->getStorage('mymodule_type'),
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mymodule_revision_delete_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure you want to delete the revision from %revision-date?', ['%revision-date' => format_date($this->revision->getRevisionCreationTime())]);
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
    return t('Delete');
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
    $this->mymoduleStorage->deleteRevision($this->revision->getRevisionId());

    $this->logger('content')->notice('@type: deleted %title revision %revision.', [
      '@type' => $this->revision->bundle(),
      '%title' => $this->revision->label(),
      '%revision' => $this->revision->getRevisionId(),
    ]);

    $mymodule_type = $this->mymoduleTypeStorage->load($this->revision->bundle())->label();
    drupal_set_message(t('Revision from %revision-date of @type %title has been deleted.', [
      '%revision-date' => \Drupal::service('date.formatter')->format($this->revision->getRevisionCreationTime()),
      '@type' => $mymodule_type,
      '%title' => $this->revision->label(),
    ]));

    $form_state->setRedirect(
      'entity.mymodule.canonical',
      ['mymodule' => $this->revision->id()]
    );

    // Select revisions from DB.
    $query = $this->connection->select('mymodule_field_revision', 't');
    $query->addExpression('COUNT(DISTINCT t.vid)');
    $query->condition('t.id', $this->revision->id());

    // If revisions more than 1 user will be redirected to version history page.
    if ($query->execute()->fetchField() > 1) {
      $form_state->setRedirect(
        'entity.mymodule.version_history',
        ['mymodule' => $this->revision->id()]
      );
    }
  }

}
