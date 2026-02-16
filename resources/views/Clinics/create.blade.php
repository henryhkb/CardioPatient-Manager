@extends('layouts.app')

@section('content')
<div class="mb-3">
    <h4 class="fw-bold mb-0">Add Clinic</h4>
    <div class="text-muted">Create a clinic unit</div>
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
    <form method="POST" action="{{ route('clinics.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Clinic Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="e.g., Cardio OPD" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Location (optional)</label>
            <input type="text" name="location" value="{{ old('location') }}" class="form-control" placeholder="e.g., Korle Bu, Block A">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Patient Education (optional)</label>
            <textarea name="education" rows="4" class="form-control" placeholder="Info to send in messages...">{{ old('education') }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
            <label class="form-check-label" for="is_active">Active</label>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary">
                <i class="bi bi-check2-circle"></i> Save Clinic
            </button>
            <a href="{{ route('clinics.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
