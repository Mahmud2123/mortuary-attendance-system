@extends('layouts.app')
@section('title', 'Body Releases')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Body Releases</h3>
    <a href="{{ route('releases.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Process New Release</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Ref Number</th><th>Deceased</th><th>Released To</th><th>Released By</th><th>Date</th><th></th></tr></thead>
            <tbody>
                @forelse($releases as $release)
                <tr>
                    <td>{{ optional($release->body)->ref_number }}</td>
                    <td>{{ optional($release->body)->full_name }}</td>
                    <td>{{ optional($release->kin)->full_name }} ({{ optional($release->kin)->relationship }})</td>
                    <td>{{ optional($release->releasedBy)->full_name }}</td>
                    <td>{{ $release->release_date->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('releases.certificate', $release) }}" class="btn btn-sm btn-outline-primary">Certificate</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No releases recorded yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $releases->links() }}</div>
</div>
@endsection
