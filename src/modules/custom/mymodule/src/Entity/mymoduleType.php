<?php

namespace Drupal\mymodule\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Defines the mymodule type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "mymodule_type",
 *   label = @Translation("mymodule type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "form" = {
 *       "add" = "Drupal\mymodule\Form\mymoduleTypeForm",
 *       "edit" = "Drupal\mymodule\Form\mymoduleTypeForm",
 *       "delete" = "Drupal\mymodule\Form\mymoduleTypeDeleteConfirm"
 *     },
 *     "list_builder" = "Drupal\mymodule\mymoduleTypeListBuilder",
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
class mymoduleType extends ConfigEntityBundleBase implements ConfigEntityInterface {

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
