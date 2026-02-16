<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Clinic;
use App\Models\Procedure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $q = Booking::query()->with(['clinic', 'procedure']);

        // quick buttons
        $quick = $request->get('quick');
        if ($quick === 'today') {
            $q->whereDate('scheduled_at', Carbon::today());
        } elseif ($quick === 'tomorrow') {
            $q->whereDate('scheduled_at', Carbon::tomorrow());
        } elseif ($quick === 'week') {
            $q->whereBetween('scheduled_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        } else {
            // manual date range (only if no quick filter)
            if ($request->filled('from')) {
                $q->whereDate('scheduled_at', '>=', $request->from);
            }
            if ($request->filled('to')) {
                $q->whereDate('scheduled_at', '<=', $request->to);
            }
        }

        // other filters
        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }

        if ($request->filled('booking_type')) {
            $q->where('booking_type', $request->booking_type);
        }

        if ($request->filled('clinic_id')) {
            $q->where('clinic_id', $request->clinic_id);
        }

        if ($request->filled('procedure_id')) {
            $q->where('procedure_id', $request->procedure_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $q->where(function ($sub) use ($search) {
                $sub->where('patient_name', 'like', "%{$search}%")
                    ->orWhere('patient_phone', 'like', "%{$search}%")
                    ->orWhere('booking_code', 'like', "%{$search}%");
            });
        }

        $bookings = $q->orderBy('scheduled_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $clinics = Clinic::orderBy('name')->get(['id', 'name']);
        $procedures = Procedure::orderBy('name')->get(['id', 'name']);

        return view('bookings.index', compact('bookings', 'clinics', 'procedures'));
    }
    public function create()
    {
        $clinics = Clinic::where('is_active', true)->get();
        $procedures = Procedure::where('is_active', true)->get();

        return view('bookings.create', compact('clinics', 'procedures'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_type'   => ['required', 'in:clinic,procedure'],
            'clinic_id'      => ['nullable', 'exists:clinics,id'],
            'procedure_id'   => ['nullable', 'exists:procedures,id'],
            'scheduled_at'   => ['required', 'date', 'after:now'],

            'patient_name'   => ['required', 'string', 'max:255'],
            'patient_age'    => ['nullable', 'integer', 'min:0', 'max:120'],
            'patient_gender' => ['nullable', 'in:male,female,other'],
            'patient_diagnosis' => ['nullable', 'string'],
            'patient_home_address' => ['nullable', 'string', 'max:255'],
            'patient_next_of_kin' => ['nullable', 'string', 'max:255'],
            'patient_phone'  => ['required', 'string', 'max:30'],
            'patient_email'  => ['nullable', 'email', 'max:255'],
        ]);

        // Enforce booking rules + normalize fields
        if ($validated['booking_type'] === 'clinic') {
            if (empty($validated['clinic_id'])) {
                return back()->withErrors([
                    'clinic_id' => 'Clinic is required for clinic bookings.'
                ])->withInput();
            }

            // clear procedure for clinic bookings
            $validated['procedure_id'] = null;
        }

        if ($validated['booking_type'] === 'procedure') {
            if (empty($validated['procedure_id'])) {
                return back()->withErrors([
                    'procedure_id' => 'Procedure is required for procedure bookings.'
                ])->withInput();
            }

            // auto-fill clinic from procedure
            $procedure = Procedure::find($validated['procedure_id']);
            $validated['clinic_id'] = $procedure?->clinic_id;
        }

        // STEP 4: Prevent double-booking clashes (ignore cancelled bookings)
        $clash = Booking::where('scheduled_at', $validated['scheduled_at'])
            ->where('status', '!=', 'cancelled');

        if ($validated['booking_type'] === 'clinic') {
            $clash->where('booking_type', 'clinic')
                ->where('clinic_id', $validated['clinic_id']);
        } else {
            $clash->where('booking_type', 'procedure')
                ->where('procedure_id', $validated['procedure_id']);
        }

        if ($clash->exists()) {
            return back()->withErrors([
                'scheduled_at' => 'That time is already booked. Please choose another time.'
            ])->withInput();
        }

        // Generate unique booking code safely
        do {
            $code = strtoupper(Str::random(8));
        } while (Booking::where('booking_code', $code)->exists());

        $validated['booking_code'] = $code;

        Booking::create($validated);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Booking created successfully.');
    }



    public function updateStatus(Request $request, Booking $booking, string $status)
    {
        $allowed = ['pending', 'confirmed', 'done', 'cancelled', 'no_show'];

        abort_unless(in_array($status, $allowed, true), 404);

        // Optional: basic transition rules (recommended)
        $transitions = [
            'pending'   => ['confirmed', 'cancelled'],
            'confirmed' => ['done', 'no_show', 'cancelled'],
            'done'      => [],
            'cancelled' => [],
            'no_show'   => [],
        ];

        abort_unless(in_array($status, $transitions[$booking->status] ?? [], true), 403);

        $booking->update(['status' => $status]);

        return back()->with('success', "Booking status updated to: {$status}");
    }

    public function show(Booking $booking)
    {
        $booking->load(['clinic', 'procedure']);

        return view('bookings.show', compact('booking'));
    }

    public function setStatus(Request $request, Booking $booking, string $status)
    {
        $allowed = ['pending', 'confirmed', 'done', 'cancelled', 'no_show'];

        abort_unless(in_array($status, $allowed, true), 404);

        $booking->update([
            'status' => $status,
        ]);

        return back()->with('success', 'Booking status updated.');
    }

    public function edit(Booking $booking)
    {
        $clinics = Clinic::where('is_active', true)->orderBy('name')->get();
        $procedures = Procedure::with('clinic')->orderBy('name')->get();

        return view('bookings.edit', compact('booking', 'clinics', 'procedures'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'clinic_id'      => ['nullable', 'exists:clinics,id'],
            'procedure_id'   => ['nullable', 'exists:procedures,id'],
            'scheduled_at'   => ['required', 'date'],

            'patient_name'   => ['required', 'string', 'max:255'],
            'patient_phone'  => ['required', 'string', 'max:30'],
            'patient_email'  => ['nullable', 'email', 'max:255'],

            'status'         => ['nullable', 'in:pending,confirmed,done,cancelled,no_show'],
        ]);

        $type = $booking->booking_type;

        // Enforce booking_type rules based on existing type
        if ($type === 'clinic' && empty($validated['clinic_id'])) {
            return back()->withErrors([
                'clinic_id' => 'Clinic is required for clinic bookings.'
            ])->withInput();
        }

        if ($type === 'procedure' && empty($validated['procedure_id'])) {
            return back()->withErrors([
                'procedure_id' => 'Procedure is required for procedure bookings.'
            ])->withInput();
        }

        // Normalize fields: if clinic booking, clear procedure
        if ($type === 'clinic') {
            $validated['procedure_id'] = null;
        }

        // STEP 4: Prevent double-booking clashes (ignore cancelled + ignore this booking)
        $clash = Booking::where('scheduled_at', $validated['scheduled_at'])
            ->where('status', '!=', 'cancelled')
            ->where('id', '!=', $booking->id);

        if ($type === 'clinic') {
            $clash->where('booking_type', 'clinic')
                ->where('clinic_id', $validated['clinic_id']);
        } else {
            $clash->where('booking_type', 'procedure')
                ->where('procedure_id', $validated['procedure_id']);
        }

        if ($clash->exists()) {
            return back()->withErrors([
                'scheduled_at' => 'That time is already booked. Please choose another time.'
            ])->withInput();
        }

        $booking->update($validated);

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Booking updated successfully.');
    }
}
