@extends('layouts.app')

@section('content')
<div class="mb-3">
    <h4 class="fw-bold mb-0">Edit Clinic</h4>
    <div class="text-muted">Update clinic details</div>
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
    <form method="POST" action="{{ route('clinics.update', $clinic) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Clinic Name</label>
            <input type="text" name="name" value="{{ old('name', $clinic->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Location (optional)</label>
            <input type="text" name="location" value="{{ old('location', $clinic->location) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Patient Education (optional)</label>
            <textarea name="education" rows="4" class="form-control">{{ old('education', $clinic->education) }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                {{ old('is_active', $clinic->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary">
                <i class="bi bi-check2-circle"></i> Update Clinic
            </button>
            <a href="{{ route('clinics.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection
