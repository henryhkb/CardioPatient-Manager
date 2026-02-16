@extends('layouts.app')

@section('content')
<div class="mb-3">
    <h4 class="fw-bold mb-0">Add Reminder</h4>
    <div class="text-muted">Queue an SMS/WhatsApp/Email reminder for a booking</div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card card-soft p-3">
    <form method="POST" action="{{ route('reminders.store') }}">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Booking</label>
                <input type="hidden" name="booking_id" value="{{ old('booking_id', $booking?->id) }}">

                @if($booking)
                    <div class="form-control bg-light">
                        <div class="fw-semibold">{{ $booking->patient_name }}</div>
                        <div class="small text-muted">
                            {{ $booking->booking_code }} •
                            {{ \Carbon\Carbon::parse($booking->scheduled_at)->format('D, d M Y • h:i A') }}
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning mb-0">
                        Open reminders from a booking page using “Add Reminder”.
                    </div>
                @endif
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Channel</label>
                <select name="channel" class="form-select" required>
                    <option value="sms" @selected(old('channel')==='sms')>SMS</option>
                    <option value="whatsapp" @selected(old('channel')==='whatsapp')>WhatsApp</option>
                    <option value="email" @selected(old('channel')==='email')>Email</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Reminder Time</label>
                <input type="datetime-local" name="reminder_at" class="form-control"
                       value="{{ old('reminder_at') }}" required>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Message</label>
                <textarea name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                <div class="form-text">Keep it short and clear.</div>
            </div>
        </div>

        <div class="mt-3 d-flex gap-2">
            <button class="btn btn-primary">
                <i class="bi bi-bell"></i> Queue Reminder
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
