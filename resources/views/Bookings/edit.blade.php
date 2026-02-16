@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1">Edit Booking</h4>
        <div class="text-muted">Update booking details for this patient</div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <a href="{{ route('bookings.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-list-ul"></i> All Bookings
        </a>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <div class="fw-semibold mb-2">Please fix the errors below:</div>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card card-soft p-3">
    <form action="{{ route('bookings.update', $booking) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            {{-- Patient --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Patient Name</label>
                <input
                    type="text"
                    name="patient_name"
                    class="form-control"
                    value="{{ old('patient_name', $booking->patient_name) }}"
                    placeholder="e.g., Kofi Brandoh"
                    required
                >
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Phone</label>
                <input
                    type="text"
                    name="patient_phone"
                    class="form-control"
                    value="{{ old('patient_phone', $booking->patient_phone) }}"
                    placeholder="e.g., 024xxxxxxx"
                    required
                >
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Email (optional)</label>
                <input
                    type="email"
                    name="patient_email"
                    class="form-control"
                    value="{{ old('patient_email', $booking->patient_email) }}"
                    placeholder="e.g., patient@email.com"
                >
            </div>

            {{-- Booking --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Clinic</label>
                <select name="clinic_id" class="form-select" required>
                    <option value="">Select clinic</option>
                    @foreach($clinics as $clinic)
                        <option
                            value="{{ $clinic->id }}"
                            @selected((string)old('clinic_id', $booking->clinic_id) === (string)$clinic->id)
                        >
                            {{ $clinic->name }}
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Cardiology / Cardio-surgery etc.</div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Procedure (optional)</label>
                <select name="procedure_id" class="form-select">
                    <option value="">Select procedure</option>
                    @foreach($procedures as $p)
                        <option
                            value="{{ $p->id }}"
                            @selected((string)old('procedure_id', $booking->procedure_id) === (string)$p->id)
                        >
                            {{ $p->name }}
                            @if($p->clinic)
                                — ({{ $p->clinic->name }})
                            @endif
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Pick this only if it's a procedure booking.</div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Scheduled Date & Time</label>
                <input
                    type="datetime-local"
                    name="scheduled_at"
                    class="form-control"
                    value="{{ old('scheduled_at', \Carbon\Carbon::parse($booking->scheduled_at)->format('Y-m-d\TH:i')) }}"
                    required
                >
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Status</label>
                @php($status = old('status', $booking->status))
                <select name="status" class="form-select">
                    <option value="pending" @selected($status === 'pending')>Pending</option>
                    <option value="confirmed" @selected($status === 'confirmed')>Confirmed</option>
                    <option value="done" @selected($status === 'done')>Done</option>
                    <option value="cancelled" @selected($status === 'cancelled')>Cancelled</option>
                    <option value="no_show" @selected($status === 'no_show')>No Show</option>
                </select>
                <div class="form-text">Optional: you can lock this later.</div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update Booking
            </button>
        </div>
    </form>
</div>
@endsection
