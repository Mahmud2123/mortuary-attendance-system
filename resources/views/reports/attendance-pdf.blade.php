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
<h2>Staff Attendance Report</h2>
<p>Generated on {{ now()->format('d M Y, h:i A') }}</p>
<table>
<thead><tr><th>Staff</th><th>Staff ID</th><th>Clock In</th><th>Clock Out</th><th>Duration</th></tr></thead>
<tbody>
@foreach($logs as $l)
<tr>
<td>{{ optional($l->staff)->full_name }}</td><td>{{ optional($l->staff)->staff_id }}</td>
<td>{{ $l->clock_in->format('d M Y, h:i A') }}</td>
<td>{{ optional($l->clock_out)->format('d M Y, h:i A') ?? 'Active' }}</td>
<td>{{ $l->duration_hours ?? '-' }}</td>
</tr>
@endforeach
</tbody>
</table>
</body>
</html>
