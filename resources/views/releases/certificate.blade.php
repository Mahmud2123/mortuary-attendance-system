@extends('layouts.app')
@section('title', 'Release Certificate')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Release Certificate</h3>
    <a href="{{ route('releases.certificate.pdf', $release) }}" class="btn btn-primary"><i class="bi bi-download"></i> Download PDF</a>
</div>

<div class="card certificate-card">
    <div class="card-body p-5">
        <div class="text-center mb-4">
            <h4>MORTUARY ATTENDANCE MANAGEMENT SYSTEM</h4>
            <p class="text-muted">Official Body Release Certificate</p>
            <hr>
        </div>

        <div class="row mb-4">
            <div class="col-6"><strong>Certificate No:</strong> REL-{{ str_pad($release->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div class="col-6 text-end"><strong>Date Issued:</strong> {{ $release->release_date->format('d M Y') }}</div>
        </div>

        <h5>Deceased Information</h5>
        <table class="table table-borderless mb-4">
            <tr><td width="200"><strong>Reference Number</strong></td><td>{{ $release->body->ref_number }}</td></tr>
            <tr><td><strong>Full Name</strong></td><td>{{ $release->body->full_name }}</td></tr>
            <tr><td><strong>Age / Sex</strong></td><td>{{ $release->body->age }} / {{ ucfirst($release->body->sex) }}</td></tr>
            <tr><td><strong>Date of Death</strong></td><td>{{ optional($release->body->date_of_death)->format('d M Y') }}</td></tr>
        </table>

        <h5>Released To (Next of Kin)</h5>
        <table class="table table-borderless mb-4">
            <tr><td width="200"><strong>Full Name</strong></td><td>{{ optional($release->kin)->full_name }}</td></tr>
            <tr><td><strong>Relationship</strong></td><td>{{ optional($release->kin)->relationship }}</td></tr>
            <tr><td><strong>Phone</strong></td><td>{{ optional($release->kin)->phone }}</td></tr>
            <tr><td><strong>ID Verification</strong></td><td>{{ optional($release->kin)->id_type }}: {{ optional($release->kin)->id_number }}</td></tr>
        </table>

        @if($release->notes)
        <h5>Notes</h5>
        <p>{{ $release->notes }}</p>
        @endif

        <div class="row mt-5 pt-5">
            <div class="col-6 text-center"><hr><p>Authorized By: {{ optional($release->releasedBy)->full_name }}</p></div>
            <div class="col-6 text-center"><hr><p>Received By: {{ optional($release->kin)->full_name }}</p></div>
        </div>
    </div>
</div>
@endsection
