<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminTransactionController extends Controller
{
    public function index(){
        

        $transactions = BookingTransaction::with(['user', 'destination'])->get();

        $transactions->each(function ($transaction){
            try{
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
    
}