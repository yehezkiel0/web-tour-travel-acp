<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BookingTransactionRepository;
use App\Repositories\DestinationRepository;
use App\Repositories\UserRepository;
use App\Services\CacheService;
use App\Models\Hotel;
use App\Models\HotelBooking;
use App\Models\ServiceTestimonial;
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
        $paidTransactions = $this->bookingRepo->countByStatus('paid');
        $cancelledTransactions = $this->bookingRepo->countByStatus('cancelled');

        // Calculate total travellers (adult + child)
        $totalTravellers = $this->bookingRepo->getTotalTravellers();

        // Get recent transactions with relations (N+1 optimized)
        $recentTransactions = $this->bookingRepo->getRecentBookings(5);

        // Get popular destinations from cache
        $popularDestinations = $this->cacheService->getPopularDestinations(5);

        // Hotel statistics
        $totalHotels = Hotel::where('is_active', true)->count();
        $totalHotelBookings = HotelBooking::count();
        $pendingHotelBookings = HotelBooking::where('status', 'pending')->count();
        $confirmedHotelBookings = HotelBooking::where('status', 'confirmed')->count();
        $hotelRevenue = HotelBooking::whereIn('status', ['confirmed', 'completed'])->sum('total_price');

        // Testimonials statistics
        $totalTestimonials = ServiceTestimonial::count();
        $pendingTestimonials = ServiceTestimonial::where('is_approved', false)->count();
        $recentTestimonials = ServiceTestimonial::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', [
            'totalDestinations' => $stats['total_destinations'],
            'totalTransactions' => $stats['total_bookings'],
            'totalUsers' => $stats['total_customers'],
            'totalRevenue' => $stats['total_revenue'],
            'pendingTransactions' => $pendingTransactions,
            'paidTransactions' => $paidTransactions,
            'cancelledTransactions' => $cancelledTransactions,
            'totalTravellers' => $totalTravellers,
            'recentTransactions' => $recentTransactions,
            'popularDestinations' => $popularDestinations,
            'totalHotels' => $totalHotels,
            'totalHotelBookings' => $totalHotelBookings,
            'pendingHotelBookings' => $pendingHotelBookings,
            'confirmedHotelBookings' => $confirmedHotelBookings,
            'hotelRevenue' => $hotelRevenue,
            'totalTestimonials' => $totalTestimonials,
            'pendingTestimonials' => $pendingTestimonials,
            'recentTestimonials' => $recentTestimonials,
        ]);
    }
}
