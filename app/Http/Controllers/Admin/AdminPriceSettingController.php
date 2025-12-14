<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PricingSetting;

class AdminPriceSettingController extends Controller
{
    public function index()
    {
        $setting = PricingSetting::firstOrCreate([], [
            'individual_visa_rate' => 500000,
            'group_visa_rate' => 350000,
            'tax_percentage' => 11,
            'group_discount_threshold' => 10,
            'group_discount_percentage' => 5,
        ]);

        return view('admin.price_setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'individual_visa_rate' => 'required|numeric|min:0',
            'group_visa_rate' => 'required|numeric|min:0',
            'tax_percentage' => 'required|numeric|min:0|max:100',
            'group_discount_threshold' => 'required|integer|min:1',
            'group_discount_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $setting = PricingSetting::first();
        $setting->update($request->all());

        return redirect()->back()->with('success', 'Price settings updated successfully');
    }
}
