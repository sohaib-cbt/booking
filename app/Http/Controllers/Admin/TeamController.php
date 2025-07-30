<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.team.index');
    }

    // Get Team Data
    public function getTeamData(Request $request)
    {
        if ($request->ajax()) {
            $query = Team::orderBy('id', 'desc');

            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

            if ($request->filled('role')) {
                $query->where('role', 'like', '%' . $request->role . '%');
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('type', function ($row) {
                    return ucfirst($row->type);
                })
                ->editColumn('phone_no', function ($row) {
                    return $row->phone_no ?? 'N/A';
                })
                ->editColumn('email', function ($row) {
                    return $row->email ?? 'N/A';
                })
                ->editColumn('action', function ($row) {
                    $editUrl = route('teams.edit', $row->id);
                    $deleteRoute = route('teams.destroy', $row->id);

                    return '
                <ul class="action">
                    <li class="edit"><a href="' . $editUrl . '"><i class="icon-pencil-alt"></i></a></li>
                    <li class="delete"><a href="#" class="delete-record" data-route="' . $deleteRoute . '"><i class="icon-trash"></i></a></li>
                </ul>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return abort(404);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.team.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:internal,external',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teams,email',
            'phone_no' => 'nullable|string|max:20',
            'role' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        Team::create([
            'type'     => $validated['type'],
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone_no' => $validated['phone_no'] ?? null,
            'role'     => $validated['role'] ?? null,
            'address'  => $validated['address'] ?? null,
        ]);

        return redirect()->route('teams.index')->with('success', 'Team created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $team = Team::findOrFail($id);
        return view('admin.team.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'type'      => 'required|in:internal,external',
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:teams,email,' . $id,
            'phone_no'  => 'nullable|string|max:20',
            'role'      => 'nullable|string|max:255',
            'address'   => 'nullable|string|max:255',
        ]);

        $team = Team::findOrFail($id);
        $team->update([
            'type'      => $validated['type'],
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'phone_no'  => $validated['phone_no'] ?? null,
            'role'      => $validated['role'] ?? null,
            'address'   => $validated['address'] ?? null,
        ]);

        return redirect()->route('teams.index')->with('success', 'Team updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $team = Team::findOrFail($id);
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Team deleted successfully!');
    }
}
