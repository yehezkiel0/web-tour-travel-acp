<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\TicketMail;
use App\Models\BookingTransaction;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.serverKey');
        $hashedKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // Validasi signature key
        if ($hashedKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;

        // Cari transaksi berdasarkan order_id
        $transaction = BookingTransaction::where('code', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Update status berdasarkan transaction_status
        switch ($transactionStatus) {
            case 'capture':
                if ($request->payment_type == 'credit_card') {
                    if ($request->fraud_status == 'challenge') {
                        $transaction->update([
                            'status' => 'pending',
                        ]);
                    } else {
                        $transaction->update([
                            'status' => 'paid',
                        ]);
                    }
                }
                break;
            case 'settlement':
                try {
                    $transaction->update(['status' => 'paid']);

                    $transaction->load(['user', 'destination']);

                    if (!$transaction->user || !$transaction->destination) {
                        Log::error('User or destination not found', [
                            'transaction_id' => $transaction->id,
                            'user_id' => $transaction->user_id,
                            'destination_id' => $transaction->destination_id
                        ]);
                        return;
                    }

                    Mail::to($transaction->user->email)
                        ->send(new TicketMail(
                            $transaction->user,
                            $transaction,
                            $transaction->destination
                        ));

                    Log::info('Ticket email sent successfully', [
                        'transaction_id' => $transaction->id,
                        'email' => $transaction->user->email
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to process settlement', [
                        'transaction_id' => $transaction->id,
                        'error' => $e->getMessage()
                    ]);
                }
                break;
            case 'pending':
                $transaction->update([
                    'status' => 'pending',
                ]);
                break;
            case 'deny':
            case 'expire':
            case 'cancel':
                $transaction->update([
                    'status' => 'cancelled',
                ]);
                $bookingData = [
                    'from_date' => $transaction->from_date,
                    'to_date' => $transaction->to_date,
                    'adult_count' => $transaction->adult_count,
                    'child_count' => $transaction->child_count,
                    'contact_name' => $transaction->contact_name,
                    'contact_phone' => $transaction->contact_phone,
                    'contact_email' => $transaction->contact_email,
                    'notes' => $transaction->notes,
                    'travellers' => json_decode($transaction->traveller_details, true),
                    'total_price' => $transaction->total_price,
                ];
    
                session()->put('booking', $bookingData);
    
                return redirect()->route('checkout', ['slug' => $transaction->destination->slug])
                    ->with('error', 'Payment failed. Please try again.');
                break;
            default:
                $transaction->update([
                    'status' => 'cancelled',
                ]);
                break;
        }

        Log::info('Midtrans callback data:', $request->all());
        return response()->json(['message' => 'Callback received successfully']);
    }

    public function getTransactionDetails($orderId): JsonResponse
    {
        try {
            $serverKey = config('midtrans.serverKey');
            $isProduction = config('midtrans.isProduction');

            $url = $isProduction
                ? "https://api.midtrans.com/v2/{$orderId}/status"
                : "https://api.sandbox.midtrans.com/v2/{$orderId}/status";

            $response = Http::timeout(30)
                ->withBasicAuth($serverKey, '')
                ->get($url);

                if ($response->successful()) {
                    $responseData = $response->json();
        
                    if (isset($responseData['status_code']) && $responseData['status_code'] == '404') {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Transaction not found',
                            'error' => $responseData['status_message']
                        ], 404);
                    }
        
                    return response()->json([
                        'status' => 'success',
                        'data' => $responseData
                    ], 200);
                }
        
    
            // Handle other errors
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch transaction details',
                'error' => $response->json()
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Connection timeout or network error',
                'error' => $e->getMessage()
            ], 504);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}