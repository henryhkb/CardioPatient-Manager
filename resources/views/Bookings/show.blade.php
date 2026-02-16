@extends('layouts.app')

@section('content')
<div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-3">
    <div>
        <div class="d-flex align-items-center gap-2">
            <h4 class="fw-bold mb-0">Booking Details</h4>
            <span class="badge bg-dark-subtle text-dark border">{{ $booking->booking_code }}</span>
        </div>
        <div class="text-muted small mt-1">
            Created: {{ $booking->created_at->format('D, d M Y • h:i A') }}
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('bookings.index') }}"
           class="btn btn-sm btn-outline-secondary"
           data-bs-toggle="tooltip" title="Back to Bookings">
            <i class="bi bi-arrow-left"></i>
        </a>

        <a href="{{ route('bookings.edit', $booking) }}"
           class="btn btn-sm btn-outline-primary"
           data-bs-toggle="tooltip" title="Edit Booking">
            <i class="bi bi-pencil-square"></i>
        </a>

        <form action="{{ route('bookings.destroy', $booking) }}" method="POST"
              onsubmit="return confirm('Delete this booking?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="btn btn-sm btn-outline-danger"
                    data-bs-toggle="tooltip" title="Delete Booking">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
</div>

<div class="row g-3">
    {{-- LEFT: Patient --}}
    <div class="col-lg-7">
        <div class="card card-soft">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="fw-bold">
                        <i class="bi bi-person-badge me-1"></i> Patient Information
                    </div>
                    <span class="badge {{ badgeClass($booking->status) }}">
                        {{ strtoupper(str_replace('_',' ', $booking->status)) }}
                    </span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-muted small">Patient Name</div>
                        <div class="fw-semibold">{{ $booking->patient_name }}</div>
                    </div>

                    <div class="col-md-3">
                        <div class="text-muted small">Age</div>
                        <div class="fw-semibold">{{ $booking->patient_age ?? '—' }}</div>
                    </div>

                    <div class="col-md-3">
                        <div class="text-muted small">Gender</div>
                        <div class="fw-semibold text-capitalize">{{ $booking->patient_gender ?? '—' }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small">Phone</div>
                        <div class="fw-semibold">
                            <i class="bi bi-telephone me-1"></i>{{ $booking->patient_phone }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small">Email</div>
                        <div class="fw-semibold">
                            <i class="bi bi-envelope me-1"></i>{{ $booking->patient_email ?? '—' }}
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="text-muted small">Home Address</div>
                        <div class="fw-semibold">{{ $booking->patient_home_address ?? '—' }}</div>
                    </div>

                    <div class="col-12">
                        <div class="text-muted small">Next of Kin</div>
                        <div class="fw-semibold">{{ $booking->patient_next_of_kin ?? '—' }}</div>
                    </div>

                    <div class="col-12">
                        <div class="text-muted small">Diagnosis / Notes</div>
                        <div class="fw-semibold">
                            {{ $booking->patient_diagnosis ?? '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT: Booking Summary --}}
    <div class="col-lg-5">
        <div class="card card-soft">
            <div class="card-body">
                <div class="fw-bold mb-3">
                    <i class="bi bi-calendar2-check me-1"></i> Booking Summary
                </div>

                <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">
                    <div class="text-muted small">Booking Type</div>
                    <div class="fw-semibold text-capitalize">
                        {{ $booking->booking_type }}
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">
                    <div class="text-muted small">Scheduled At</div>
                    <div class="fw-semibold">
                        {{ \Carbon\Carbon::parse($booking->scheduled_at)->format('D, d M Y • h:i A') }}
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">
                    <div class="text-muted small">Clinic</div>
                    <div class="fw-semibold">
                        {{ optional($booking->clinic)->name ?? '—' }}
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-3">
                    <div class="text-muted small">Procedure</div>
                    <div class="fw-semibold">
                        {{ optional($booking->procedure)->name ?? '—' }}
                    </div>
                </div>

                <hr class="my-3">

                <div class="fw-bold mb-2">
                    <i class="bi bi-lightning-charge me-1"></i> Quick Actions
                </div>

                <div class="d-flex flex-wrap gap-2">
                    {{-- Status Buttons --}}
                    <form method="POST" action="{{ route('bookings.setStatus', [$booking, 'confirmed']) }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-success"
                                data-bs-toggle="tooltip" title="Mark Confirmed">
                            <i class="bi bi-check2-circle"></i>
                        </button>
                    </form>

                    <form method="POST" action="{{ route('bookings.setStatus', [$booking, 'done']) }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary"
                                data-bs-toggle="tooltip" title="Mark Done">
                            <i class="bi bi-clipboard2-check"></i>
                        </button>
                    </form>

                    <form method="POST" action="{{ route('bookings.setStatus', [$booking, 'no_show']) }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-warning"
                                data-bs-toggle="tooltip" title="Mark No Show">
                            <i class="bi bi-person-x"></i>
                        </button>
                    </form>

                    <form method="POST" action="{{ route('bookings.setStatus', [$booking, 'cancelled']) }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger"
                                data-bs-toggle="tooltip" title="Cancel Booking">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </form>

                    {{-- Optional: Create Reminder shortcut --}}
                    <a href="{{ route('reminders.create', ['booking_id' => $booking->id]) }}"
                       class="btn btn-sm btn-outline-secondary"
                       data-bs-toggle="tooltip" title="Add Reminder">
                        <i class="bi bi-bell"></i>
                    </a>
                </div>

                <div class="text-muted small mt-3">
                    Tip: hover icons to see actions.
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tooltip init --}}
@push('scripts')
<script>
document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
</script>
@endpush
@endsection

@php
    // Put this helper inside the same blade file for now (later we can move to a global helper)
    function badgeClass($status) {
        return match($status) {
            'pending' => 'bg-secondary',
            'confirmed' => 'bg-success',
            'done' => 'bg-primary',
            'cancelled' => 'bg-danger',
            'no_show' => 'bg-warning text-dark',
            default => 'bg-secondary'
        };
    }
@endphp
