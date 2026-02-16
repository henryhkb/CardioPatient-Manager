@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="mb-0 fw-bold">Procedures</h4>
            <small class="text-muted">Manage OPD procedures and patient education content.</small>
        </div>

        <a href="{{ route('procedures.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Add Procedure
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($procedures->count() === 0)
                <div class="text-center py-5">
                    <i class="bi bi-clipboard2-pulse fs-1 text-muted"></i>
                    <p class="mt-3 mb-0 fw-semibold">No procedures yet</p>
                    <p class="text-muted">Click “Add Procedure” to create the first one.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Clinic</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procedures as $procedure)
                                <tr>
                                    <td class="fw-semibold">{{ $procedure->name }}</td>
                                    <td class="text-muted">
                                        {{ optional($procedure->clinic)->name ?? '—' }}
                                    </td>
                                    <td>
                                        @if($procedure->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('procedures.edit', $procedure) }}" class="btn btn-outline-dark btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('procedures.destroy', $procedure) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Delete this procedure?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $procedures->links() }}
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
