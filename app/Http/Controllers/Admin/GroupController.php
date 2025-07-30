<?php

namespace App\Http\Controllers\Admin;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.groups.index');
    }

    // Fetch Group Data
    public function getGroupData(Request $request)
    {
        if ($request->ajax()) {
            $query = Group::orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('description', function ($row) {
                    return $row->description ?? 'Not available';
                })
                ->editColumn('action', function ($row) {
                    $editUrl = route('groups.edit', $row->id);
                    $deleteRoute = route('groups.destroy', $row->id);

                    return '
                    <ul class="action">
                        <li class="edit"> <a href="' . $editUrl . '"><i class="icon-pencil-alt"></i></a></li>
                        <li class="delete"><a href="#" class="delete-record" data-route="' . $deleteRoute . '"><i class="icon-trash"></i></a></li>
                    </ul>';
                })
                ->rawColumns(['action', 'description'])
                ->make(true);
        }

        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Group::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('groups.index')->with('success', 'Group created successfully.');
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
        $group = Group::findOrFail($id);

        return view('admin.groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $group = Group::findOrFail($id);
        $group->title = $request->title;
        $group->description = $request->description;
        $group->save();

        return redirect()->route('groups.index')->with('success', 'Group updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Group::findOrFail($id);
        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Group deleted successfully!');
    }
}
