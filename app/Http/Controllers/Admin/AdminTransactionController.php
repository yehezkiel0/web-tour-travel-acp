<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BookingTransactionRepository;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminTransactionController extends Controller
{
    protected $bookingRepo;
    protected $bookingService;

    public function __construct(
        BookingTransactionRepository $bookingRepo,
        BookingService $bookingService
    ) {
        $this->bookingRepo = $bookingRepo;
        $this->bookingService = $bookingService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        // Use pagination instead of loading all records
        $transactions = $this->bookingRepo->paginateWithRelationsAndFilters($perPage, $search, $status);

        // Only fetch payment details for the current page to reduce API calls
        $transactions->getCollection()->each(function ($transaction) {
            try {
                $response = Http::get(route('api.transaction.details', ['orderId' => $transaction->code]));

                if ($response->successful()) {
                    $transaction->details = $response->json()['data'] ?? null;
                } else {
                    $transaction->details = null;
                    $transaction->error_message = $response->json()['message'] ?? 'Failed to fetch payment details';
                    Log::warning("Failed to fetch transaction {$transaction->code}: " . $response->body());
                }
            } catch (\Exception $e) {
                Log::error("Error processing transaction {$transaction->code}: " . $e->getMessage());
                $transaction->details = null;
                $transaction->error_message = 'Failed to fetch payment details';
            }
        });

        return view('admin.transaction.index', compact('transactions'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled,completed,failed',
        ]);

        $transaction = \App\Models\BookingTransaction::findOrFail($id);
        $transaction->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Transaction status updated successfully!');
    }

    public function destroy($id)
    {
        $transaction = \App\Models\BookingTransaction::findOrFail($id);
        $transaction->delete();

        return redirect()->back()->with('success', 'Transaction deleted successfully!');
    }
}
