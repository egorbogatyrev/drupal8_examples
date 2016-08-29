<?php

namespace Drupal\lesson4\Render\Element;

use Drupal\Core\Render\Element\FormElement;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class Lesson4Element.
 *
 * @FormElement("lesson4element")
 */
class Lesson4Element extends FormElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#input' => TRUE,
      '#name' => 'lesson4button',
      '#process' => array(
        array($class, 'processLesson4Element'),
        array($class, 'processAjaxForm'),
      ),
      '#pre_render' => array(
        array($class, 'preRenderLesson4Element'),
      ),
//      '#theme_wrappers' => array('input__submit'),
    ];
  }

  /**
   * @param                                      $element
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   * @param                                      $complete_form
   */
  public static function processLesson4Element(&$element, FormStateInterface $form_state, &$complete_form) {
    return $element;
  }

  /**
   * @param $element
   */
  public static function preRenderLesson4Element($element) {
    return $element;
  }

}
