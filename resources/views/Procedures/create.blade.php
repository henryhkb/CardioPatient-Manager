@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="mb-3">
        <h4 class="fw-bold">Add Procedure</h4>
        <small class="text-muted">Create a new cardiology procedure.</small>
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

            <form method="POST" action="{{ route('procedures.store') }}">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Clinic</label>
                        <select name="clinic_id" class="form-select">
                            <option value="">Select clinic</option>
                            @foreach($clinics as $clinic)
                                <option value="{{ $clinic->id }}">
                                    {{ $clinic->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Procedure Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Patient Education Content</label>
                        <textarea name="education" class="form-control" rows="4"
                            placeholder="Instructions to send in reminder messages..."></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Default Duration (minutes)</label>
                        <input type="number" name="default_duration_minutes" class="form-control">
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="is_active" value="1" checked>
                            <label class="form-check-label">
                                Active
                            </label>
                        </div>
                    </div>

                </div>

                <div class="mt-4">
                    <button class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Save Procedure
                    </button>
                    <a href="{{ route('procedures.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
