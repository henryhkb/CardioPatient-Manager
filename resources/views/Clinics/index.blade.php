@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="fw-bold mb-0">Clinics</h4>
        <div class="text-muted">Manage clinic units (e.g., Cardio OPD)</div>
    </div>
    <a class="btn btn-primary" href="{{ route('clinics.create') }}">
        <i class="bi bi-plus-circle"></i> Add Clinic
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card card-soft p-3">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clinics as $clinic)
                    <tr>
                        <td class="fw-semibold">{{ $clinic->name }}</td>
                        <td class="text-muted">{{ $clinic->location ?? '—' }}</td>
                        <td>
                            @if($clinic->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('clinics.edit', $clinic) }}">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('clinics.destroy', $clinic) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this clinic?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            No clinics yet. Click “Add Clinic”.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $clinics->links() }}
    </div>
</div>
@endsection
