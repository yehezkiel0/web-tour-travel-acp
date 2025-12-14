<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
  public function index(Request $request)
  {
    $query = User::query()->where('role', '!=', 'admin');

    if ($request->has('search') && $request->search) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('name', 'LIKE', "%{$search}%")
          ->orWhere('email', 'LIKE', "%{$search}%")
          ->orWhere('referral_code', 'LIKE', "%{$search}%");
      });
    }

    $customers = $query->latest()->paginate(10);

    return view('admin.customer.index', compact('customers'));
  }
}
