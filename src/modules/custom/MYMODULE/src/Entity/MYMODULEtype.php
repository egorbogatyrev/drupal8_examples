<?php

namespace Drupal\MYMODULE\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Defines the MYMODULE type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "MYMODULE_type",
 *   label = @Translation("MYMODULE type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "form" = {
 *       "add" = "Drupal\MYMODULE\Form\MYMODULETypeForm",
 *       "edit" = "Drupal\MYMODULE\Form\MYMODULETypeForm",
 *       "delete" = "Drupal\MYMODULE\Form\MYMODULETypeDeleteConfirm"
 *     },
 *     "list_builder" = "Drupal\MYMODULE\MYMODULETypeListBuilder",
 *   },
 *   admin_permission = "administer content types",
 *   config_prefix = "MYMODULE_type",
 *   bundle_of = "MYMODULE",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/MYMODULE/types/MYMODULE_type/{MYMODULE_type}",
 *     "add-form" = "/admin/MYMODULE/types/MYMODULE_type/add",
 *     "edit-form" = "/admin/MYMODULE/types/MYMODULE_type/{MYMODULE_type}/edit",
 *     "delete-form" = "/admin/MYMODULE/types/MYMODULE_type/{MYMODULE_type}/delete",
 *     "collection" = "/admin/MYMODULE/types/MYMODULE_type"
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
class MYMODULEtype extends ConfigEntityBundleBase implements ConfigEntityInterface {

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
