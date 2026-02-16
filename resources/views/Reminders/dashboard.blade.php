@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="fw-bold mb-0">Reminder Dashboard</h4>
        <div class="text-muted">Select patients and queue reminders (bulk or individual)</div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('reminders.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-list-ul"></i> Reminder Records
        </a>
        <a href="{{ route('reminders.create') }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus-circle"></i> Single Reminder
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

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

{{-- Date range filter --}}
<div class="card card-soft p-3 mb-3">
    <form method="GET" action="{{ route('reminders.dashboard') }}" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label small text-muted mb-1">From</label>
            <input type="date" name="from" class="form-control form-control-sm"
                   value="{{ request('from', \Carbon\Carbon::parse($from)->format('Y-m-d')) }}">
        </div>

        <div class="col-md-3">
            <label class="form-label small text-muted mb-1">To</label>
            <input type="date" name="to" class="form-control form-control-sm"
                   value="{{ request('to', \Carbon\Carbon::parse($to)->format('Y-m-d')) }}">
        </div>

        <div class="col-md-6 d-flex gap-2">
            <button class="btn btn-sm btn-primary" type="submit">
                <i class="bi bi-funnel"></i> Apply
            </button>
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('reminders.dashboard') }}">
                Reset
            </a>

            <a class="btn btn-sm btn-outline-dark ms-auto" href="{{ route('bookings.index', ['quick' => 'today']) }}">
                <i class="bi bi-calendar-day"></i> Today’s bookings
            </a>
        </div>
    </form>
</div>

<form method="POST" action="{{ route('reminders.bulk') }}">
    @csrf

    {{-- Bulk reminder settings --}}
    <div class="card card-soft p-3 mb-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="fw-bold">
                <i class="bi bi-send me-1"></i> Bulk Reminder Setup
            </div>

            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-dark" onclick="toggleAll(true)">
                    Select All
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleAll(false)">
                    Clear All
                </button>
            </div>
        </div>

        <div class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Channel</label>
                <select name="channel" class="form-select form-select-sm" required>
                    <option value="sms">SMS</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="email">Email</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small text-muted mb-1">Reminder Time</label>
                <input type="datetime-local" name="reminder_at"
                       class="form-control form-control-sm"
                       value="{{ now()->addMinutes(5)->format('Y-m-d\TH:i') }}"
                       required>
            </div>

            <div class="col-md-7">
                <label class="form-label small text-muted mb-1">Message</label>
                <input type="text" name="message" class="form-control form-control-sm"
                       placeholder="e.g. Clinic closed tomorrow due to public holiday. Please reschedule..."
                       required>
                <div class="form-text">
                    Use this for closure notices, holidays, system downtime, etc.
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button class="btn btn-sm btn-success">
                <i class="bi bi-send-check"></i> Queue Bulk Reminders (Selected)
            </button>
        </div>
    </div>

    {{-- Bookings table --}}
    <div class="card card-soft p-3">
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:40px;"></th>
                        <th>Patient</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Clinic</th>
                        <th>Procedure</th>
                        <th>Scheduled</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($bookings as $b)
                    <tr>
                        <td>
                            <input class="form-check-input booking-check"
                                   type="checkbox"
                                   name="booking_ids[]"
                                   value="{{ $b->id }}">
                        </td>

                        <td class="fw-semibold">{{ $b->patient_name }}</td>
                        <td><i class="bi bi-telephone me-1"></i>{{ $b->patient_phone }}</td>
                        <td><i class="bi bi-envelope me-1"></i>{{ $b->patient_email ?? '—' }}</td>

                        <td>{{ optional($b->clinic)->name ?? '—' }}</td>
                        <td>{{ optional($b->procedure)->name ?? '—' }}</td>

                        <td>{{ \Carbon\Carbon::parse($b->scheduled_at)->format('D, d M Y • h:i A') }}</td>
                        <td><span class="badge bg-secondary">{{ $b->status }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            No upcoming bookings found in this date range.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-muted small mt-2">
            Tip: Select patients and send one bulk message (holiday/closure notice).
        </div>
    </div>
</form>

@push('scripts')
<script>
function toggleAll(state) {
    document.querySelectorAll('.booking-check').forEach(cb => cb.checked = state);
}
</script>
@endpush
@endsection
