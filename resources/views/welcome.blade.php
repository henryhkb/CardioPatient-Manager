@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row align-items-center g-4">

        <div class="col-lg-6">
            <span class="badge bg-primary-subtle text-primary border mb-3">
                Korle Bu • OPD Booking Platform
            </span>

            <h1 class="fw-bold display-5 mb-3">
                Cardio OPD Booking & Reminders
            </h1>

            <p class="text-muted mb-4" style="max-width: 520px;">
                Manage clinic bookings, procedures, and patient reminders in one place.
                Built for fast daily OPD workflows.
            </p>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-speedometer2 me-1"></i> Go to Dashboard
                </a>

                <a href="{{ route('bookings.create') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-calendar-plus me-1"></i> New Booking
                </a>
            </div>

            <div class="mt-4 small text-muted">
                Tip: You can manage bulk reminders from the Reminders dashboard.
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="icon-badge bg-danger-subtle text-danger">
                            <i class="bi bi-heart-pulse fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Fast OPD Flow</div>
                            <div class="text-muted small">Book • Track • Remind</div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="border rounded p-3">
                                <div class="fw-semibold mb-1">Bookings</div>
                                <div class="text-muted small">
                                    Create clinic/procedure bookings and manage status transitions.
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="border rounded p-3">
                                <div class="fw-semibold mb-1">Procedures</div>
                                <div class="text-muted small">
                                    Maintain procedure list per clinic and attach patient education notes.
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="border rounded p-3">
                                <div class="fw-semibold mb-1">Reminders</div>
                                <div class="text-muted small">
                                    Queue bulk reminders for holidays/closures and track delivery status.
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">Ready to begin?</div>
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-dark">
                            Open Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
