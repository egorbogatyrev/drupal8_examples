<?php

namespace Drupal\example\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Example type entity.
 *
 * @ConfigEntityType(
 *   id = "example_type",
 *   label = @Translation("Example type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\example\exampleTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\example\Form\exampleTypeForm",
 *       "edit" = "Drupal\example\Form\exampleTypeForm",
 *       "delete" = "Drupal\example\Form\exampleTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\example\exampleTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "example_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "example",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/example_type/{example_type}",
 *     "add-form" = "/admin/structure/example_type/add",
 *     "edit-form" = "/admin/structure/example_type/{example_type}/edit",
 *     "delete-form" = "/admin/structure/example_type/{example_type}/delete",
 *     "collection" = "/admin/structure/example_type"
 *   }
 * )
 */
class exampleType extends ConfigEntityBundleBase implements exampleTypeInterface {

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
