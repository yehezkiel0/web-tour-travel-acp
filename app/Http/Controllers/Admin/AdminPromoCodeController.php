<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;

class AdminPromoCodeController extends Controller
{
    public function index()
    {
        $promoCodes = PromoCode::latest()->paginate(15);
        return view('admin.promo-codes.index', compact('promoCodes'));
    }

    public function create()
    {
        return view('admin.promo-codes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promo_codes,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_transaction' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'applicable_to' => 'required|in:all,destinations,hotels',
        ]);

        $validated['is_active'] = $request->has('is_active');

        PromoCode::create($validated);

        return redirect()->route('admin_promo_codes_index')
            ->with('success', 'Promo code created successfully!');
    }

    public function edit($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        return view('admin.promo-codes.edit', compact('promoCode'));
    }

    public function update(Request $request, $id)
    {
        $promoCode = PromoCode::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promo_codes,code,' . $id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_transaction' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'applicable_to' => 'required|in:all,destinations,hotels',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $promoCode->update($validated);

        return redirect()->route('admin_promo_codes_index')
            ->with('success', 'Promo code updated successfully!');
    }

    public function destroy($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        $promoCode->delete();

        return redirect()->route('admin_promo_codes_index')
            ->with('success', 'Promo code deleted successfully!');
    }
}
