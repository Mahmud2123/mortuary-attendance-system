<?php

namespace App\Http\Controllers;

use App\Models\Body;
use App\Models\Chamber;
use App\Models\NextOfKin;
use App\Models\BodyChamberAssignment;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BodyController extends Controller
{
    public function index(Request $request)
    {
        $query = Body::with('admittedBy', 'chamber');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($q2) => $q2->where('full_name', 'like', "%{$q}%")
                                        ->orWhere('ref_number', 'like', "%{$q}%"));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $bodies = $query->latest()->paginate(15)->withQueryString();
        return view('bodies.index', compact('bodies'));
    }

    public function create()
    {
        $chambers = Chamber::where('status', 'available')->get();
        return view('bodies.create', compact('chambers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'age'            => 'nullable|integer|min:0|max:150',
            'sex'            => 'required|in:male,female,unknown',
            'nationality'    => 'required|string|max:100',
            'date_of_death'  => 'nullable|date|before_or_equal:today',
            'time_of_death'  => 'nullable|date_format:H:i',
            'cause_of_death' => 'nullable|string|max:255',
            'place_of_death' => 'nullable|string|max:255',
            'chamber_id'     => 'nullable|exists:chambers,id',
            'notes'          => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $validated['admitted_by'] = auth()->id();
            $validated['ref_number']  = Body::generateRefNumber();
            $validated['status']      = $validated['chamber_id'] ? 'in_storage' : 'admitted';

            $body = Body::create($validated);

            if ($validated['chamber_id']) {
                $chamber = Chamber::findOrFail($validated['chamber_id']);
                $chamber->increment('current_occupancy');
                if ($chamber->current_occupancy >= $chamber->capacity) {
                    $chamber->update(['status' => 'full']);
                }

                BodyChamberAssignment::create([
                    'body_id'     => $body->id,
                    'chamber_id'  => $validated['chamber_id'],
                    'assigned_at' => now(),
                ]);
            }

            AuditLog::record('create', 'bodies', $body->id, null, $body->toArray());
        });

        return redirect()->route('bodies.index')->with('success', 'Body admitted successfully.');
    }

    public function show(Body $body)
    {
        $body->load('admittedBy', 'chamber', 'nextOfKins', 'releases.releasedBy', 'assignments.chamber');
        return view('bodies.show', compact('body'));
    }

    public function edit(Body $body)
    {
        $chambers = Chamber::where('status', '!=', 'maintenance')->get();
        return view('bodies.edit', compact('body', 'chambers'));
    }

    public function update(Request $request, Body $body)
    {
        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'age'            => 'nullable|integer|min:0|max:150',
            'sex'            => 'required|in:male,female,unknown',
            'nationality'    => 'required|string|max:100',
            'date_of_death'  => 'nullable|date',
            'time_of_death'  => 'nullable|date_format:H:i',
            'cause_of_death' => 'nullable|string|max:255',
            'place_of_death' => 'nullable|string|max:255',
            'status'         => 'required|in:admitted,in_storage,released,transferred',
            'notes'          => 'nullable|string',
        ]);

        $old = $body->toArray();
        $body->update($validated);
        AuditLog::record('update', 'bodies', $body->id, $old, $body->fresh()->toArray());

        return redirect()->route('bodies.show', $body)->with('success', 'Body record updated.');
    }

    public function destroy(Body $body)
    {
        AuditLog::record('delete', 'bodies', $body->id, $body->toArray(), null);
        $body->delete();
        return redirect()->route('bodies.index')->with('success', 'Body record deleted.');
    }

    // Next of Kin CRUD
    public function storeKin(Request $request, Body $body)
    {
        $validated = $request->validate([
            'full_name'    => 'required|string|max:255',
            'relationship' => 'required|string|max:100',
            'phone'        => 'required|string|max:20',
            'email'        => 'nullable|email',
            'id_type'      => 'nullable|string|max:50',
            'id_number'    => 'nullable|string|max:50',
            'address'      => 'nullable|string',
        ]);

        $body->nextOfKins()->create($validated);
        return redirect()->route('bodies.show', $body)->with('success', 'Next of kin added.');
    }

    public function destroyKin(Body $body, NextOfKin $kin)
    {
        $kin->delete();
        return redirect()->route('bodies.show', $body)->with('success', 'Next of kin removed.');
    }
}
