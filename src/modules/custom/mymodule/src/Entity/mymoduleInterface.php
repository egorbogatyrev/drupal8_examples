<?php

namespace Drupal\mymodule\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a Contact entity.
 *
 * We have this interface so we can join the other interfaces it extends.
 *
 * @ingroup content_entity_example
 */
interface MymoduleInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

}
