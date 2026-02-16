@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">Dashboard</h4>
            <div class="text-muted">Korle Bu Cardio OPD Booking Platform</div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card card-soft p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Total Reminders</div>
                        <div class="fs-4 fw-bold">{{ $stats['total_reminders'] }}</div>
                    </div>
                    <div class="icon-badge bg-primary-subtle text-primary">
                        <i class="bi bi-bell fs-5"></i>
                    </div>
                </div>
                <a href="{{ route('reminders.dashboard') }}" class="btn btn-sm btn-primary mt-3 w-100">
                    <i class="bi bi-bell"></i> Manage Reminders
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-soft p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Clinics</div>
                        <div class="fs-4 fw-bold">{{ $stats['clinics'] }}</div>
                    </div>
                    <div class="icon-badge bg-success-subtle text-success">
                        <i class="bi bi-hospital fs-5"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-soft p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Procedures</div>
                        <div class="fs-4 fw-bold">{{ $stats['procedures'] }}</div>
                    </div>
                    <div class="icon-badge bg-warning-subtle text-warning">
                        <i class="bi bi-clipboard2-pulse fs-5"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <a href="{{ route('bookings.index') }}" class="text-decoration-none">
                <div class="card card-soft p-3 h-100 hover-shadow">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small">Total Bookings</div>
                            <div class="fs-4 fw-bold">{{ $stats['booked_procedures'] }}</div>
                        </div>
                        <div class="icon-badge bg-danger-subtle text-danger">
                            <i class="bi bi-calendar-check fs-5"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <div class="card card-soft p-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="fw-bold">Recent Bookings</div>
            <a href="{{ route('bookings.create') }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-calendar-plus"></i> New Booking
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Patient</th>
                        <th>Type</th>
                        <th>Schedule</th>
                        <th>Status</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $b)
                        <tr>
                            <td class="fw-semibold">{{ $b->patient_name }}</td>
                            <td class="text-capitalize">{{ $b->booking_type }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->scheduled_at)->format('D, d M Y • h:i A') }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $b->status }}</span>
                            </td>
                            <td>{{ $b->patient_phone }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No bookings yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection