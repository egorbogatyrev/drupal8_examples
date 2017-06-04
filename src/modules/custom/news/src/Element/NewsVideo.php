<?php

namespace Drupal\news\Element;

use Drupal\Core\Render\Element;
use Drupal\Core\Render\Element\RenderElement;

/**
 * Class NewsVideo.
 *
 * @RenderElement("newsvideo")
 */
class NewsVideo extends RenderElement {
  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#name'   => 'news-video',
      '#theme'  => 'newsvideo',
      '#controls' => TRUE,
      '#autoplay' => FALSE,
      '#novideo'  => $this->t('Your browser does not support the video tag.'),
      '#pre_render' => [
        [$class, 'preRenderVideo'],
      ],
    ];
  }

  /**
   * Prepares a video render element for newsvideo.html.twig.
   *
   * @param array $element
   *   An associative array containing the properties of the element.
   *
   * @return array
   *   The $element with prepared variables ready for newsvideo.html.twig.
   */
  public static function preRenderVideo($element) {
    $element['#attributes']['type'] = 'button';
    Element::setAttributes($element, ['id', 'name']);

    // Verify attributes.
    $attr = ['controls', 'autoplay', 'width', 'height'];
    foreach ($attr as $val) {
      if (!empty($element['#' . $val])) {
        $element['#attributes'][$val] = $element['#' . $val];
      }
    }

    // Process the sources types.
    foreach ($element['#sources'] as $src => $type) {
      $element['#sources'][$src] = 'video/' . $type;
    }

    $element['#attributes']['class'][] = 'html5-video';

    return $element;
  }
}
