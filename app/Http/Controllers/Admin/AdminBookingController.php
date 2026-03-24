<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class AdminBookingController extends Controller
{
    public function confirm(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya booking pending yang bisa dikonfirmasi.');
        }

        $item = $booking->item;

        $booking->update(['status' => 'confirmed']);

        // Decrease stock
        $item->decrement('stock');

        // If stock hits 0, close the item
        if ($item->fresh()->stock <= 0) {
            $item->update(['status' => 'closed']);
        }

        return back()->with('success', 'Booking dikonfirmasi.');
    }

    public function reject(Booking $booking)
    {
        if (! in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Booking ini tidak bisa ditolak.');
        }

        $item           = $booking->item;
        $wasConfirmed   = $booking->status === 'confirmed';

        $booking->update(['status' => 'rejected']);

        // If it was confirmed, restore stock
        if ($wasConfirmed) {
            $item->increment('stock');

            // If item was closed due to stock, reopen it
            if ($item->fresh()->status === 'closed') {
                $item->update(['status' => 'active']);
            }
        }

        // Recalculate queue positions for all non-rejected bookings on this item
        $remaining = $item->bookings()
            ->whereNotIn('status', ['rejected'])
            ->orderBy('queue_position')
            ->get();

        foreach ($remaining as $index => $b) {
            $b->update(['queue_position' => $index + 1]);
        }

        return back()->with('success', 'Booking ditolak dan antrian diperbarui.');
    }
}
