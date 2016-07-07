<?php
/**
 * @file
 * Contains ...
 */
namespace Drupal\lesson3\Services;

/**
 * Class Lesson3CurrenciesService
 *
 * @package Drupal\lesson3\Services
 */
class Lesson3CurrenciesService implements Lesson3CurrenciesServiceInterface{

  protected $apiUrl;
  protected $onDate;
  protected $periodicity;
  protected $httpResponse;

  /**
   * Lesson3CurrenciesService constructor.
   */
  public function __construct($url, $onDate, $periodicity) {
    $this->apiUrl = $url;
    $this->onDate = date('Y-m-d', $onDate);
    $this->periodicity = $periodicity;
    $this->httpResponse = $this->sendHttpRequest();
  }

  /**
   * @param string $method
   *
   * @return mixed|\Psr\Http\Message\ResponseInterface
   */
  protected function sendHttpRequest($method = 'GET') {
    $guzzle = new \GuzzleHttp\Client();
    $response = $guzzle->request($method, $this->apiUrl, ['query' => [
      'onDate' => $this->onDate,
      'Periodicity' => $this->periodicity,
    ]]);
    return json_decode($response->getBody(), TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public function getCurrencies() {
    $currencies = [];
    foreach ($this->httpResponse as $currency) {
      $currencies[$currency['Cur_ID']] = $currency;
    }
    return $currencies;
  }
}
