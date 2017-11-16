<?php

namespace Drupal\mymodule\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Defines the Mymodule type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "mymodule_type",
 *   label = @Translation("mymodule type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "form" = {
 *       "add" = "Drupal\mymodule\Form\MymoduleTypeForm",
 *       "edit" = "Drupal\mymodule\Form\MymoduleTypeForm",
 *       "delete" = "Drupal\mymodule\Form\MymoduleTypeDeleteConfirm"
 *     },
 *     "list_builder" = "Drupal\mymodule\MymoduleTypeListBuilder",
 *   },
 *   admin_permission = "administer content types",
 *   config_prefix = "mymodule_type",
 *   bundle_of = "mymodule",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/mymodule/types/mymodule_type/{mymodule_type}",
 *     "add-form" = "/admin/mymodule/types/mymodule_type/add",
 *     "edit-form" = "/admin/mymodule/types/mymodule_type/{mymodule_type}/edit",
 *     "delete-form" = "/admin/mymodule/types/mymodule_type/{mymodule_type}/delete",
 *     "collection" = "/admin/mymodule/types/mymodule_type"
 *   },
 *   config_export = {
 *     "name",
 *     "type",
 *     "description",
 *     "help",
 *     "new_revision",
 *     "preview_mode",
 *     "display_submitted",
 *   }
 * )
 */
class MymoduleType extends ConfigEntityBundleBase implements ConfigEntityInterface {

  /**
   * The Example type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Example type label.
   *
   * @var string
   */
  protected $label;

}
