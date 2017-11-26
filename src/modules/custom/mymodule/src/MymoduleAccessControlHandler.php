<?php

namespace Drupal\mymodule;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Mymodule entity.
 *
 * @see \Drupal\mymodule\Entity\mymodule.
 */
class MymoduleAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\example\Entity\exampleInterface $entity */
    $permission = '';
    switch ($operation) {
      case 'view':
        $permission = !$entity->isPublished() ? 'view unpublished mymodule entities' : 'view published mymodule entities';
        break;

      case 'update':
        $permission = 'edit mymodule entities';
        break;

      case 'delete':
        $permission = 'delete mymodule entities';
        break;
    }

    return $permission ? AccessResult::allowedIfHasPermission($account, $permission) : AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add mymodule entities');
  }

}
