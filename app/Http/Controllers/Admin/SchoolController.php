<?php

namespace App\Http\Controllers\Admin;

use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.school.index');
    }

    // Fetch School

    public function getSchoolData(Request $request)
    {
        if ($request->ajax()) {
            $query = School::orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('phone_no', function ($row) {
                    return $row->phone_no ?? 'N/A';
                })
                ->editColumn('fax', function ($row) {
                    return $row->fax ?? 'N/A';
                })
                ->editColumn('address', function ($row) {
                    return $row->address ?? 'N/A';
                })
                ->editColumn('action', function ($row) {
                    $editUrl = route('schools.edit', $row->id);
                    $deleteRoute = route('schools.destroy', $row->id);

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
        return view('admin.school.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'phone_no' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        School::create([
            'school_name' => $validated['school_name'],
            'phone_no' => $validated['phone_no'] ?? null,
            'fax' => $validated['fax'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        return redirect()->route('schools.index')->with('success', 'School created successfully.');
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
        $school = School::findOrFail($id);
        return view('admin.school.edit', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'phone_no' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $school = School::findOrFail($id);
        $school->update([
            'school_name' => $validated['school_name'],
            'phone_no' => $validated['phone_no'] ?? null,
            'fax' => $validated['fax'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        return redirect()->route('schools.index')->with('success', 'School updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $school = School::findOrFail($id);
        $school->delete();

        return redirect()->route('groups.index')->with('success', 'School deleted successfully!');
    }
}
