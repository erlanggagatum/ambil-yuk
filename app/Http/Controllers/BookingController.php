<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()
            ->bookings()
            ->with('item')
            ->orderByRaw("FIELD(status, 'pending', 'confirmed', 'rejected')")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function store(Request $request, Item $item)
    {
        // Item must be active
        if ($item->status !== 'active') {
            return back()->with('error', 'Item ini sudah tidak tersedia.');
        }

        // Stock must be > 0
        $confirmedCount = $item->bookings()->where('status', 'confirmed')->count();
        if ($item->stock - $confirmedCount <= 0) {
            return back()->with('error', 'Stok item ini sudah habis.');
        }

        // User must not already have a booking on this item
        $existing = $item->bookings()->where('user_id', Auth::id())->first();
        if ($existing) {
            return back()->with('error', 'Kamu sudah memiliki booking untuk item ini.');
        }

        $nextPosition = ($item->bookings()->max('queue_position') ?? 0) + 1;

        Booking::create([
            'item_id'        => $item->id,
            'user_id'        => Auth::id(),
            'status'         => 'pending',
            'queue_position' => $nextPosition,
        ]);

        return redirect()->route('items.show', $item)
            ->with('success', 'Booking berhasil! Kamu ada di antrian nomor ' . $nextPosition . '.');
    }
}
