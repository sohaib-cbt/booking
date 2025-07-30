<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $booking = null;

        if ($request->filled('booking_id')) {
            $booking = Booking::find($request->booking_id);
        }

        return view('admin.contacts.index', compact('booking'));
    }


    public function getContactData(Request $request)
    {
        if ($request->ajax()) {
            $query = Contact::where('booking_id', request('booking_id'))
                ->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('contact_type', function ($row) {
                    return $row->contact_type
                        ? ucwords(str_replace('_', ' ', $row->contact_type))
                        : 'N/A';
                })
                ->addColumn('contact_time', function ($row) {
                    return $row->contact_time ?: 'N/A';
                })
                ->addColumn('comments', function ($row) {
                    return $row->comments ?? 'No notes';
                })
                ->addColumn('action', function ($row) {
                    $deleteRoute = route('contacts.destroy', $row->id);

                    return '
                    <ul class="action">
                     <li class="edit">
                                <a href="javascript:void(0);"
                                class="editContactBtn"
                                data-id="' . $row->id . '"
                                data-contact_type="' . $row->contact_type . '"
                                data-contact_time="' . \Carbon\Carbon::parse($row->contact_time)->format('Y-m-d\TH:i') . '"
                                data-comments="' . $row->comments . '"
                                data-booking_id="' . $row->booking_id . '"
                                data-bs-toggle="modal"
                                data-bs-target="#editContactModal">
                                    <i class="icon-pencil-alt"></i>
                                </a>
                            </li>

                        <li class="delete">
                            <a href="#" class="delete-record" data-route="' . $deleteRoute . '"><i class="icon-trash"></i></a>
                        </li>
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'booking_id'   => 'required|exists:bookings,id',
            'contact_type' => 'required|in:booked,unbooked,telephone,voice_mail,expired,other',
            'contact_time' => 'nullable|date',
            'comments'     => 'nullable|string',
        ]);

        Contact::create([
            'booking_id'   => $request->booking_id,
            'contact_type' => $request->contact_type,
            'contact_time' => $request->contact_time,
            'comments'     => $request->comments,
        ]);

        return redirect()->back()->with('success', 'Contact saved successfully.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'contact_type' => 'required|string',
            'contact_time' => 'nullable|date',
            'comments' => 'nullable|string',
            'booking_id' => 'required|integer',
        ]);

        $contact = Contact::findOrFail($id);

        $contact->update([
            'contact_type' => $request->contact_type,
            'contact_time' => $request->contact_time,
            'comments' => $request->comments,
            'booking_id' => $request->booking_id,
        ]);

        return redirect()->back()->with('success', 'Contact updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $bookingId = $contact->booking_id;
        $contact->delete();

        return redirect()->route('contacts.index', ['booking_id' => $bookingId])
            ->with('success', 'Contact deleted successfully.');
    }
}
