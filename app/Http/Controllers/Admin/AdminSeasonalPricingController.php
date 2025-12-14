<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\SeasonalPricing; // kept next line
use App\Models\SeasonalPricing;

class AdminSeasonalPricingController extends Controller
{
    public function index()
    {
        $seasons = SeasonalPricing::latest()->get();
        return view('admin.price_setting.seasonal', compact('seasons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'adjustment_type' => 'required|in:markup,discount',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        SeasonalPricing::create($request->all());

        return redirect()->back()->with('success', 'Season added successfully');
    }

    public function destroy($id)
    {
        $season = SeasonalPricing::findOrFail($id);
        $season->delete();
        return redirect()->back()->with('success', 'Season deleted successfully');
    }
}
