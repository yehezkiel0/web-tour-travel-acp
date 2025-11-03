<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BookingTransactionRepository;
use App\Repositories\DestinationRepository;
use App\Repositories\UserRepository;
use App\Services\CacheService;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    protected $bookingRepo;
    protected $destinationRepo;
    protected $userRepo;
    protected $cacheService;

    public function __construct(
        BookingTransactionRepository $bookingRepo,
        DestinationRepository $destinationRepo,
        UserRepository $userRepo,
        CacheService $cacheService
    ) {
        $this->bookingRepo = $bookingRepo;
        $this->destinationRepo = $destinationRepo;
        $this->userRepo = $userRepo;
        $this->cacheService = $cacheService;
    }

    public function dashboard()
    {
        // Get cached dashboard statistics
        $stats = $this->cacheService->getDashboardStats();

        // Get additional statistics
        $pendingTransactions = $this->bookingRepo->countByStatus('pending');
        $paidTransactions = $this->bookingRepo->countByStatus('success');
        $cancelledTransactions = $this->bookingRepo->countByStatus('cancelled');

        // Get recent transactions with relations (N+1 optimized)
        $recentTransactions = $this->bookingRepo->getRecentBookings(5);

        // Get popular destinations from cache
        $popularDestinations = $this->cacheService->getPopularDestinations(5);

        return view('admin.dashboard', [
            'totalDestinations' => $stats['total_destinations'],
            'totalTransactions' => $stats['total_bookings'],
            'totalUsers' => $stats['total_customers'],
            'totalRevenue' => $stats['total_revenue'],
            'pendingTransactions' => $pendingTransactions,
            'paidTransactions' => $paidTransactions,
            'cancelledTransactions' => $cancelledTransactions,
            'recentTransactions' => $recentTransactions,
            'popularDestinations' => $popularDestinations,
        ]);
    }
}
