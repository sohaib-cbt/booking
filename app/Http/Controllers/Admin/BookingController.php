<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\Team;
use App\Models\School;
use App\Models\Group;
use App\Models\Booking;
use App\Models\Therapist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $existingGroups = Group::get();
        $therapists = Therapist::get();
        $schools = School::get();
        return view('admin.booking.index', compact('existingGroups','therapists','schools'));
    }

    // Fetch Booking Record
    public function getBookingData(Request $request)
    {
        if ($request->ajax()) {
            $query = Booking::with('groups', 'contacts')
                ->orderBy('id', 'desc');

            // Apply filters
            if ($request->filled('status')) {
                $query->whereHas('contacts', function ($q) use ($request) {
                    $q->where('contact_type', $request->status);
                });
            }

            if ($request->filled('therapist')) {
                $query->where('therapist_id', $request->therapist);
            }

            if ($request->filled('client_name')) {
                $query->where('client_name', 'like', '%' . $request->client_name . '%');
            }

            if ($request->filled('location')) {
                $query->where('location', 'like', '%' . $request->location . '%');
            }

            if ($request->filled('archive')) {
                $query->where('status', $request->archive);
            } else {
                $query->where('status', 'active');
            }

            if ($request->filled('type')) {
                $query->where('booking_form_type', $request->type);
            }

            if ($request->filled('school_id')) {
                $query->where('school_id', $request->school_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    $isGrouped = $row->groups->isNotEmpty();
                    $value = $isGrouped ? '' : $row->id;
                    $disabled = $isGrouped ? 'disabled readonly' : '';
                    return '<input type="checkbox" class="rowCheckbox" value="' . $value . '" ' . $disabled . '>';
                })
              ->addColumn('group_name', function ($row) {
                    $isGrouped = $row->groups->isNotEmpty();
                    $group = $isGrouped ? $row->groups->first() : null;

                    if ($isGrouped && $group) {
                        $route = route('group-booking.remove-booking', [
                            'group_id' => $group->id,
                            'booking_id' => $row->id,
                        ]);

                        $label = $group->title;
                        $description = $group->description ?? 'No description available';

                        $clients = $group->bookings->pluck('client_name')->unique()->filter()->values();

                        $clientListJson = htmlspecialchars(json_encode($clients));

                        $link = '<a href="javascript:void(0);"
                                    class="open-group-modal text-decoration-underline"
                                    data-route="' . $route . '"
                                    data-label="' . $label . '"
                                    data-description="' . $description . '"
                                    data-clients="' . $clientListJson . '">'
                                    . $label .
                                '</a>';

                        $svg = '<svg class="delete-booking" data-route="' . $route . '" height="15" viewBox="0 0 512 512" width="15" xmlns="http://www.w3.org/2000/svg" style="cursor:pointer; margin-left: 5px;"><circle cx="256" cy="256" fill="#ff2147" r="256"/><path d="M312.75 256l76.72-76.72a22.29 22.29 0 000-31.53l-25.22-25.22a22.29 22.29 0 00-31.53 0l-76.72 76.72-76.72-76.72a22.29 22.29 0 00-31.53 0l-25.22 25.22a22.29 22.29 0 000 31.53l76.72 76.72-76.72 76.72a22.29 22.29 0 000 31.53l25.22 25.22a22.29 22.29 0 0031.53 0l76.72-76.72 76.72 76.72a22.29 22.29 0 0031.53 0l25.22-25.22a22.29 22.29 0 000-31.53z" fill="#fff"/></svg>';

                        return $link . $svg;
                    }

                    return '<span class="text-muted">N/A</span>';
                })


                ->addColumn('contacts', function ($row) {
                    $route = route('contacts.index', ['booking_id' => $row->id]);
                    $count = $row->contacts->count();
                    return '<a href="' . $route . '" class="contact-link" title="View ' . $count . ' contact(s)">Contact (' . $count . ')</a>';
                })
                ->addColumn('added', fn($row) => $row->created_at ? $row->created_at->format('Y-m-d h:i A') : 'N/A')
                ->addColumn('last_change', fn($row) => $row->updated_at ? $row->updated_at->format('Y-m-d h:i A') : 'N/A')
                ->addColumn('status', fn($row) => $row->status == 'active' ? '<span class="badge badge-light-success">Active</span>' : '<span class="badge badge-light-danger">Archive</span>')
                ->addColumn('action', function ($row) {
                    $editUrl = route('bookings.edit', $row->id);
                    $deleteRoute = route('bookings.destroy', $row->id);
                    $statusRoute = route('bookings.change.status', $row->id);
                    return '
                        <ul class="action">
                            <li class="edit"><a href="#" class="change-status" data-route="' . $statusRoute . '" title="Archive"><i class="fa fa-archive"></i></a></li>
                            <li class="edit"><a href="' . $editUrl . '"><i class="icon-pencil-alt"></i></a></li>
                            <li class="delete"><a href="#" class="delete-record" data-route="' . $deleteRoute . '"><i class="icon-trash"></i></a></li>
                        </ul>';
                })
                ->rawColumns(['checkbox', 'group_name', 'contacts','status','action'])
                ->make(true);
        }

        return abort(404);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $therapists = Therapist::get();
        $schools = School::get();
        $rooms = Room::get();
        $internal_teams = Team::where('type', 'internal')->get();
        return view('admin.booking.create', compact('therapists', 'schools', 'rooms', 'internal_teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Filter out empty room values (e.g. 3rd room not selected)
        $filteredRooms = array_filter($request->input('rooms', []), function ($value) {
            return $value !== null && $value !== '';
        });

        // Merge filtered rooms back into the request
        $request->merge(['rooms' => $filteredRooms]);

        // Validation rules
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'language' => 'required|string',
            'priority' => 'nullable|string',
            'alayacare_type' => 'required|string',
            'alayacare_service_code' => 'nullable|string',
            'units_from' => 'required|string',
            'trvel_time' => 'required|string',
            'area_of_town' => 'nullable|string',
            'location' => 'nullable|string',
            'therapist' => 'required|exists:therapists,id',
            'report_time' => 'nullable|string',
            'reoccur_app_info' => 'nullable|string',
            'rooms' => 'nullable|array',
            'rooms.*' => 'exists:rooms,id',
            'inform_to' => 'nullable|array',
            'inform_to.*' => 'string',
            'comments' => 'nullable|string',
        ]);

        Booking::create([
            'booking_form_type' => 'centre_home_community',
            'client_name' => $validated['client_name'],
            'language' => $validated['language'],
            'priority' => $validated['priority'] ?? null,
            'reminder_call' => $request->has('reminder_call'),
            'alayacare_type' => $validated['alayacare_type'],
            'alayacare_service_code' => $validated['alayacare_service_code'] ?? null,
            'room_setup' => $request->has('room_setup'),
            'units_from' => $validated['units_from'],
            'trvel_time' => $validated['trvel_time'],
            'area_of_town' => $validated['area_of_town'] ?? null,
            'location' => $validated['location'] ?? null,
            'therapist_id' => $validated['therapist'],
            'report_time' => $validated['report_time'] ?? null,
            'reoccur_app_info' => $validated['reoccur_app_info'] ?? null,
            'rooms' => json_encode($validated['rooms'] ?? []),
            'inform_to' => json_encode($validated['inform_to'] ?? []),
            'comments' => $validated['comments'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Booking created successfully!');
    }



    public function storeSchoolForm(Request $request)
    {
        $validated = $request->validate([
            'entry_type' => 'required|in:school,pre_school',
            'client_name' => 'required|string|max:255',
            'language' => 'required|string',
            'priority' => 'nullable|string',
            'alayacare_type' => 'required|string',
            'alayacare_service_code' => 'required|string',
            'school_id' => 'nullable|exists:schools,id',
            'private_room_area' => 'nullable|string',
            'specific_time' => 'nullable|string',
            'area_of_town' => 'required|string',
            'units_from' => 'required|string',
            'units_to' => 'required|string',
            'trvel_time' => 'required|string',
            'therapist' => 'required|exists:therapists,id',
            'inform_to' => 'nullable|array',
            'inform_to.*' => 'string',
            'days_off_week' => 'nullable|array',
            'days_off_week.*' => 'string',
            'report_time' => 'nullable|string',
            'reoccur_app_info' => 'nullable|string',
            'other_app_scheduling_info' => 'nullable|array',
            'other_app_scheduling_info.*' => 'string',
            'comments' => 'nullable|string',
        ]);

        Booking::create([
            'booking_form_type' => 'school',
            'entry_type' => $validated['entry_type'],
            'client_name' => $validated['client_name'],
            'language' => $validated['language'],
            'priority' => $validated['priority'] ?? null,
            'reminder_call' => $request->has('reminder_call'),
            'alayacare_type' => $validated['alayacare_type'],
            'alayacare_service_code' => $validated['alayacare_service_code'],
            'school_id' => $validated['school_id'] ?? null,
            'room_setup' => $request->has('room_setup'),
            'private_room_area' => $validated['private_room_area'] ?? null,
            'specific_time' => $validated['specific_time'] ?? null,
            'area_of_town' => $validated['area_of_town'],
            'units_from' => $validated['units_from'],
            'units_to' => $validated['units_to'],
            'trvel_time' => $validated['trvel_time'],
            'therapist_id' => $validated['therapist'],
            'inform_to' => $validated['inform_to'] ?? [],
            'days_off_week' => $validated['days_off_week'] ?? [],
            'report_time' => $validated['report_time'] ?? null,
            'reoccur_app_info' => $validated['reoccur_app_info'] ?? null,
            'other_app_scheduling_info' => json_encode($validated['other_app_scheduling_info'] ?? []),
            'comments' => $validated['comments'] ?? null,
        ]);

        return redirect()->back()->with('success', 'School form submitted successfully.');
    }


    public function storeFspForm(Request $request)
    {
        // Remove this once done testing
        // dd($request->all());

        $validated = $request->validate([
            'child_attend' => 'nullable|in:yes,no',
            'client_name' => 'required|string|max:255',
            'alayacare_type' => 'required|string',
            'alayacare_service_code' => 'nullable|string',
            'schedule_by' => 'required|string|max:255',
            'units_from' => 'required|string',
            'location' => 'required|string',
            'area_of_town' => 'nullable|string',
            'priority' => 'nullable|string',

            // Rooms
            'rooms' => 'nullable|array',
            'rooms.*' => 'nullable|exists:rooms,id',

            // Internal Team
            'internal_team' => 'nullable|array',
            'internal_team.*.name' => 'nullable|exists:teams,name',
            'internal_team.*.role' => 'nullable|string|max:255',
            'internal_team.*.phone' => 'nullable|string|max:20',

            // External Team
            'external_team' => 'nullable|array',
            'external_team.*.name' => 'nullable|string|max:255',
            'external_team.*.phone' => 'nullable|string|max:20',

            // Meeting
            'length_of_metting' => 'required|string',
            'follow_up_meeting' => 'nullable|array',
            'follow_up_meeting.*' => 'string|in:internal_team_only,pre_school,parents/clients,whole_team',

            'comments' => 'nullable|string',
        ]);

        Booking::create([
            'booking_form_type' => 'fsp_csp',
            'child_attend' => $request->has('child_attend'),
            'client_name' => $validated['client_name'],
            'alayacare_service_code' => $validated['alayacare_service_code'],
            'alayacare_type' => $validated['alayacare_type'],
            'priority' => $validated['priority'] ?? null,
            'reminder_call' => $request->has('reminder_call'),
            'schedule_by' => $validated['schedule_by'],
            'units_from' => $validated['units_from'],
            'location' => $validated['location'],
            'area_of_town' => $validated['area_of_town'] ?? null,

            // JSON fields
            'rooms' => json_encode($validated['rooms'] ?? []),
            'internal_team' => json_encode($validated['internal_team'] ?? []),
            'external_team' => json_encode($validated['external_team'] ?? []),
            'length_of_metting' => $validated['length_of_metting'],
            'follow_up_meeting' => json_encode($validated['follow_up_meeting'] ?? []),
            'comments' => $validated['comments'] ?? null,
        ]);

        return redirect()->back()->with('success', 'FSP form submitted successfully.');
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
        $booking = Booking::findOrFail($id);

        return view('admin.booking.edit', [
            'booking' => $booking,
            'therapists' => Therapist::get(),
            'schools' => School::get(),
            'rooms' => Room::get(),
            'internal_teams' => Team::where('type', 'internal')->get(),
            'activeTab' => $booking->booking_form_type,
            'selectedRooms' => is_string($booking->rooms) ? json_decode($booking->rooms, true) : ($booking->rooms ?? []),
            'informTo' => is_string($booking->inform_to) ? json_decode($booking->inform_to, true) : ($booking->inform_to ?? []),
            'daysOffWeek' => is_string($booking->days_off_week) ? json_decode($booking->days_off_week, true) : ($booking->days_off_week ?? []),
            'other_app_scheduling_info' => is_string($booking->other_app_scheduling_info) ? json_decode($booking->other_app_scheduling_info, true) : ($booking->other_app_scheduling_info ?? []),
            'internalTeamsOld' => is_string($booking->internal_team) ? json_decode($booking->internal_team, true) : [],
            'externalTeamsOld' => is_string($booking->external_team) ? json_decode($booking->external_team, true) : [],
            'selectedMeetings' => is_string($booking->follow_up_meeting) ? json_decode($booking->follow_up_meeting, true) : [],

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCentreHome(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'language' => 'required|string',
            'priority' => 'nullable|string',
            'alayacare_type' => 'required|string',
            'alayacare_service_code' => 'nullable|string',
            'units_from' => 'required|string',
            'trvel_time' => 'required|string',
            'area_of_town' => 'nullable|string',
            'location' => 'nullable|string',
            'therapist' => 'required|exists:therapists,id',
            'report_time' => 'nullable|string',
            'reoccur_app_info' => 'nullable|string',
            'rooms' => 'nullable|array',
            'rooms.*' => 'nullable|exists:rooms,id',
            'inform_to' => 'nullable|array',
            'inform_to.*' => 'string',
            'comments' => 'nullable|string',
        ]);

        $booking = Booking::where('id', $request->centre_home_community_id)->firstOrFail();

        // Update booking
        $booking->update([
            'booking_form_type' => 'centre_home_community',
            'client_name' => $validated['client_name'],
            'language' => $validated['language'],
            'priority' => $validated['priority'] ?? null,
            'reminder_call' => $request->has('reminder_call'),
            'alayacare_type' => $validated['alayacare_type'],
            'alayacare_service_code' => $validated['alayacare_service_code'] ?? null,
            'room_setup' => $request->has('room_setup'),
            'units_from' => $validated['units_from'],
            'trvel_time' => $validated['trvel_time'],
            'area_of_town' => $validated['area_of_town'] ?? null,
            'location' => $validated['location'] ?? null,
            'therapist_id' => $validated['therapist'],
            'report_time' => $validated['report_time'] ?? null,
            'reoccur_app_info' => $validated['reoccur_app_info'] ?? null,
            'rooms' => json_encode($validated['rooms'] ?? []),
            'inform_to' => json_encode($validated['inform_to'] ?? []),
            'comments' => $validated['comments'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Booking updated successfully!');
    }

    public function updateSchoolForm(Request $request)
    {
        $validated = $request->validate([
            'entry_type' => 'required|in:school,pre_school',
            'client_name' => 'required|string|max:255',
            'language' => 'required|string',
            'priority' => 'nullable|string',
            'alayacare_type' => 'required|string',
            'alayacare_service_code' => 'required|string',
            'school_id' => 'nullable|exists:schools,id',
            'private_room_area' => 'nullable|string',
            'specific_time' => 'nullable|string',
            'area_of_town' => 'required|string',
            'units_from' => 'required|string',
            'units_to' => 'required|string',
            'trvel_time' => 'required|string',
            'therapist' => 'required|exists:therapists,id',
            'inform_to' => 'nullable|array',
            'inform_to.*' => 'string',
            'days_off_week' => 'nullable|array',
            'days_off_week.*' => 'string',
            'report_time' => 'nullable|string',
            'reoccur_app_info' => 'nullable|string',
            'other_app_scheduling_info' => 'nullable|array',
            'other_app_scheduling_info.*' => 'string',
            'comments' => 'nullable|string',
        ]);

        $booking = Booking::where('id', $request->school_form_id)->firstOrFail();


        $booking->update([
            'booking_form_type' => 'school',
            'entry_type' => $validated['entry_type'],
            'client_name' => $validated['client_name'],
            'language' => $validated['language'],
            'priority' => $validated['priority'] ?? null,
            'reminder_call' => $request->has('reminder_call'),
            'alayacare_type' => $validated['alayacare_type'],
            'alayacare_service_code' => $validated['alayacare_service_code'],
            'school_id' => $validated['school_id'] ?? null,
            'room_setup' => $request->has('room_setup'),
            'private_room_area' => $validated['private_room_area'] ?? null,
            'specific_time' => $validated['specific_time'] ?? null,
            'area_of_town' => $validated['area_of_town'],
            'units_from' => $validated['units_from'],
            'units_to' => $validated['units_to'],
            'trvel_time' => $validated['trvel_time'],
            'therapist_id' => $validated['therapist'],
            'inform_to' => json_encode($validated['inform_to'] ?? []),
            'days_off_week' => json_encode($validated['days_off_week'] ?? []),
            'report_time' => $validated['report_time'] ?? null,
            'reoccur_app_info' => $validated['reoccur_app_info'] ?? null,
            'other_app_scheduling_info' => json_encode($validated['other_app_scheduling_info'] ?? []),
            'comments' => $validated['comments'] ?? null,
        ]);

        return redirect()->back()->with('success', 'School form updated successfully.');
    }

    public function updateFspForm(Request $request)
    {
        $validated = $request->validate([
            'child_attend' => 'nullable|in:yes,no',
            'client_name' => 'required|string|max:255',
            'alayacare_type' => 'required|string',
            'alayacare_service_code' => 'nullable|string',
            'schedule_by' => 'required|string|max:255',
            'units_from' => 'required|string',
            'location' => 'required|string',
            'area_of_town' => 'nullable|string',
            'priority' => 'nullable|string',

            // Rooms
            'rooms' => 'nullable|array',
            'rooms.*' => 'nullable|exists:rooms,id',

            // Internal Team
            'internal_team' => 'nullable|array',
            'internal_team.*.name' => 'nullable|exists:teams,name',
            'internal_team.*.role' => 'nullable|string|max:255',
            'internal_team.*.phone' => 'nullable|string|max:20',

            // External Team
            'external_team' => 'nullable|array',
            'external_team.*.name' => 'nullable|string|max:255',
            'external_team.*.phone' => 'nullable|string|max:20',

            // Meeting
            'length_of_metting' => 'required|string',
            'follow_up_meeting' => 'nullable|array',
            'follow_up_meeting.*' => 'string|in:internal_team_only,pre_school,parents/clients,whole_team',

            'comments' => 'nullable|string',
        ]);

        $booking = Booking::where('id', $request->fsp_csp_id)->firstOrFail();


        $booking->update([
            'booking_form_type' => 'fsp_csp',
            'child_attend' => $request->has('child_attend'),
            'client_name' => $validated['client_name'],
            'alayacare_service_code' => $validated['alayacare_service_code'],
            'alayacare_type' => $validated['alayacare_type'],
            'priority' => $validated['priority'] ?? null,
            'reminder_call' => $request->has('reminder_call'),
            'schedule_by' => $validated['schedule_by'],
            'units_from' => $validated['units_from'],
            'location' => $validated['location'],
            'area_of_town' => $validated['area_of_town'] ?? null,

            // JSON fields
            'rooms' => json_encode($validated['rooms'] ?? []),
            'internal_team' => json_encode($validated['internal_team'] ?? []),
            'external_team' => json_encode($validated['external_team'] ?? []),
            'length_of_metting' => $validated['length_of_metting'],
            'follow_up_meeting' => json_encode($validated['follow_up_meeting'] ?? []),
            'comments' => $validated['comments'] ?? null,
        ]);

        return redirect()->back()->with('success', 'FSP form updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully!');
    }

    /**
     * change status.
     */

    public function changeStatus($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'archived';
        $booking->save();

        return response()->json(['message' => 'Booking Archive successfully']);
    }


    /**
     * Group Booking.
     */
    public function groupBookings(Request $request)
    {
        $request->validate([
            'booking_ids' => 'required|string',
            'action_type' => 'required',
        ]);

        $allBookingIds = array_unique(explode(',', $request->booking_ids));

        $alreadyGroupedIds = DB::table('booking_group_booking')->pluck('booking_id')->toArray();
        $bookingIds = array_diff($allBookingIds, $alreadyGroupedIds);


        if (empty($bookingIds)) {
            return redirect()->back()->with('error', 'Selected bookings are already grouped.');
        }

        if ($request->action_type === 'add_to_existing') {
            $request->validate([
                'existing_group_id' => 'required|exists:groups,id',
            ]);

            $group = Group::find($request->existing_group_id);

            $group->bookings()->attach($bookingIds);
        }

        if ($request->action_type === 'create_new') {
            $request->validate([
                'group_name' => 'required|string|max:255',
            ]);

            $group = Group::create([
                'title' => $request->group_name,
                'description' => $request->group_description,
            ]);

            $group->bookings()->attach($bookingIds);
        }

        return redirect()->back()->with('success', 'Bookings grouped successfully!');
    }

    // Remove Booking Group
    public function removeBooking($group_id, $booking_id)
    {
        DB::table('booking_group_booking')
            ->where('group_id', $group_id)
            ->where('booking_id', $booking_id)
            ->delete();

        return response()->json(['message' => 'Booking removed from group']);
    }

}
