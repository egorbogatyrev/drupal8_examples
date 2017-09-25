<?php

namespace Drupal\MYMODULE\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\node\NodeTypeInterface;

/**
 * Defines the MYMODULE type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "MYMODULE_type",
 *   label = @Translation("MYMODULE type"),
 *   handlers = {
 *     "access" = "Drupal\core\Entity\EntityAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\MYMODULE\MYMODULETypeForm",
 *       "edit" = "Drupal\MYMODULE\MYMODULETypeForm",
 *       "delete" = "Drupal\MYMODULE\Form\MYMODULETypeDeleteConfirm"
 *     },
 *     "list_builder" = "Drupal\Core\Config\Entity\ConfigEntityListBuilder",
 *   },
 *   admin_permission = "administer content types",
 *   config_prefix = "type",
 *   bundle_of = "MYMODULE",
 *   entity_keys = {
 *     "id" = "type",
 *     "label" = "name"
 *   },
 *   links = {
 *     "edit-form" = "/admin/structure/types/manage/{MYMODULE_type}",
 *     "delete-form" = "/admin/structure/types/manage/{MYMODULE_type}/delete",
 *     "collection" = "/admin/structure/types",
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

}
