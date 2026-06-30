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
<h2>Chamber Occupancy Report</h2>
<p>Generated on {{ now()->format('d M Y, h:i A') }}</p>
<table>
<thead><tr><th>Name</th><th>Location</th><th>Capacity</th><th>Occupied</th><th>Status</th></tr></thead>
<tbody>
@foreach($chambers as $c)
<tr>
<td>{{ $c->name }}</td><td>{{ $c->location }}</td><td>{{ $c->capacity }}</td>
<td>{{ $c->current_occupancy }}</td><td>{{ ucfirst($c->status) }}</td>
</tr>
@endforeach
</tbody>
</table>
</body>
</html>
