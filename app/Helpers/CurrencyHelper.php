<?php

if (!function_exists('formatCurrency')) {
  function formatCurrency($price)
  {
    if (!$price)
      return "";

    $currency = session('currency', 'IDR');
    $service = new \App\Services\CurrencyService();

    $converted = $service->convert($price, $currency);
    $symbol = $service->getSymbol($currency);

    // Adjust precision based on currency
    $decimals = $currency === 'IDR' || $currency === 'KRW' ? 0 : 2;

    return $symbol . ' ' . number_format($converted, $decimals, '.', ',');
  }
}

// Keep legacy support but forward to new function
if (!function_exists('formatIDR')) {
  function formatIDR($price)
  {
    return formatCurrency($price);
  }
}