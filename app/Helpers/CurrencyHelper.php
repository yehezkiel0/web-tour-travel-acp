<?php

if (!function_exists('formatIDR')) {
  function formatIDR($price)
  {
    if (!$price) return "";
    return 'IDR ' . number_format($price, 0, ',', '.');
  }
}
