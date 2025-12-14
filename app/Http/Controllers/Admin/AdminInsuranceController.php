<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use Illuminate\Http\Request;

class AdminInsuranceController extends Controller
{
    public function index()
    {
        $insurances = Insurance::latest()->paginate(10);
        return view('admin.insurance.index', compact('insurances'));
    }

    public function create()
    {
        return view('admin.insurance.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string',
        ]);

        Insurance::create($request->all());

        return redirect()->route('admin_insurance_index')->with('success', 'Insurance plan created successfully!');
    }

    public function edit($id)
    {
        $insurance = Insurance::findOrFail($id);
        return view('admin.insurance.edit', compact('insurance'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string',
        ]);

        $insurance = Insurance::findOrFail($id);
        $insurance->update($request->all());

        return redirect()->route('admin_insurance_index')->with('success', 'Insurance plan updated successfully!');
    }

    public function destroy($id)
    {
        $insurance = Insurance::findOrFail($id);
        $insurance->delete();

        return redirect()->route('admin_insurance_index')->with('success', 'Insurance plan deleted successfully!');
    }
}
