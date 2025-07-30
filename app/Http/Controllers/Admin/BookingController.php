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
        return view('admin.booking.index', compact('existingGroups'));
    }

    // Fetch Booking Record
    public function getBookingData(Request $request)
    {
        if ($request->ajax()) {
            $query = Booking::orderBy('id', 'desc')->where('status', 'active');

            return DataTables::of($query)
                ->addIndexColumn()

                // 1. Checkbox Column
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="rowCheckbox" value="' . $row->id . '">';
                })

                // 2. Group Name
                ->addColumn('group_name', function ($row) {
                    return 'Demo' ?? 'N/A';
                })

                // 4. Contacts with count
                ->addColumn('contacts', function ($row) {
                    $route = route('contacts.index', ['booking_id' => $row->id]);
                    $count = $row->contacts->count();
                    return '<a href="' . $route . '" class="contact-link" title="View ' . $count . ' contact(s)">Contact (' . $count . ')</a>';
                })


                // 5. Added Date
                ->addColumn('added', function ($row) {
                    return $row->created_at ? $row->created_at->format('Y-m-d h:i A') : 'N/A';
                })

                // 6. Last Change Date
                ->addColumn('last_change', function ($row) {
                    return $row->updated_at ? $row->updated_at->format('Y-m-d h:i A') : 'N/A';
                })


                // 7. Action Buttons
                ->addColumn('action', function ($row) {
                    $editUrl = route('bookings.edit', $row->id);
                    $deleteRoute = route('bookings.destroy', $row->id);
                    $statusRoute = route('bookings.change.status', $row->id);

                    return '
                        <ul class="action">
                            <li class="edit">
                                <a href="#" class="change-status" data-route="' . $statusRoute . '" title="Archive">
                                    <i class="fa fa-archive"></i>
                                </a>
                            </li>
                            <li class="edit">
                                <a href="' . $editUrl . '">
                                    <i class="icon-pencil-alt"></i>
                                </a>
                            </li>
                            <li class="delete">
                                <a href="#" class="delete-record" data-route="' . $deleteRoute . '">
                                    <i class="icon-trash"></i>
                                </a>
                            </li>
                        </ul>
                    ';
                })

                ->rawColumns(['checkbox', 'contacts', 'action']) // enable raw HTML
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


}
