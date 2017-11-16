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
 *     "list_builder" = "Drupal\mymodule\MymoduleTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\mymodule\Form\MymoduleTypeForm",
 *       "edit" = "Drupal\mymodule\Form\MymoduleTypeForm",
 *       "delete" = "Drupal\mymodule\Form\MymoduleTypeDeleteConfirm"
 *     },
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
 *     "canonical" = "/admin/structure/mymodule_type/{mymodule_type}",
 *     "add-form" = "/admin/structure/mymodule_type/add",
 *     "edit-form" = "/admin/structure/mymodule_type/{mymodule_type}/edit",
 *     "delete-form" = "/admin/structure/mymodule_type/{mymodule_type}/delete",
 *     "collection" = "/admin/structure/mymodule_type"
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
