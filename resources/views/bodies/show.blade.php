@extends('layouts.app')
@section('title', 'Body Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">{{ $body->full_name }} <span class="text-muted fs-6">({{ $body->ref_number }})</span></h3>
    <div class="d-flex gap-2">
        @if(auth()->user()->isAdmin() || auth()->user()->isAttendant())
            <a href="{{ route('bodies.edit', $body) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i> Edit</a>
        @endif
        @if(auth()->user()->isAdmin())
            <form method="POST" action="{{ route('bodies.destroy', $body) }}" onsubmit="return confirm('Delete this record permanently?')">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
            </form>
        @endif
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header"><strong>Body Information</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2"><strong>Status:</strong> <span class="badge bg-{{ $body->status_badge }}">{{ ucfirst(str_replace('_',' ',$body->status)) }}</span></div>
                    <div class="col-md-6 mb-2"><strong>Chamber:</strong> {{ optional($body->chamber)->name ?? 'Not Assigned' }}</div>
                    <div class="col-md-6 mb-2"><strong>Age:</strong> {{ $body->age ?? '-' }}</div>
                    <div class="col-md-6 mb-2"><strong>Sex:</strong> {{ ucfirst($body->sex) }}</div>
                    <div class="col-md-6 mb-2"><strong>Nationality:</strong> {{ $body->nationality }}</div>
                    <div class="col-md-6 mb-2"><strong>Date of Death:</strong> {{ optional($body->date_of_death)->format('d M Y') ?? '-' }}</div>
                    <div class="col-md-6 mb-2"><strong>Time of Death:</strong> {{ $body->time_of_death ?? '-' }}</div>
                    <div class="col-md-6 mb-2"><strong>Cause of Death:</strong> {{ $body->cause_of_death ?? '-' }}</div>
                    <div class="col-md-12 mb-2"><strong>Place of Death:</strong> {{ $body->place_of_death ?? '-' }}</div>
                    <div class="col-md-6 mb-2"><strong>Admitted By:</strong> {{ optional($body->admittedBy)->full_name }}</div>
                    <div class="col-md-6 mb-2"><strong>Admitted On:</strong> {{ $body->created_at->format('d M Y, h:i A') }}</div>
                    @if($body->notes)
                        <div class="col-12"><strong>Notes:</strong> {{ $body->notes }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><strong>Chamber Assignment History</strong></div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Chamber</th><th>Assigned At</th><th>Vacated At</th></tr></thead>
                    <tbody>
                        @forelse($body->assignments as $a)
                        <tr>
                            <td>{{ optional($a->chamber)->name }}</td>
                            <td>{{ $a->assigned_at->format('d M Y, h:i A') }}</td>
                            <td>{{ optional($a->vacated_at)->format('d M Y, h:i A') ?? 'Currently Stored' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">No chamber assignment history.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Next of Kin</strong>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kinModal"><i class="bi bi-plus-lg"></i></button>
            </div>
            <div class="card-body">
                @forelse($body->nextOfKins as $kin)
                    <div class="border rounded p-2 mb-2">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $kin->full_name }}</strong>
                            <form method="POST" action="{{ route('bodies.kins.destroy', [$body, $kin]) }}" onsubmit="return confirm('Remove this next of kin?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-link text-danger p-0"><i class="bi bi-x-lg"></i></button>
                            </form>
                        </div>
                        <div class="small text-muted">{{ $kin->relationship }} &bull; {{ $kin->phone }}</div>
                        @if($kin->id_type)<div class="small text-muted">{{ $kin->id_type }}: {{ $kin->id_number }}</div>@endif
                    </div>
                @empty
                    <p class="text-muted small mb-0">No next of kin recorded yet.</p>
                @endforelse
            </div>
        </div>

        @if(in_array($body->status, ['admitted', 'in_storage']))
        <div class="card">
            <div class="card-body">
                <a href="{{ route('releases.create') }}" class="btn btn-success w-100"><i class="bi bi-box-arrow-right"></i> Process Release</a>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Next of Kin Modal -->
<div class="modal fade" id="kinModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('bodies.kins.store', $body) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Next of Kin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2"><label class="form-label">Full Name *</label><input type="text" name="full_name" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Relationship *</label><input type="text" name="relationship" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Phone *</label><input type="text" name="phone" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Email</label><input type="email" name="email" class="form-control"></div>
                    <div class="row">
                        <div class="col-6 mb-2"><label class="form-label">ID Type</label><input type="text" name="id_type" class="form-control"></div>
                        <div class="col-6 mb-2"><label class="form-label">ID Number</label><input type="text" name="id_number" class="form-control"></div>
                    </div>
                    <div class="mb-2"><label class="form-label">Address</label><textarea name="address" class="form-control"></textarea></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
