<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Item;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems   = Item::count();
        $activeItems  = Item::where('status', 'active')->count();
        $pendingCount = Booking::where('status', 'pending')->count();

        return view('admin.dashboard', compact('totalItems', 'activeItems', 'pendingCount'));
    }
}
