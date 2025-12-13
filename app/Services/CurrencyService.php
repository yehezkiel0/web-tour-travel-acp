<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CurrencyService
{
  protected $apiKey;
  protected $baseUrl = 'https://v6.exchangerate-api.com/v6/';

  public function __construct()
  {
    // free key for demo or config
    $this->apiKey = config('services.exchangerate.key', 'your_api_key');
  }

  public function getRates()
  {
    return Cache::remember('currency_rates', 3600, function () {
      // Fallback static rates if API fails or no key
      // Base IDR
      return [
        'IDR' => 1,
        'USD' => 0.000064,
        'KRW' => 0.085,
        'SGD' => 0.000086,
        'MYR' => 0.00030,
        'EUR' => 0.000059,
      ];

      // Real API implementation concept:
      // $response = Http::get($this->baseUrl . $this->apiKey . '/latest/IDR');
      // return $response->json()['conversion_rates'];
    });
  }

  public function convert($amount, $toCurrency)
  {
    if ($toCurrency === 'IDR') {
      return $amount;
    }

    $rates = $this->getRates();
    $rate = $rates[$toCurrency] ?? 1;

    return $amount * $rate;
  }

  public function getSymbol($currency)
  {
    $symbols = [
      'IDR' => 'Rp',
      'USD' => '$',
      'KRW' => '₩',
      'SGD' => 'S$',
      'MYR' => 'RM',
      'EUR' => '€',
    ];

    return $symbols[$currency] ?? $currency;
  }
}
