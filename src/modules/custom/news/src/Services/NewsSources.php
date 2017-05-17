<?php

namespace Drupal\news\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
    $request = Request::create(
      'https://www.google.com/',
      'GET',
      array('q' => 'drupal%208')
    );

//    $request = Request::create($this->url, 'GET');
    $response = new Response($request->getContent(), Response::HTTP_OK, ['content-type' => 'application/json']);
    $response->prepare($request);
    return $response->send();
  }

}
