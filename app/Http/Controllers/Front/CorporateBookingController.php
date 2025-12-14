<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class CorporateBookingController extends Controller
{
    public function index()
    {
        return view('front.corporate.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'est_pax' => 'required|integer|min:10',
            'trip_date' => 'required|date',
            'requirements' => 'nullable|string',
        ]);

        $message = "CORPORATE INQUIRY\n";
        $message .= "Company: " . $request->company_name . "\n";
        $message .= "Pax: " . $request->est_pax . "\n";
        $message .= "Date: " . $request->trip_date . "\n";
        $message .= "Requirements: " . $request->requirements;

        // Split name
        $parts = explode(' ', $request->contact_person, 2);
        $firstName = $parts[0];
        $lastName = $parts[1] ?? '-';

        Contact::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'subject' => 'tour-travel',
            'message' => $message,
        ]);

        return redirect()->back()->with('success', 'Your corporate booking inquiry has been sent! We will contact you shortly.');
    }
}