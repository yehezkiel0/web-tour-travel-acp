<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'subject' => 'required|in:tour-travel,health-beauty,recruitment,entertainment',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($data);

        return redirect()->back()->with('success', 'Your message has been sent successfully.');
    }
}
