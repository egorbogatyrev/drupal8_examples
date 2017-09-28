<?php

namespace Drupal\MYMODULE\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\MYMODULE\MYMODULEInterface;
use Drupal\user\UserInterface;

// *     "storage" = "Drupal\MYMODULE\MyModuleStorage",
// *     "storage_schema" = "Drupal\MYMODULE\MyModuleStorageSchema",
// *   list_cache_contexts = { "user.node_grants:view" },
// *   field_ui_base_route = "entity.MYMODULE_type.edit_form",

//*   handlers = {
//  *     "storage" = "Drupal\Core\Entity\Sql\SqlContentEntityStorage",
// *      "storage_schema" = "Drupal\Core\Entity\Sql\SqlContentEntityStorageSchema",
// *   data_table = "MYMODULE_data",
// *   revision_table = "MYMODULE_revision",
// *   revision_data_table = "MYMODULE_data_revision",

/**
 * Class MYMODULE.
 *
 * @ContentEntityType(
 *   id = "MYMODULE",
 *   label = @Translation("MYMODULE"),
 *   bundle_label = @Translation("MYMODULE type"),
 *   handlers = {
 *     "list_builder" = "Drupal\Core\Entity\EntityListBuilder",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "translation" = "Drupal\content_translation\ContentTranslationHandler",
 *     "access" = "Drupal\core\Entity\EntityAccessControlHandler",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "default" = "Drupal\MYMODULE\Form\MYMODULEForm",
 *       "add" = "Drupal\MYMODULE\Form\MYMODULEForm",
 *       "edit" = "Drupal\MYMODULE\Form\MYMODULEForm",
 *       "delete" = "Drupal\MYMODULE\Form\MYMODULEDeleteForm",
 *     },
 *   },
 *   base_table = "MYMODULE",
 *   data_table = "MYMODULE_data",
 *   revision_table = "MYMODULE_revision",
 *   revision_data_table = "MYMODULE_data_revision",
 *   show_revision_ui = TRUE,
 *   translatable = TRUE,
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "bundle" = "type",
 *     "label" = "title",
 *     "langcode" = "langcode",
 *     "uuid" = "uuid",
 *     "status" = "status",
 *     "uid" = "uid",
 *   },
 *   bundle_entity_type = "MYMODULE_type",
 *   common_reference_target = TRUE,
 *   permission_granularity = "bundle",
 *   field_ui_base_route = "entity.MYMODULE_type.edit_form",
 *   links = {
 *     "canonical" = "/MYMODULE/{MYMODULE}",
 *     "delete-form" = "/MYMODULE/{MYMODULE}/delete",
 *     "edit-form" = "/MYMODULE/{MYMODULE}/edit",
 *     "version-history" = "/MYMODULE/{MYMODULE}/revisions",
 *     "revision" = "/MYMODULE/{MYMODULE}/revisions/{MYMODULE_revision}/view",
 *   }
 * )
 */
class MYMODULE extends ContentEntityBase implements MYMODULEInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return $this->bundle();
  }

  /**
   * @param int $uid
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   *
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   *
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * @param \Drupal\user\UserInterface $account
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setRevisionable(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The username of the content author.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time that the MYMODULE was created.'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'timestamp',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the MYMODULE was last edited.'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    $fields['revision_timestamp'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Revision timestamp'))
      ->setDescription(t('The time that the current revision was created.'))
      ->setQueryable(FALSE)
      ->setRevisionable(TRUE);

    $fields['revision_uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Revision user ID'))
      ->setDescription(t('The user ID of the author of the current revision.'))
      ->setSetting('target_type', 'user')
      ->setQueryable(FALSE)
      ->setRevisionable(TRUE);

    $fields['revision_log'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Revision log message'))
      ->setDescription(t('Briefly describe the changes you have made.'))
      ->setRevisionable(TRUE)
      ->setDefaultValue('')
      ->setDisplayOptions('form', [
        'type' => 'string_textarea',
        'weight' => 25,
        'settings' => [
          'rows' => 4,
        ],
      ]);

    return $fields;
  }

}
