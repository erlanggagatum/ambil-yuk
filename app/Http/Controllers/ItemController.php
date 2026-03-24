<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $activeItems = Item::where('status', 'active')
            ->withCount([
                'bookings as confirmed_count' => fn($q) => $q->where('status', 'confirmed'),
                'bookings as pending_count'   => fn($q) => $q->where('status', 'pending'),
            ])
            ->with('photos')
            ->latest()
            ->get();

        $closedItems = Item::whereIn('status', ['closed', 'done'])
            ->withCount([
                'bookings as confirmed_count' => fn($q) => $q->where('status', 'confirmed'),
                'bookings as pending_count'   => fn($q) => $q->where('status', 'pending'),
            ])
            ->with('photos')
            ->latest()
            ->get();

        $allItems = $activeItems->merge($closedItems);

        $userBookings = Auth::user()
            ->bookings()
            ->whereIn('item_id', $allItems->pluck('id'))
            ->get()
            ->keyBy('item_id');

        return view('items.index', compact('activeItems', 'closedItems', 'userBookings'));
    }

    public function show(Item $item)
    {
        $item->load('photos');

        $confirmedCount = $item->bookings()->where('status', 'confirmed')->count();

        $queue = $item->bookings()
            ->with('user')
            ->orderBy('queue_position')
            ->get();

        $userBooking = $item->bookings()
            ->where('user_id', Auth::id())
            ->first();

        return view('items.show', compact('item', 'confirmedCount', 'queue', 'userBooking'));
    }
}
