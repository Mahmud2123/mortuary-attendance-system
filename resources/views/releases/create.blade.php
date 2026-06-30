@extends('layouts.app')
@section('title', 'Process Release')

@section('content')
<h3 class="mb-4">Process Body Release</h3>

<div class="card">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <!-- Step indicator -->
        <div class="step-indicator mb-4">
            <span class="step active" data-step="1">1. Select Body</span>
            <span class="step" data-step="2">2. Verify Next of Kin</span>
            <span class="step" data-step="3">3. Confirm &amp; Release</span>
        </div>

        <form method="POST" action="{{ route('releases.store') }}" id="releaseForm">
            @csrf

            <!-- Step 1 -->
            <div class="release-step" id="stepPane1">
                <label class="form-label">Select Body to Release *</label>
                <select id="bodySelect" name="body_id" class="form-select" required>
                    <option value="">-- Choose a body --</option>
                    @foreach($bodies as $body)
                        <option value="{{ $body->id }}" data-kins='@json($body->nextOfKins)'>
                            {{ $body->ref_number }} — {{ $body->full_name }}
                        </option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-primary mt-3" onclick="goToStep(2)">Next</button>
            </div>

            <!-- Step 2 -->
            <div class="release-step d-none" id="stepPane2">
                <label class="form-label">Select Verified Next of Kin *</label>
                <div id="kinList" class="mb-3"></div>
                <p class="text-muted small" id="noKinMsg" style="display:none;">No next of kin recorded for this body. Please add one from the body's detail page before releasing.</p>
                <button type="button" class="btn btn-outline-secondary" onclick="goToStep(1)">Back</button>
                <button type="button" class="btn btn-primary" onclick="goToStep(3)">Next</button>
            </div>

            <!-- Step 3 -->
            <div class="release-step d-none" id="stepPane3">
                <div class="mb-3">
                    <label class="form-label">Release Date *</label>
                    <input type="date" name="release_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="confirm" class="form-check-input" id="confirmCheck" required>
                    <label class="form-check-label" for="confirmCheck">
                        I confirm the identity of the next of kin has been verified and authorization documents are in order.
                    </label>
                </div>
                <button type="button" class="btn btn-outline-secondary" onclick="goToStep(2)">Back</button>
                <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Confirm Release</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function goToStep(n) {
    document.querySelectorAll('.release-step').forEach(el => el.classList.add('d-none'));
    document.getElementById('stepPane' + n).classList.remove('d-none');
    document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
    document.querySelector(`.step[data-step="${n}"]`).classList.add('active');

    if (n === 2) loadKins();
}

function loadKins() {
    const select = document.getElementById('bodySelect');
    const opt = select.options[select.selectedIndex];
    const kins = JSON.parse(opt.dataset.kins || '[]');
    const list = document.getElementById('kinList');
    const noKinMsg = document.getElementById('noKinMsg');
    list.innerHTML = '';

    if (kins.length === 0) {
        noKinMsg.style.display = 'block';
        return;
    }
    noKinMsg.style.display = 'none';

    kins.forEach(kin => {
        const div = document.createElement('div');
        div.className = 'form-check border rounded p-2 mb-2';
        div.innerHTML = `
            <input class="form-check-input" type="radio" name="kin_id" id="kin${kin.id}" value="${kin.id}" required>
            <label class="form-check-label w-100" for="kin${kin.id}">
                <strong>${kin.full_name}</strong> — ${kin.relationship}<br>
                <span class="text-muted small">${kin.phone} ${kin.id_type ? '| ' + kin.id_type + ': ' + kin.id_number : ''}</span>
            </label>`;
        list.appendChild(div);
    });
}
</script>
@endpush
