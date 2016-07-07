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
  // The url of API NBRB.
  protected $apiUrl;
  // The date of currencies.
  protected $onDate;
  // Periodicity (monthly or daily).
  protected $periodicity;
  // Http response variable. Stores info returned by service.
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
   * Sends the http request with aim to get currencies list.
   *
   * @param string $method
   *   Http request method.
   *
   * @return mixed|\Psr\Http\Message\ResponseInterface
   */
  protected function sendHttpRequest($method = 'GET') {
    $guzzle = new \GuzzleHttp\Client();
    $response = $guzzle->request($method, $this->apiUrl, ['query' => [
      'onDate' => $this->getCurrenciesDate(),
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

  /**
   * Returns the date for currencies.
   *
   * @return mixed
   */
  public function getCurrenciesDate() {
    return $this->onDate;
  }

  /**
   * Returns the table of currencies for specific date.
   */
  public function getCurrenciesTable($selectedCurrencies = []) {
    $header = [
      ['data' => 'Currencies course'],
      ['data' => $this->getCurrenciesDate()],
    ];

    $rows = [];
    foreach ($this->getCurrencies() as $curId => $currency) {
      if (!empty($selectedCurrencies) && !in_array($curId, $selectedCurrencies)) {
        continue;
      }

      $rows[$curId][] = $currency['Cur_Abbreviation'] . ' ' . $currency['Cur_Scale'] . ' ' . $currency['Cur_Name'];
      $rows[$curId][] = $currency['Cur_OfficialRate'];
    }

    return [
      '#theme'  => 'table',
      '#header' => $header,
      '#rows'   => $rows,
      '#empty'  => t("There are no currencies found"),
    ];
  }

  /**
   * Returns currencies list.
   */
  public function getCurrenciesList() {
    $output = [];
    foreach ($this->getCurrencies() as $curId => $currency) {
      $output[$curId] = $currency['Cur_Abbreviation'];
    }
    return $output;
  }
}
