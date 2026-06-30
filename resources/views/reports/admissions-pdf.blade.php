<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><style>
body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
h2 { text-align: center; }
table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
th { background: #f0f0f0; }
</style></head>
<body>
<h2>Body Admissions Report</h2>
<p>Generated on {{ now()->format('d M Y, h:i A') }}</p>
<table>
<thead><tr><th>Ref No.</th><th>Name</th><th>Age</th><th>Sex</th><th>Status</th><th>Chamber</th><th>Admitted By</th><th>Date</th></tr></thead>
<tbody>
@foreach($bodies as $b)
<tr>
<td>{{ $b->ref_number }}</td><td>{{ $b->full_name }}</td><td>{{ $b->age }}</td><td>{{ ucfirst($b->sex) }}</td>
<td>{{ ucfirst(str_replace('_',' ',$b->status)) }}</td><td>{{ optional($b->chamber)->name ?? '-' }}</td>
<td>{{ optional($b->admittedBy)->full_name }}</td><td>{{ $b->created_at->format('d M Y') }}</td>
</tr>
@endforeach
</tbody>
</table>
</body>
</html>
