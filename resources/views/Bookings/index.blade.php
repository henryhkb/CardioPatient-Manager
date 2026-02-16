@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="fw-bold mb-0">Bookings</h4>
            <div class="text-muted">Filter and manage scheduled bookings</div>
        </div>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary">
            <i class="bi bi-calendar-plus"></i> New Booking
        </a>
    </div>

    {{-- Quick buttons --}}
    <div class="d-flex flex-wrap gap-2 mb-3">
        <a class="btn btn-outline-dark btn-sm {{ request('quick') === 'today' ? 'active' : '' }}"
            href="{{ route('bookings.index', array_merge(request()->except('page'), ['quick' => 'today', 'from' => null, 'to' => null])) }}">
            Today
        </a>
        <a class="btn btn-outline-dark btn-sm {{ request('quick') === 'tomorrow' ? 'active' : '' }}"
            href="{{ route('bookings.index', array_merge(request()->except('page'), ['quick' => 'tomorrow', 'from' => null, 'to' => null])) }}">
            Tomorrow
        </a>
        <a class="btn btn-outline-dark btn-sm {{ request('quick') === 'week' ? 'active' : '' }}"
            href="{{ route('bookings.index', array_merge(request()->except('page'), ['quick' => 'week', 'from' => null, 'to' => null])) }}">
            This Week
        </a>

        <a class="btn btn-outline-secondary btn-sm" href="{{ route('bookings.index') }}">
            Reset
        </a>
    </div>

    {{-- Filters --}}
    <div class="card card-soft p-3 mb-3">
        <form method="GET" action="{{ route('bookings.index') }}" class="row g-2 align-items-end">
            <input type="hidden" name="quick" value="{{ request('quick') }}">

            <div class="col-md-3">
                <label class="form-label small text-muted mb-1">Search (name/phone/code)</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm"
                    placeholder="e.g. Ama / 024... / BK-...">
            </div>

            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All</option>
                    @foreach(['pending', 'confirmed', 'done', 'cancelled', 'no_show'] as $s)
                        <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst(str_replace('_', ' ', $s)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Type</label>
                <select name="booking_type" class="form-select form-select-sm">
                    <option value="">All</option>
                    <option value="clinic" @selected(request('booking_type') === 'clinic')>Clinic</option>
                    <option value="procedure" @selected(request('booking_type') === 'procedure')>Procedure</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Clinic</label>
                <select name="clinic_id" class="form-select form-select-sm">
                    <option value="">All</option>
                    @foreach($clinics as $c)
                        <option value="{{ $c->id }}" @selected((string) request('clinic_id') === (string) $c->id)>{{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small text-muted mb-1">Procedure</label>
                <select name="procedure_id" class="form-select form-select-sm">
                    <option value="">All</option>
                    @foreach($procedures as $p)
                        <option value="{{ $p->id }}" @selected((string) request('procedure_id') === (string) $p->id)>
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">From</label>
                <input type="date" name="from" value="{{ request('from') }}" class="form-control form-control-sm">
            </div>

            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">To</label>
                <input type="date" name="to" value="{{ request('to') }}" class="form-control form-control-sm">
            </div>

            <div class="col-md-8 d-flex gap-2">
                <button class="btn btn-sm btn-primary" type="submit">
                    <i class="bi bi-funnel"></i> Apply Filters
                </button>
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('bookings.index') }}">
                    Clear
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card card-soft p-3">
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Code</th>
                        <th>Patient</th>
                        <th>Type</th>
                        <th>Clinic / Procedure</th>
                        <th>Schedule</th>
                        <th>Status</th>
                        <th>Phone</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $b)
                        @php
                            $statusClass = match ($b->status) {
                                'pending' => 'bg-warning text-dark',
                                'confirmed' => 'bg-primary',
                                'done' => 'bg-success',
                                'cancelled' => 'bg-danger',
                                'no_show' => 'bg-dark',
                                default => 'bg-secondary'
                            };
                            $label = $b->booking_type === 'clinic'
                                ? optional($b->clinic)->name
                                : optional($b->procedure)->name;
                        @endphp
                        <tr>
                            <td class="fw-semibold">{{ $b->booking_code }}</td>
                            <td class="fw-semibold">{{ $b->patient_name }}</td>
                            <td class="text-capitalize">{{ $b->booking_type }}</td>
                            <td>{{ $label ?? '—' }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->scheduled_at)->format('D, d M Y • h:i A') }}</td>
                            <td><span class="badge {{ $statusClass }}">{{ $b->status }}</span></td>
                            <td>{{ $b->patient_phone }}</td>
                            <td class="text-end">

                                {{-- View --}}
                                <a href="{{ route('bookings.show', $b->id) }}" class="btn btn-link p-0 text-dark me-2"
                                    data-bs-toggle="tooltip" data-bs-title="View Details">
                                    <i class="bi bi-eye fs-5"></i>
                                </a>

                                <a href="{{ route('bookings.edit', $b) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                @if($b->status === 'pending')

                                    <form method="POST" action="{{ route('bookings.status', [$b->id, 'confirmed']) }}"
                                        class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-link p-0 text-success me-2" data-bs-toggle="tooltip"
                                            data-bs-title="Confirm Booking">
                                            <i class="bi bi-check-circle fs-5"></i>
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('bookings.status', [$b->id, 'cancelled']) }}"
                                        class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip"
                                            data-bs-title="Cancel Booking">
                                            <i class="bi bi-x-circle fs-5"></i>
                                        </button>
                                    </form>

                                @elseif($b->status === 'confirmed')

                                    <form method="POST" action="{{ route('bookings.status', [$b->id, 'done']) }}" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-link p-0 text-primary me-2" data-bs-toggle="tooltip"
                                            data-bs-title="Mark as Done">
                                            <i class="bi bi-check2-square fs-5"></i>
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('bookings.status', [$b->id, 'no_show']) }}"
                                        class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-link p-0 text-warning me-2" data-bs-toggle="tooltip"
                                            data-bs-title="Mark as No-show">
                                            <i class="bi bi-person-x fs-5"></i>
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('bookings.status', [$b->id, 'cancelled']) }}"
                                        class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip"
                                            data-bs-title="Cancel Booking">
                                            <i class="bi bi-x-circle fs-5"></i>
                                        </button>
                                    </form>

                                @else
                                    <i class="bi bi-lock text-muted" data-bs-toggle="tooltip" data-bs-title="Locked"></i>
                                @endif
                            </td>



                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection