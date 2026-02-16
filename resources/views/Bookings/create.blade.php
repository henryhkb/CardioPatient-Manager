@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="mb-3">
        <h4 class="fw-bold">New Booking</h4>
        <small class="text-muted">Schedule a clinic visit or procedure.</small>
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

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form method="POST" action="{{ route('bookings.store') }}">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Booking Type</label>
                        <select name="booking_type" class="form-select" required>
                            <option value="">Select type</option>
                            <option value="clinic">Clinic</option>
                            <option value="procedure">Procedure</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Schedule Date & Time</label>
                        <input type="datetime-local" name="scheduled_at" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Clinic</label>
                        <select name="clinic_id" class="form-select">
                            <option value="">Select clinic</option>
                            @foreach($clinics as $clinic)
                                <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Procedure</label>
                        <select name="procedure_id" class="form-select">
                            <option value="">Select procedure</option>
                            @foreach($procedures as $procedure)
                                <option value="{{ $procedure->id }}">{{ $procedure->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold">Patient Information</h6>

                    <div class="col-md-6">
                        <label class="form-label">Patient Name</label>
                        <input type="text" name="patient_name" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Age</label>
                        <input type="number" name="patient_age" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Gender</label>
                        <select name="patient_gender" class="form-select">
                            <option value="">Select</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Diagnosis</label>
                        <textarea name="patient_diagnosis" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Home Address</label>
                        <input type="text" name="patient_home_address" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Next of Kin</label>
                        <input type="text" name="patient_next_of_kin" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Telephone</label>
                        <input type="text" name="patient_phone" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email (optional)</label>
                        <input type="email" name="patient_email" class="form-control">
                    </div>

                </div>

                <div class="mt-4">
                    <button class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Save Booking
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
