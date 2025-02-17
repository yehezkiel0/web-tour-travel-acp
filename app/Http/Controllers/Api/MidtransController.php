<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BookingTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
                            'status' => 'pending', // Sesuaikan dengan enum
                        ]);
                    } else {
                        $transaction->update([
                            'status' => 'paid', // Sesuaikan dengan enum
                        ]);
                    }
                }
                break;
            case 'settlement':
                $transaction->update([
                    'status' => 'paid', // Sesuaikan dengan enum
                ]);
                break;
            case 'pending':
                $transaction->update([
                    'status' => 'pending', // Sesuaikan dengan enum
                ]);
                break;
            case 'deny':
            case 'expire':
            case 'cancel':
                $transaction->update([
                    'status' => 'cancelled', // Sesuaikan dengan enum
                ]);
                break;
            default:
                $transaction->update([
                    'status' => 'cancelled', // Sesuaikan dengan enum
                ]);
                break;
        }

        Log::info('Midtrans callback data:', $request->all());
        return response()->json(['message' => 'Callback received successfully']);
    }
}
