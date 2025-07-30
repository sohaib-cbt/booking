<?php

namespace App\Http\Controllers\Admin;

use App\Models\Therapist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;


class TherapistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.therapist.index');
    }

    // Therapist Get Data

     public function getTherapistData(Request $request)
    {
        if ($request->ajax()) {
            $query = Therapist::orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('email', function ($row) {
                    return $row->email ?? 'N/A';
                })
                ->editColumn('phone_no', function ($row) {
                    return $row->phone_no ?? 'N/A';
                })
                ->editColumn('address', function ($row) {
                    return $row->address ?? 'N/A';
                })
                ->editColumn('action', function ($row) {
                    $editUrl = route('therapists.edit', $row->id);
                    $deleteRoute = route('therapists.destroy', $row->id);

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
        return view('admin.therapist.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email|max:255',
            'phone_no'  => 'nullable|string|max:20',
            'address'   => 'nullable|string|max:255',
        ]);

        Therapist::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'] ?? null,
            'phone_no'  => $validated['phone_no'] ?? null,
            'address'   => $validated['address'] ?? null,
        ]);

        return redirect()->route('therapists.index')->with('success', 'Therapist created successfully.');
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
        $therapist = Therapist::findOrFail($id);
        return view('admin.therapist.edit', compact('therapist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email|max:255',
            'phone_no'  => 'nullable|string|max:20',
            'address'   => 'nullable|string|max:255',
        ]);

        $therapist = Therapist::findOrFail($id);

        $therapist->update([
            'name'      => $validated['name'],
            'email'     => $validated['email'] ?? null,
            'phone_no'  => $validated['phone_no'] ?? null,
            'address'   => $validated['address'] ?? null,
        ]);

        return redirect()->route('therapists.index')->with('success', 'Therapist updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $therapist = Therapist::findOrFail($id);
        $therapist->delete();

        return redirect()->route('therapists.index')->with('success', 'Therapist deleted successfully!');
    }
}
