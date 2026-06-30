<?php

namespace App\Http\Controllers;

use App\Models\Body;
use App\Models\BodyRelease;
use App\Models\Chamber;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReleaseController extends Controller
{
    public function index()
    {
        $releases = BodyRelease::with('body', 'releasedBy', 'kin')->latest()->paginate(15);
        return view('releases.index', compact('releases'));
    }

    public function create()
    {
        $bodies = Body::whereIn('status', ['admitted', 'in_storage'])->with('nextOfKins')->get();
        return view('releases.create', compact('bodies'));
    }

    public function getKins(Body $body)
    {
        return response()->json($body->nextOfKins);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'body_id'      => 'required|exists:bodies,id',
            'kin_id'       => 'required|exists:next_of_kins,id',
            'release_date' => 'required|date',
            'notes'        => 'nullable|string',
            'confirm'      => 'required|accepted',
        ]);

        $body = Body::findOrFail($validated['body_id']);

        if ($body->status === 'released') {
            return back()->with('error', 'This body has already been released.');
        }

        DB::transaction(function () use ($validated, $body) {
            BodyRelease::create([
                'body_id'      => $body->id,
                'released_by'  => auth()->id(),
                'kin_id'       => $validated['kin_id'],
                'release_date' => $validated['release_date'],
                'notes'        => $validated['notes'] ?? null,
            ]);

            // Vacate chamber if assigned
            if ($body->chamber_id) {
                $chamber = Chamber::find($body->chamber_id);
                if ($chamber) {
                    $chamber->decrement('current_occupancy');
                    if ($chamber->status === 'full') {
                        $chamber->update(['status' => 'available']);
                    }
                }

                $body->assignments()
                    ->whereNull('vacated_at')
                    ->latest()
                    ->first()
                    ?->update(['vacated_at' => now()]);
            }

            $old = $body->toArray();
            $body->update(['status' => 'released', 'chamber_id' => null]);

            AuditLog::record('update', 'bodies', $body->id, $old, $body->fresh()->toArray());
        });

        return redirect()->route('releases.index')->with('success', 'Body released successfully. Certificate ready for printing.');
    }

    public function certificate(BodyRelease $release)
    {
        $release->load('body', 'releasedBy', 'kin');
        return view('releases.certificate', compact('release'));
    }

    public function certificatePdf(BodyRelease $release)
    {
        $release->load('body', 'releasedBy', 'kin');
        $pdf = \PDF::loadView('releases.certificate-pdf', compact('release'));
        return $pdf->download('release-certificate-' . $release->body->ref_number . '.pdf');
    }
}
