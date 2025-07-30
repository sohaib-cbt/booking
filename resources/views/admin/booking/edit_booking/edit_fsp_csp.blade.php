
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


 <form class="row g-3 needs-validation custom-input" action="{{ route('bookings.update.fsp.form') }}" method="POST">
     @csrf
     <div class="card-wrapper border rounded-3 input-radius">
         <h6 class="sub-title fw-bold">Child needs to attend</h6>
         <div class="row g-3">
             <input type="hidden" name="fsp_csp" value="fsp_csp">
             <input type="hidden" name="fsp_csp_id" value="{{ $booking->id }}">

             <div class="col-xxl-6 col-sm-6">
                 <div class="input-group">
                     <div class="input-group-text">
                         <input class="form-check-input mt-0" type="radio" name="child_attend" value="yes"
                             {{ old('child_attend', $booking->child_attend) == '1' ? 'checked' : '' }}>

                     </div>
                     <input class="form-control" type="text" value="YES">
                 </div>
             </div>

             <div class="col-xxl-6 col-sm-6">
                 <div class="input-group">
                     <div class="input-group-text">
                         <input class="form-check-input mt-0" type="radio" name="child_attend" value="no"
                             {{ old('child_attend', $booking->child_attend) == '0' ? 'checked' : '' }}>
                     </div>
                     <input class="form-control" type="text" value="No">
                 </div>
             </div>

             <div class="col-xxl-4 col-sm-6">
                 <label class="form-label" for="validationCustom0-a">Client name<span
                         class="txt-danger">*</span></label>
                 <input class="form-control @error('client_name') is-invalid @enderror" id="validationCustom0-a"
                     name="client_name" type="text" placeholder="Enter client name" required
                     value="{{ old('client_name', $booking->client_name ?? '') }}">

                 @error('client_name')
                     <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
             </div>

             <div class="col-xxl-4 col-sm-6">
                 <label class="form-label" for="alayacare_type">Alayacare Activity Type<span
                         class="txt-danger">*</span></label>
                 <select class="form-select @error('alayacare_type') is-invalid @enderror" name="alayacare_type"
                     id="alayacare_type">
                     <option value="">Activity Type</option>
                     @foreach (config('booking.alayacare') as $key => $label)
                         <option value="{{ $key }}"
                             {{ old('alayacare_type', $booking->alayacare_type ?? '') == $key ? 'selected' : '' }}>
                             {{ $label }}
                         </option>
                     @endforeach
                 </select>
                 @error('alayacare_type')
                     <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
             </div>

             <div class="col-xxl-4 col-sm-6">
                 <label class="form-label" for="validationCustom0-a">Alayacare Service Code</label>
                 <input class="form-control @error('alayacare_service_code') is-invalid @enderror"
                     id="validationCustom0-a" name="alayacare_service_code" type="text"
                     placeholder="Enter service code" value="{{ $booking->alayacare_service_code }}">
                 @error('alayacare_service_code')
                     <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
             </div>

             <div class="col-xxl-4 col-sm-6">
                 <label class="form-label" for="validationCustom-b">Priority</label>
                 <select class="form-select @error('priority') is-invalid @enderror" name="priority">
                     <option>Select Priority</option>
                     <option value="normal" {{ $booking->priority == 'normal' ? 'selected' : '' }}>Normal</option>
                     <option value="medium" {{ $booking->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                     <option value="high" {{ $booking->priority == 'high' ? 'selected' : '' }}>High</option>
                     <option value="urgent" {{ $booking->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                 </select>
                 @error('priority')
                     <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
             </div>


             <div class="col-xxl-4 col-sm-6">
                 <label class="form-label" for="client-name">Reminder Call</label>
                 <div class="input-group">
                     <div class="input-group-text">
                         <input class="form-check-input mt-0" name="reminder_call" type="checkbox" value="1"
                             {{ $booking->reminder_call ? 'checked' : '' }}>
                     </div>
                     <input id="client-name" class="form-control" type="text" value="Reminder Call" disabled>
                 </div>
             </div>


             <div class="col-xxl-4 col-sm-6">
                 <label class="form-label" for="validationCustom0-a">Schedule By</label>
                 <input class="form-control @error('schedule_by') is-invalid @enderror" name="schedule_by"
                     type="text" placeholder="Enter schedule by" value="{{ $booking->schedule_by }}">
                 @error('schedule_by')
                     <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
             </div>

             <div class="col-xxl-4 col-sm-6">
                 <label class="form-label" for="validationCustom04">Units<span class="txt-danger">*</span></label>
                 <select class="form-select @error('units_from') is-invalid @enderror" id="validationCustom04"
                     required="" name="units_from" id="units_from" required>
                     <option value="">Select Units</option>
                     @foreach (config('booking.unit_from') as $key => $label)
                         <option value="{{ $key }}"
                             {{ old('units_from', $booking->units_from ?? '') == $key ? 'selected' : '' }}>
                             {{ $label }}
                         </option>
                     @endforeach
                 </select>
                 @error('units_from')
                     <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
             </div>

             <div class="col-xxl-4 col-sm-6">
                 <label class="form-label" for="validationemail-b">Location<span class="txt-danger">*</span></label>
                 <input class="form-control @error('location') is-invalid @enderror" id="validationemail-b"
                     type="text" name="location" placeholder="Enter location" value="{{ $booking->location }}"
                     required>
                 @error('location')
                     <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
             </div>

             <div class="col-xxl-4 col-sm-6">
                 <label class="form-label" for="validationCustom-b">Area of Town</label>
                 <select class="form-select @error('area_of_town') is-invalid @enderror" name="area_of_town">
                     <option value="">Select Area</option>
                     <option value="central" {{ $booking->area_of_town == 'central' ? 'selected' : '' }}>Central
                     </option>
                     <option value="east" {{ $booking->area_of_town == 'east' ? 'selected' : '' }}>East</option>
                     <option value="west" {{ $booking->area_of_town == 'west' ? 'selected' : '' }}>West</option>
                 </select>
                 @error('area_of_town')
                     <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
             </div>


             <div class="card-wrapper border rounded-3 input-radius">
                 <h6 class="sub-title fw-bold">Rooms</h6>
                 <div class="row g-3"> <!-- Add 'row' and spacing class here -->
                     <div class="col-xxl-4 col-sm-6">
                         <label class="form-label" for="room1">1st Room <span class="txt-danger">*</span></label>
                         <select class="form-select @error('rooms') is-invalid @enderror rooms" name="rooms[]"
                             required>
                             <option>Select Room</option>
                             @foreach ($rooms as $room)
                                 <option value="{{ $room->id }}"
                                     {{ old('rooms.0', $selectedRooms[0] ?? '') == $room->id ? 'selected' : '' }}>
                                     {{ ucwords(strtolower($room->name)) }}
                                 </option>
                             @endforeach
                         </select>
                         @error('rooms')
                             <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
                     </div>

                     <div class="col-xxl-4 col-sm-6">
                         <label class="form-label" for="room2">2nd Room <span class="txt-danger">*</span></label>
                         <select class="form-select @error('rooms') is-invalid @enderror rooms" name="rooms[]"
                             required>
                             <option>Select Room</option>
                             @foreach ($rooms as $room)
                                 <option value="{{ $room->id }}"
                                     {{ old('rooms.1', $selectedRooms[1] ?? '') == $room->id ? 'selected' : '' }}>
                                     {{ ucwords(strtolower($room->name)) }}
                                 </option>
                             @endforeach
                         </select>
                         @error('rooms')
                             <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
                     </div>

                     <div class="col-xxl-4 col-sm-6">
                         <label class="form-label" for="room3">3rd Room</label>
                         <select class="form-select @error('rooms') is-invalid @enderror rooms" name="rooms[]"
                             required>
                             <option>Select Room</option>
                             @foreach ($rooms as $room)
                                 <option value="{{ $room->id }}"
                                     {{ old('rooms.2', $selectedRooms[2] ?? '') == $room->id ? 'selected' : '' }}>
                                     {{ ucwords(strtolower($room->name)) }}
                                 </option>
                             @endforeach
                         </select>
                         @error('rooms')
                             <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
                     </div>
                 </div>
             </div>


             <div class="repeater">
                 <label class="mt-3 fw-bold">Internal Team Members</label>
                 <div data-repeater-list="internal_team">
                     @php
                         $oldTeams = old('internal_team', $internalTeamsOld ?? [[]]);
                     @endphp

                     @foreach ($oldTeams as $index => $team)
                         <div data-repeater-item class="row align-items-end mb-3">
                             <div class="col-md-4">
                                 <label class="form-label">Name</label>
                                 <select
                                     class="form-select name-select @error("internal_team.$index.name") is-invalid @enderror"
                                     name="internal_team[{{ $index }}][name]">
                                     <option value="">Select Internal Team</option>
                                     @foreach ($internal_teams as $internal_team)
                                         <option value="{{ $internal_team->name }}"
                                             data-role="{{ $internal_team->role }}"
                                             data-phone="{{ $internal_team->phone_no }}"
                                             {{ old("internal_team.$index.name", $team['name'] ?? '') == $internal_team->name ? 'selected' : '' }}>
                                             {{ $internal_team->name }}
                                         </option>
                                     @endforeach
                                 </select>
                                 @error("internal_team.$index.name")
                                     <div class="invalid-feedback">{{ $message }}</div>
                                 @enderror
                             </div>

                             <div class="col-md-3">
                                 <label class="form-label">Role</label>
                                 <input
                                     class="form-control role-input @error("internal_team.$index.role") is-invalid @enderror"
                                     name="internal_team[{{ $index }}][role]" type="text"
                                     value="{{ old("internal_team.$index.role", $team['role'] ?? '') }}">
                                 @error("internal_team.$index.role")
                                     <div class="invalid-feedback">{{ $message }}</div>
                                 @enderror
                             </div>

                             <div class="col-md-3">
                                 <label class="form-label">Phone</label>
                                 <input
                                     class="form-control phone-input @error("internal_team.$index.phone") is-invalid @enderror"
                                     name="internal_team[{{ $index }}][phone]" type="text"
                                     value="{{ old("internal_team.$index.phone", $team['phone'] ?? '') }}">
                                 @error("internal_team.$index.phone")
                                     <div class="invalid-feedback">{{ $message }}</div>
                                 @enderror
                             </div>

                             <div class="col-md-2 d-flex align-items-end">
                                 <i class="fas fa-times-circle text-danger fa-2x" data-repeater-delete
                                     style="cursor:pointer;"></i>
                             </div>
                         </div>
                     @endforeach
                 </div>
                 <input data-repeater-create type="button" class="btn btn-primary mt-2" value="Add More" />
             </div>


             <div class="repeater">
                 <label class="mt-4 fw-bold">External Team Members</label>
                 <div data-repeater-list="external_team">
                     @php
                         $externalTeams = old('external_team', $externalTeamsOld ?? [[]]);
                     @endphp

                     @foreach ($externalTeams as $index => $member)
                         <div data-repeater-item class="row align-items-end mb-3">
                             <div class="col-xxl-5 col-sm-6">
                                 <label class="form-label">Name</label>
                                 <input class="form-control @error("external_team.$index.name") is-invalid @enderror"
                                     name="external_team[{{ $index }}][name]" type="text"
                                     value="{{ old("external_team.$index.name", $member['name'] ?? '') }}">
                                 @error("external_team.$index.name")
                                     <div class="invalid-feedback">{{ $message }}</div>
                                 @enderror
                             </div>

                             <div class="col-xxl-5 col-sm-6">
                                 <label class="form-label">Phone</label>
                                 <input class="form-control @error("external_team.$index.phone") is-invalid @enderror"
                                     name="external_team[{{ $index }}][phone]" type="text"
                                     value="{{ old("external_team.$index.phone", $member['phone'] ?? '') }}">
                                 @error("external_team.$index.phone")
                                     <div class="invalid-feedback">{{ $message }}</div>
                                 @enderror
                             </div>

                             <div class="col-xxl-2 col-sm-6 d-flex align-items-end">
                                 <i class="fas fa-times-circle text-danger fa-2x" data-repeater-delete
                                     style="cursor:pointer;"></i>
                             </div>
                         </div>
                     @endforeach
                 </div>
                 <input data-repeater-create type="button" class="btn btn-primary mt-2" value="Add More" />
             </div>



             <div class="card-wrapper border rounded-3 input-radius">
                 <h6 class="sub-title fw-bold">Follow Up Meeting Required</h6>

                 <div class="row g-3">
                     <div class="col-xxl-4 col-sm-6">
                         <label class="form-label" for="length_of_meeting">Length of Meeting</label>
                         <select class="form-select @error('length_of_metting') is-invalid @enderror"
                             name="length_of_metting" id="length_of_meeting" required>
                             <option value="">Select length</option>
                             @foreach (config('booking.length_of_metting') as $key => $label)
                                 <option value="{{ $key }}"
                                     {{ old('length_of_metting', $booking->length_of_metting) == $key ? 'selected' : '' }}>
                                     {{ $label }}
                                 </option>
                             @endforeach
                         </select>
                         @error('length_of_metting')
                             <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
                     </div>
                 </div>

                 <div class="row g-3 mt-2">
                     @php
                         $options = [
                             'internal_team_only' => 'Internal Team Only',
                             'pre_school' => 'Pre School',
                             'parents/clients' => 'Parents / Clients',
                             'whole_team' => 'Whole Team',
                         ];
                         $selectedMeetings = old('follow_up_meeting', $selectedMeetings ?? []);
                     @endphp

                     @foreach ($options as $value => $label)
                         <div class="col-xxl-4 col-sm-6">
                             <div class="input-group">
                                 <div class="input-group-text">
                                     <input class="form-check-input mt-0" name="follow_up_meeting[]" type="checkbox"
                                         value="{{ $value }}"
                                         {{ in_array($value, $selectedMeetings) ? 'checked' : '' }}>
                                 </div>
                                 <input class="form-control" type="text" value="{{ $label }}" disabled>
                             </div>
                         </div>
                     @endforeach
                 </div>

             </div>

             <div class="col-12">
                 <label class="form-label" for="exampleFormControlTextarea-01">Comments</label>
                 <textarea class="form-control" id="exampleFormControlTextarea-01" name="comments" rows="3"
                     placeholder="Enter your queries...">{{ $booking->comments }}</textarea>
             </div>

             <div class="card-footer text-end">
                 <button class="btn btn-primary me-2" type="submit">Submit</button>
                 <a href="{{ route('bookings.index') }}" class="btn btn-light">Cancel</a>
             </div>

         </div>
     </div>

 </form>
