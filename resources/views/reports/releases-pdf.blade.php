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
<h2>Body Releases Report</h2>
<p>Generated on {{ now()->format('d M Y, h:i A') }}</p>
<table>
<thead><tr><th>Ref No.</th><th>Deceased</th><th>Released To</th><th>Relationship</th><th>Released By</th><th>Date</th></tr></thead>
<tbody>
@foreach($releases as $r)
<tr>
<td>{{ optional($r->body)->ref_number }}</td><td>{{ optional($r->body)->full_name }}</td>
<td>{{ optional($r->kin)->full_name }}</td><td>{{ optional($r->kin)->relationship }}</td>
<td>{{ optional($r->releasedBy)->full_name }}</td><td>{{ $r->release_date->format('d M Y') }}</td>
</tr>
@endforeach
</tbody>
</table>
</body>
</html>
