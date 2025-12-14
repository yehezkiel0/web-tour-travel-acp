<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingTransaction;
use App\Models\Destination;
use App\Models\HotelBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsController extends Controller
{
  public function index()
  {
    // 1. Monthly Revenue (Current Year)
    $currentYear = date('Y');
    $biRevenue = BookingTransaction::select(
      DB::raw('MONTH(created_at) as month'),
      DB::raw('SUM(total_price) as total')
    )
      ->whereYear('created_at', $currentYear)
      ->whereIn('status', ['paid', 'completed'])
      ->groupBy('month')
      ->pluck('total', 'month')
      ->toArray();

    $hbRevenue = HotelBooking::select(
      DB::raw('MONTH(created_at) as month'),
      DB::raw('SUM(total_price) as total')
    )
      ->whereYear('created_at', $currentYear)
      ->whereIn('status', ['confirmed', 'completed'])
      ->groupBy('month')
      ->pluck('total', 'month')
      ->toArray();

    $monthlyRevenue = [];
    for ($i = 1; $i <= 12; $i++) {
      $monthlyRevenue[] = ($biRevenue[$i] ?? 0) + ($hbRevenue[$i] ?? 0);
    }

    // 2. Booking Status Distribution
    $bookingStatus = BookingTransaction::select('status', DB::raw('count(*) as total'))
      ->groupBy('status')
      ->pluck('total', 'status')
      ->toArray();

    // Ensure all keys exist
    $statuses = ['pending', 'paid', 'completed', 'cancelled'];
    $statusCounts = [];
    foreach ($statuses as $status) {
      $statusCounts[] = $bookingStatus[$status] ?? 0;
    }

    // 3. Top 5 Destinations
    $topDestinations = BookingTransaction::select('destination_id', DB::raw('count(*) as total'))
      ->groupBy('destination_id')
      ->orderByDesc('total')
      ->take(5)
      ->with('destination')
      ->get()
      ->map(function ($item) {
        return [
          'name' => $item->destination->title ?? 'Unknown',
          'count' => $item->total
        ];
      });

    // 4. User Growth (Last 6 Months)
    $userGrowth = User::select(
      DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month_year'),
      DB::raw('count(*) as total')
    )
      ->where('created_at', '>=', now()->subMonths(6))
      ->where('role', 'user')
      ->groupBy('month_year')
      ->orderBy('month_year')
      ->get();

    $userGrowthLabels = $userGrowth->pluck('month_year')->toArray();
    $userGrowthData = $userGrowth->pluck('total')->toArray();

    return view('admin.analytics.index', compact(
      'monthlyRevenue',
      'statusCounts',
      'topDestinations',
      'userGrowthLabels',
      'userGrowthData',
      'currentYear'
    ));
  }
}
