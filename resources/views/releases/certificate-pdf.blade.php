<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
    h2, h4 { text-align: center; margin: 4px 0; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    td { padding: 6px 4px; vertical-align: top; }
    .label { font-weight: bold; width: 180px; }
    hr { border: 0; border-top: 1px solid #999; margin: 16px 0; }
    .sig { text-align: center; width: 50%; padding-top: 60px; }
    .sig-line { border-top: 1px solid #333; width: 80%; margin: 0 auto; padding-top: 6px; }
</style>
</head>
<body>
    <h2>MORTUARY ATTENDANCE MANAGEMENT SYSTEM</h2>
    <h4>Official Body Release Certificate</h4>
    <hr>

    <table>
        <tr>
            <td><strong>Certificate No:</strong> REL-{{ str_pad($release->id, 6, '0', STR_PAD_LEFT) }}</td>
            <td style="text-align:right;"><strong>Date Issued:</strong> {{ $release->release_date->format('d M Y') }}</td>
        </tr>
    </table>

    <h4 style="text-align:left;">Deceased Information</h4>
    <table>
        <tr><td class="label">Reference Number</td><td>{{ $release->body->ref_number }}</td></tr>
        <tr><td class="label">Full Name</td><td>{{ $release->body->full_name }}</td></tr>
        <tr><td class="label">Age / Sex</td><td>{{ $release->body->age }} / {{ ucfirst($release->body->sex) }}</td></tr>
        <tr><td class="label">Date of Death</td><td>{{ optional($release->body->date_of_death)->format('d M Y') }}</td></tr>
    </table>

    <h4 style="text-align:left;">Released To (Next of Kin)</h4>
    <table>
        <tr><td class="label">Full Name</td><td>{{ optional($release->kin)->full_name }}</td></tr>
        <tr><td class="label">Relationship</td><td>{{ optional($release->kin)->relationship }}</td></tr>
        <tr><td class="label">Phone</td><td>{{ optional($release->kin)->phone }}</td></tr>
        <tr><td class="label">ID Verification</td><td>{{ optional($release->kin)->id_type }}: {{ optional($release->kin)->id_number }}</td></tr>
    </table>

    @if($release->notes)
    <h4 style="text-align:left;">Notes</h4>
    <p>{{ $release->notes }}</p>
    @endif

    <table style="margin-top: 60px;">
        <tr>
            <td class="sig"><div class="sig-line">Authorized By: {{ optional($release->releasedBy)->full_name }}</div></td>
            <td class="sig"><div class="sig-line">Received By: {{ optional($release->kin)->full_name }}</div></td>
        </tr>
    </table>
</body>
</html>
