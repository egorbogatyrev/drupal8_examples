<?php

namespace Drupal\lesson4\Element;

use Drupal\Core\Render\Element\RenderElement;

/**
 * Class Lesson4Element.
 *
 * @FormElement("lesson4element")
 */
class Lesson4Element extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#input' => TRUE,
      '#label' => 'Default label',
      '#description' => t('Default description'),
      '#options1' => [],
      '#options2' => [],
      '#process'  => [
        [$class, 'processAjaxForm'],
      ],
      '#pre_render' => [
        [$class, 'preRenderLesson4Element'],
      ],
    ];
  }

  /**
   * Pre render processing for element.
   *
   * @param object $element
   *   The object of element.
   *
   * @return mixed
   *   Modified element object.
   */
  public static function preRenderLesson4Element($element) {
    $element['lesson4element'] = [
      '#type' => 'item',
      '#description_display' => 'invisible',
      '#title' => $element['#label'],
      '#field_prefix' => '<div class="container-inline">',
      '#field_suffix' => '</div>',
      '#description' => $element['#description'],
    ];

    $element['lesson4element']['one'] = [
      '#type' => 'select',
      '#options' => $element['#options1'],
      '#field_suffix' => ' &nbsp; ',
    ];

    $element['lesson4element']['two'] = [
      '#type' => 'select',
      '#options' => $element['#options2'],
    ];

    return $element;
  }

}
