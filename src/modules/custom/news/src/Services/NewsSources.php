<?php

namespace Drupal\news\Services;

use GuzzleHttp\Client;

/**
 * Class NewsSources.
 *
 * @package Drupal\news\Services
 */
class NewsSources {

  /**
   * Newsapi url.
   *
   * @var
   */
  protected $url;

  /**
   * NewsSources constructor.
   */
  public function __construct($url) {
    $this->url = $url;
  }

  /**
   * Returns the list of news sources.
   */
  public function get() {
    $client = new Client();
    $request = $client->request('GET', $this->url);
    $request = \GuzzleHttp\json_decode($request->getBody());
    return $request->sources;
  }

}
