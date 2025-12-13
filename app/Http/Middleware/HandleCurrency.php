<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Services\CurrencyService;
use Symfony\Component\HttpFoundation\Response;

class HandleCurrency
{
  public function handle(Request $request, Closure $next): Response
  {
    if (!Session::has('currency')) {
      Session::put('currency', 'IDR');
    }

    $currency = Session::get('currency');
    $service = new CurrencyService();

    View::share('currentCurrency', $currency);
    View::share('currencySymbol', $service->getSymbol($currency));

    return $next($request);
  }
}
