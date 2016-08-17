(function ($, Drupal, settings) {
  'use strict';
  Drupal.behaviors.lesson4 = {
    attach: function (context, settings) {
      var content  = $('span.lesson4', 'div.content'),
      default_text = content.text();

      content.text(default_text + ' - ' + Drupal.t('Text is added by Javascript'));
    }
  }
}) (jQuery, Drupal, drupalSettings);
