<?php

use App\Models\PromoCode;
use App\Models\BookingTransaction;
use App\Models\HotelBooking;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "--- Promo Codes ---\n";
try {
  $promos = PromoCode::all();
  if ($promos->isEmpty()) {
    echo "No Promo Codes found.\n";
  }
  foreach ($promos as $p) {
    echo "ID: {$p->id}, Code: '{$p->code}', Usage: {$p->usage_count}, Limit: " . ($p->usage_limit ?? 'NULL') . "\n";
  }

  echo "\n--- Booking Transactions with Promo ---\n";
  $bookings = BookingTransaction::whereNotNull('promo_code_id')->get();
  if ($bookings->isEmpty()) {
    echo "No Booking Transactions with promo_code_id found.\n";
  }
  foreach ($bookings as $b) {
    echo "ID: {$b->id}, Code: {$b->code}, PromoID: {$b->promo_code_id}\n";
  }

  echo "\n--- Hotel Bookings with Promo ---\n";
  $hotelBookings = HotelBooking::whereNotNull('promo_code_id')->get();
  if ($hotelBookings->isEmpty()) {
    echo "No Hotel Bookings with promo_code_id found.\n";
  }
  foreach ($hotelBookings as $b) {
    echo "ID: {$b->id}, BookingCode: {$b->booking_code}, PromoID: {$b->promo_code_id}\n";
  }

  // Check if there are bookings that SHOULD have promo but don't (hard to tell without context, but we can list recent bookings)
  /*
  echo "\n--- Recent 5 Bookings ---\n";
  $recent = BookingTransaction::latest()->take(5)->get();
  foreach($recent as $b) {
      echo "ID: {$b->id}, Code: {$b->code}, PromoID: " . ($b->promo_code_id ?? 'NULL') . "\n";
  }
  */

} catch (\Exception $e) {
  echo "Error: " . $e->getMessage() . "\n";
}
