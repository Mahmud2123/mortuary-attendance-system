@extends('layouts.app')
@section('title', 'Reports')

@section('content')
<h3 class="mb-4">Reports &amp; Exports</h3>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5><i class="bi bi-person-lines-fill"></i> Admissions Report</h5>
                <p class="text-muted small">Filter body admissions by date range and status.</p>
                <form class="row g-2 mb-3" method="GET" action="{{ route('reports.admissions') }}" target="_blank">
                    <div class="col-6"><input type="date" name="from" class="form-control form-control-sm"></div>
                    <div class="col-6"><input type="date" name="to" class="form-control form-control-sm"></div>
                    <div class="col-12 d-flex gap-2 mt-2">
                        <button class="btn btn-sm btn-outline-primary" onclick="this.form.format.value='pdf'">PDF</button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="this.form.format.value='csv'">CSV</button>
                        <input type="hidden" name="format" value="pdf">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5><i class="bi bi-clock-history"></i> Attendance Report</h5>
                <p class="text-muted small">Staff attendance logs by date range.</p>
                <form class="row g-2" method="GET" action="{{ route('reports.attendance') }}" target="_blank">
                    <div class="col-6"><input type="date" name="from" class="form-control form-control-sm"></div>
                    <div class="col-6"><input type="date" name="to" class="form-control form-control-sm"></div>
                    <div class="col-12 d-flex gap-2 mt-2">
                        <button class="btn btn-sm btn-outline-primary" onclick="this.form.format.value='pdf'">PDF</button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="this.form.format.value='csv'">CSV</button>
                        <input type="hidden" name="format" value="pdf">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5><i class="bi bi-snow"></i> Chamber Occupancy Report</h5>
                <p class="text-muted small">Current status of all cold storage chambers.</p>
                <form class="d-flex gap-2" method="GET" action="{{ route('reports.chambers') }}" target="_blank">
                    <button class="btn btn-sm btn-outline-primary" onclick="this.form.format.value='pdf'">PDF</button>
                    <button class="btn btn-sm btn-outline-secondary" onclick="this.form.format.value='csv'">CSV</button>
                    <input type="hidden" name="format" value="pdf">
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5><i class="bi bi-box-arrow-right"></i> Releases Report</h5>
                <p class="text-muted small">Body releases by date range.</p>
                <form class="row g-2" method="GET" action="{{ route('reports.releases') }}" target="_blank">
                    <div class="col-6"><input type="date" name="from" class="form-control form-control-sm"></div>
                    <div class="col-6"><input type="date" name="to" class="form-control form-control-sm"></div>
                    <div class="col-12 d-flex gap-2 mt-2">
                        <button class="btn btn-sm btn-outline-primary" onclick="this.form.format.value='pdf'">PDF</button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="this.form.format.value='csv'">CSV</button>
                        <input type="hidden" name="format" value="pdf">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
