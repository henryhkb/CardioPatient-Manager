<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Clinic;
use App\Models\Procedure;
use App\Models\Reminder;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_reminders' => Reminder::count(),
            'clinics' => Clinic::count(),
            'procedures' => Procedure::count(),
            'booked_procedures' => Booking::where('booking_type', 'procedure')->count(),
        ];

        $recentBookings = Booking::latest()->take(8)->get();

        return view('dashboard', compact('stats', 'recentBookings'));
    }
}
