@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<h3 class="mb-4">Dashboard Overview</h3>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-primary-soft">
            <i class="bi bi-person-lines-fill"></i>
            <div><h3>{{ $stats['total_bodies'] }}</h3><p>Total Bodies</p></div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-info-soft">
            <i class="bi bi-snow"></i>
            <div><h3>{{ $stats['in_storage'] }}</h3><p>In Storage</p></div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-warning-soft">
            <i class="bi bi-box-arrow-in-down"></i>
            <div><h3>{{ $stats['admitted_today'] }}</h3><p>Admitted Today</p></div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-success-soft">
            <i class="bi bi-box-arrow-right"></i>
            <div><h3>{{ $stats['released_today'] }}</h3><p>Released Today</p></div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4 col-sm-6">
        <div class="stat-card bg-secondary-soft">
            <i class="bi bi-grid-3x3-gap"></i>
            <div><h3>{{ $stats['available_chambers'] }}/{{ $stats['total_chambers'] }}</h3><p>Available Chambers</p></div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="stat-card bg-dark-soft">
            <i class="bi bi-person-badge"></i>
            <div><h3>{{ $stats['staff_on_duty'] }}</h3><p>Staff on Duty</p></div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header"><strong>Admissions vs Releases (Last 30 Days)</strong></div>
            <div class="card-body">
                <canvas id="trendChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header"><strong>Body Status Distribution</strong></div>
            <div class="card-body">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header"><strong>Chamber Occupancy</strong></div>
            <div class="card-body">
                <div class="chamber-grid">
                    @foreach($chambers as $chamber)
                        <a href="{{ route('chambers.show', $chamber) }}" class="chamber-box border-{{ $chamber->status_color }}">
                            <div class="chamber-name">{{ $chamber->name }}</div>
                            <div class="chamber-status badge bg-{{ $chamber->status_color }}">{{ ucfirst($chamber->status) }}</div>
                            <div class="chamber-occ">{{ $chamber->current_occupancy }}/{{ $chamber->capacity }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header"><strong>Recent Admissions</strong></div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Ref No.</th><th>Name</th><th>Status</th><th>Admitted By</th></tr></thead>
                    <tbody>
                        @foreach($recentBodies as $body)
                        <tr>
                            <td><a href="{{ route('bodies.show', $body) }}">{{ $body->ref_number }}</a></td>
                            <td>{{ $body->full_name }}</td>
                            <td><span class="badge bg-{{ $body->status_badge }}">{{ ucfirst(str_replace('_',' ', $body->status)) }}</span></td>
                            <td>{{ optional($body->admittedBy)->full_name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: @json($chartLabels),
        datasets: [
            { label: 'Admissions', data: @json($admissions), borderColor: '#0d6efd', tension: 0.3 },
            { label: 'Releases', data: @json($releases), borderColor: '#198754', tension: 0.3 },
        ]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});

new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Admitted', 'In Storage', 'Released', 'Transferred'],
        datasets: [{ data: @json($statusCounts), backgroundColor: ['#ffc107','#0dcaf0','#198754','#6c757d'] }]
    },
    options: { responsive: true }
});
</script>
@endpush
