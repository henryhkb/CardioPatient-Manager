@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="fw-bold mb-0">Reminders</h4>
            <div class="text-muted">Queued and sent reminders</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card card-soft p-3">
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Patient</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Booking Code</th>
                        <th>Channel</th>
                        <th>Reminder At</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reminders as $r)
                        <tr>
                            <td class="fw-semibold">
                                {{ optional($r->booking)->patient_name ?? '—' }}
                            </td>

                            <td>
                                <i class="bi bi-telephone me-1"></i>
                                {{ optional($r->booking)->patient_phone ?? '—' }}
                            </td>

                            <td>
                                <i class="bi bi-envelope me-1"></i>
                                {{ optional($r->booking)->patient_email ?? '—' }}
                            </td>

                            <td class="small text-muted">
                                {{ optional($r->booking)->booking_code ?? '—' }}
                            </td>

                            <td class="text-uppercase">
                                {{ $r->channel }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($r->reminder_at)->format('D, d M Y • h:i A') }}
                            </td>

                            <td>
                                @php
                                    $badge = match ($r->status) {
                                        'queued' => 'bg-warning text-dark',
                                        'sent' => 'bg-success',
                                        'failed' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badge }}">
                                    {{ strtoupper($r->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                {{-- Icons only for now (no routes yet) --}}
                                <button type="button" class="btn btn-sm btn-success" disabled title="Mark Sent (coming soon)">
                                    <i class="bi bi-check2-circle"></i>
                                </button>

                                <button type="button" class="btn btn-sm btn-outline-danger ms-1" disabled
                                    title="Mark Failed (coming soon)">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No reminders yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $reminders->links() }}
        </div>
    </div>
@endsection