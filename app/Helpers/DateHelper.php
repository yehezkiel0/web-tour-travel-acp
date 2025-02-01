<?php

if (!function_exists('calculateDuration')) {
  function calculateDuration($startDate, $endDate)
  {
    return \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) . ' days';
  }
}

if (!function_exists('formatDate')) {
  function formatDate($date, $format = 'd F', $fullDate = false)
  {
    if ($fullDate) {
      $format = 'd/m/Y';
    }
    return \Carbon\Carbon::parse($date)->format($format);
  }
}
