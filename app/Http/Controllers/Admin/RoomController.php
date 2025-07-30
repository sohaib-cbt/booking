<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.room.index');
    }

    // Fetch School
    public function getRoomData(Request $request)
    {
        if ($request->ajax()) {
            $query = Room::orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $editUrl = route('rooms.edit', $row->id);
                    $deleteRoute = route('rooms.destroy', $row->id);

                    return '
                    <ul class="action">
                        <li class="edit"> <a href="' . $editUrl . '"><i class="icon-pencil-alt"></i></a></li>
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
        return view('admin.room.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:rooms,name',
            'description' => 'nullable|string',
        ]);

        Room::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
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
        $room = Room::findOrFail($id);
        return view('admin.room.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:rooms,name',
            'description' => 'nullable|string',
        ]);

        $room = Room::findOrFail($id);
        $room->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully!');
    }
}
