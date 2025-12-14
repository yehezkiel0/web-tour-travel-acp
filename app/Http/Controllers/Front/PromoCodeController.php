<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromoCodeController extends Controller
{
  public function check(Request $request)
  {
    $request->validate([
      'code' => 'required|string',
      'total_amount' => 'required|numeric',
    ]);

    $promo = PromoCode::where('code', $request->code)->first();

    if (!$promo) {
      return response()->json([
        'success' => false,
        'message' => 'Invalid promo code.'
      ]);
    }

    if (!$promo->isValid()) {
      return response()->json([
        'success' => false,
        'message' => 'Promo code is expired or inactive.'
      ]);
    }

    if ($promo->per_user_limit > 0) {
      $userUsage = 0;
      $userId = Auth::id();

      if ($userId) {
        $hotelUsage = \App\Models\HotelBooking::where('user_id', $userId)
          ->where('promo_code_id', $promo->id)
          ->where('status', '!=', 'cancelled')
          ->where('status', '!=', 'failed')
          ->where('status', '!=', 'expired')
          ->where('status', '!=', 'pending')
          ->count();

        $destinationUsage = \App\Models\BookingTransaction::where('user_id', $userId)
          ->where('promo_code_id', $promo->id)
          ->where('status', '!=', 'cancelled')
          ->where('status', '!=', 'failed')
          ->where('status', '!=', 'expired')
          ->where('status', '!=', 'pending')
          ->count();

        $userUsage = $hotelUsage + $destinationUsage;
      }

      if ($userUsage >= $promo->per_user_limit) {
        return response()->json([
          'success' => false,
          'message' => 'You have reached the usage limit for this promo code.'
        ]);
      }
    }

    if ($promo->min_transaction && $request->total_amount < $promo->min_transaction) {
      return response()->json([
        'success' => false,
        'message' => 'Minimum transaction of Rp ' . number_format((float) $promo->min_transaction, 0, ',', '.') . ' is required.'
      ]);
    }

    $discount = $promo->calculateDiscount($request->total_amount);
    $newTotal = $request->total_amount - $discount;

    return response()->json([
      'success' => true,
      'discount' => $discount,
      'new_total' => max(0, $newTotal),
      'promo_id' => $promo->id,
      'code' => $promo->code,
      'message' => 'Promo code applied successfully!'
    ]);
  }
}
