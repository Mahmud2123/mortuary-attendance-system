<?php

namespace App\Http\Controllers;

use App\Models\Chamber;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class ChamberController extends Controller
{
    public function index()
    {
        $chambers = Chamber::withCount('bodies')->get();
        return view('chambers.index', compact('chambers'));
    }

    public function create()
    {
        return view('chambers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'status'   => 'required|in:available,full,maintenance',
            'notes'    => 'nullable|string',
        ]);

        $chamber = Chamber::create($validated);
        AuditLog::record('create', 'chambers', $chamber->id, null, $chamber->toArray());

        return redirect()->route('chambers.index')->with('success', 'Chamber created successfully.');
    }

    public function show(Chamber $chamber)
    {
        $chamber->load(['bodies' => fn($q) => $q->where('status', 'in_storage'), 'assignments.body']);
        return view('chambers.show', compact('chamber'));
    }

    public function edit(Chamber $chamber)
    {
        return view('chambers.edit', compact('chamber'));
    }

    public function update(Request $request, Chamber $chamber)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'status'   => 'required|in:available,full,maintenance',
            'notes'    => 'nullable|string',
        ]);

        $old = $chamber->toArray();
        $chamber->update($validated);
        AuditLog::record('update', 'chambers', $chamber->id, $old, $chamber->fresh()->toArray());

        return redirect()->route('chambers.index')->with('success', 'Chamber updated successfully.');
    }

    public function destroy(Chamber $chamber)
    {
        if ($chamber->current_occupancy > 0) {
            return back()->with('error', 'Cannot delete a chamber that currently holds bodies.');
        }

        AuditLog::record('delete', 'chambers', $chamber->id, $chamber->toArray(), null);
        $chamber->delete();

        return redirect()->route('chambers.index')->with('success', 'Chamber deleted.');
    }
}
