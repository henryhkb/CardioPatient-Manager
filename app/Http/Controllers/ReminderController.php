<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReminderController extends Controller
{
    /**
     * Reminder Records (history/log)
     */
    public function index()
    {
        $reminders = Reminder::with('booking')
            ->orderBy('reminder_at', 'desc')
            ->paginate(15);

        return view('reminders.index', compact('reminders'));
    }

    /**
     * Single Reminder Form
     */
    public function create(Request $request)
    {
        $booking = null;

        if ($request->filled('booking_id')) {
            $booking = Booking::with(['clinic', 'procedure'])
                ->findOrFail($request->booking_id);
        }

        return view('reminders.create', compact('booking'));
    }

    /**
     * Store Single Reminder
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'booking_id'   => ['required', 'exists:bookings,id'],
            'channel'      => ['required', 'in:sms,whatsapp,email'],
            'reminder_at'  => ['required', 'date'],
            'message'      => ['required', 'string', 'max:5000'],
        ]);

        $data['status'] = 'queued';

        Reminder::create($data);

        return redirect()
            ->route('reminders.index')
            ->with('success', 'Reminder queued successfully.');
    }

    /**
     * 🔔 Reminder Dashboard (Patients to remind)
     */
    public function dashboard(Request $request)
    {
        $from = $request->filled('from')
            ? Carbon::parse($request->from)->startOfDay()
            : now()->startOfDay();

        $to = $request->filled('to')
            ? Carbon::parse($request->to)->endOfDay()
            : now()->addDays(7)->endOfDay();

        $bookings = Booking::with(['clinic', 'procedure'])
            ->whereBetween('scheduled_at', [$from, $to])
            ->whereNotIn('status', ['cancelled', 'done', 'no_show'])
            ->orderBy('scheduled_at', 'asc')
            ->get();

        return view('reminders.dashboard', compact('bookings', 'from', 'to'));
    }

    /**
     * Bulk Reminder Creation
     */
    public function bulkStore(Request $request)
    {
        $data = $request->validate([
            'booking_ids' => ['required', 'array', 'min:1'],
            'booking_ids.*' => ['integer', 'exists:bookings,id'],

            'channel' => ['required', 'in:sms,whatsapp,email'],
            'reminder_at' => ['required', 'date'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        foreach ($data['booking_ids'] as $bookingId) {
            Reminder::create([
                'booking_id' => $bookingId,
                'channel' => $data['channel'],
                'reminder_at' => $data['reminder_at'],
                'message' => $data['message'],
                'status' => 'queued',
            ]);
        }

        return back()->with('success', 'Bulk reminders queued successfully.');
    }
}
