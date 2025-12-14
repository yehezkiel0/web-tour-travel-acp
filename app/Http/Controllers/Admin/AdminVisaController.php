<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisaApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminVisaController extends Controller
{
  public function index(Request $request)
  {
    $query = VisaApplication::with('user')->latest();

    if ($request->has('status') && $request->status != '') {
      $query->where('status', $request->status);
    }

    $applications = $query->paginate(10);
    return view('admin.visa.index', compact('applications'));
  }

  public function show($id)
  {
    $application = VisaApplication::with(['user', 'documents'])->findOrFail($id);
    return view('admin.visa.show', compact('application'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'status' => 'required|in:pending,documents_received,in_process,approved,rejected',
      'admin_notes' => 'nullable|string'
    ]);

    $application = VisaApplication::findOrFail($id);
    $application->update([
      'status' => $request->status,
      'admin_notes' => $request->admin_notes
    ]);

    return redirect()->back()->with('success', 'Visa application status updated!');
  }
}
