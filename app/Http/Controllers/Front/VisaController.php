<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\VisaApplication;
use App\Models\VisaDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VisaController extends Controller
{
  public function index()
  {
    $user = Auth::user();
    $applications = VisaApplication::where('user_id', Auth::id())->latest()->paginate(10);
    return view('front.visa.index', compact('applications', 'user'));
  }

  public function create()
  {
    $user = Auth::user();
    return view('front.visa.create', compact('user'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'country' => 'required|string',
      'visa_type' => 'required|string',
      'passport' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
      'photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
      'bank_statement' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $application = VisaApplication::create([
      'user_id' => Auth::id(),
      'country' => $request->country,
      'visa_type' => $request->visa_type,
      'status' => 'pending',
    ]);

    $this->uploadDocument($request, 'passport', 'Passport Scan', $application->id);
    $this->uploadDocument($request, 'photo', 'Photo', $application->id);

    if ($request->hasFile('bank_statement')) {
      $this->uploadDocument($request, 'bank_statement', 'Bank Statement', $application->id);
    }

    return redirect()->route('visa.index')->with('success', 'Visa application submitted successfully!');
  }

  public function show($id)
  {
    $application = VisaApplication::where('user_id', 'Auth::id()')->findOrFail($id);
    // Correct query:
    $application = VisaApplication::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    return view('front.visa.show', compact('application'));
  }

  private function uploadDocument($request, $inputName, $docName, $applicationId)
  {
    if ($request->hasFile($inputName)) {
      $path = $request->file($inputName)->store('visa_documents', 'public');
      VisaDocument::create([
        'visa_application_id' => $applicationId,
        'document_name' => $docName,
        'file_path' => $path,
      ]);
    }
  }
}
