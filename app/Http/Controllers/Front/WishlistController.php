<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Destination;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Auth::user()->wishlists()->with('wishlistable')->latest()->get();
        return view('front.wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'type' => 'required|in:destination,hotel',
            'id' => 'required|integer',
        ]);

        $type = $request->type === 'destination' ? Destination::class : Hotel::class;

        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('wishlistable_type', $type)
            ->where('wishlistable_id', $request->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed', 'message' => 'Removed from wishlist']);
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'wishlistable_type' => $type,
                'wishlistable_id' => $request->id,
            ]);
            return response()->json(['status' => 'added', 'message' => 'Added to wishlist']);
        }
    }

    public function check(Request $request)
    {
        $type = $request->type === 'destination' ? Destination::class : Hotel::class;

        $exists = Wishlist::where('user_id', Auth::id())
            ->where('wishlistable_type', $type)
            ->where('wishlistable_id', $request->id)
            ->exists();

        return response()->json(['inWishlist' => $exists]);
    }
}
