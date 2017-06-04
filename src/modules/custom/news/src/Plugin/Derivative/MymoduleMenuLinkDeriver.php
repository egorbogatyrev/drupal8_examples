<?php

namespace Drupal\news\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;

/**
 * Class MymoduleMenuLinkDeriver.
 *
 * @package Drupal\news\Plugin\Derivative
 */
class MymoduleMenuLinkDeriver extends DeriverBase {

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    $this->derivatives['news.menu_link'] = $base_plugin_definition;
    $this->derivatives['news.menu_link']['title'] = 'MYMODULE Dynamic link';
    $this->derivatives['news.menu_link']['description'] = 'MYMODULE Dynamic link description';
    $this->derivatives['news.menu_link']['route_name'] = 'system.modules_list';
    $this->derivatives['news.menu_link']['parent'] = 'system.admin_config_services';

    return parent::getDerivativeDefinitions($base_plugin_definition);
  }

}
