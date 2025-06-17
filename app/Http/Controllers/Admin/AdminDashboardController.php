<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingTransaction;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $totalDestinations = Destination::count();
        $totalTransactions = BookingTransaction::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalRevenue = BookingTransaction::where('status', 'paid')->sum('total_price');

        // Statistik tambahan
        $pendingTransactions = BookingTransaction::where('status', 'pending')->count();
        $paidTransactions = BookingTransaction::where('status', 'paid')->count();
        $cancelledTransactions = BookingTransaction::where('status', 'cancelled')->count();

        // Recent transactions
        $recentTransactions = BookingTransaction::with(['user', 'destination'])
            ->latest()
            ->take(5)
            ->get();

        // Data untuk chart (transaksi per bulan)
        $monthlyTransactions = BookingTransaction::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(total_price) as revenue')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Destinasi paling populer berdasarkan jumlah booking
        $popularDestinations = Destination::select('destinations.*')
            ->selectRaw('(SELECT COUNT(*) FROM booking_transactions WHERE booking_transactions.destination_id = destinations.id) as bookings_count')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        // Statistik tambahan
        $totalTravellers = BookingTransaction::where('status', 'paid')
            ->sum(DB::raw('adult_count + child_count'));

        return view('admin.dashboard', compact(
            'totalDestinations',
            'totalTransactions',
            'totalUsers',
            'totalRevenue',
            'pendingTransactions',
            'paidTransactions',
            'cancelledTransactions',
            'recentTransactions',
            'monthlyTransactions',
            'popularDestinations',
            'totalTravellers'
        ));
    }
}
