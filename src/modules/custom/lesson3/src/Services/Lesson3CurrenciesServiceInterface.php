<?php

namespace Drupal\lesson3\Services;

interface Lesson3CurrenciesServiceInterface {
  /**
   * Lesson3CurrenciesServiceInterface constructor.
   */
  public function __construct($url, $onDate, $periodicity);

  /**
   * Get currencies method.
   *
   * @return mixed
   */
  public function getCurrencies();
}
