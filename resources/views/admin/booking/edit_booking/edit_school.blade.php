
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


   <form class="row g-3 needs-validation custom-input" action="{{ route('bookings.update.school.form') }}" method="POST">
        @csrf
        <div class="card-wrapper border rounded-3 input-radius">
            <h6 class="sub-title fw-bold">Entry Type</h6>
            <div class="row g-3">
                <input type="hidden" name="school_form" value="schook_form">
                <input type="hidden" name="school_form_id" value="{{ $booking->id }}">
                <div class="col-xxl-6 col-sm-6">
                    <div class="input-group">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" name="entry_type" value="school"
                                {{ old('entry_type', $booking->entry_type ?? '') == 'school' ? 'checked' : '' }}>
                        </div>
                        <input class="form-control" type="text" value="School">
                    </div>
                </div>

                <div class="col-xxl-6 col-sm-6">
                    <div class="input-group">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" name="entry_type" value="pre_school"
                                {{ old('entry_type', $booking->entry_type ?? '') == 'pre_school' ? 'checked' : '' }}>
                        </div>
                        <input class="form-control" type="text" value="Pre School">
                    </div>
                </div>

                <div class="col-xxl-4 col-sm-6">
                    <label class="form-label" for="validationCustom0-a">Client name<span
                            class="txt-danger">*</span></label>
                    <input class="form-control @error('client_name') is-invalid @enderror" id="validationCustom0-a"
                        name="client_name" type="text" placeholder="Enter client name"
                        value="{{ $booking->client_name }}" required>
                    @error('client_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-xxl-4 col-sm-6">
                    <label class="form-label" for="validationCustom-b">Language<span class="txt-danger">*</span></label>
                    <select class="form-select @error('language') is-invalid @enderror" name="language" required>
                        <option>Select Language</option>
                        <option value="english" {{ $booking->language == 'english' ? 'selected' : '' }}>English</option>
                        <option value="french" {{ $booking->language == 'french' ? 'selected' : '' }}>French</option>
                    </select>
                    @error('language')
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
                    <label class="form-label" for="alayacare_type">Alayacare Activity Type<span
                            class="txt-danger">*</span></label>
                    <select class="form-select @error('alayacare_type') is-invalid @enderror" name="alayacare_type"
                        id="alayacare_type" required>
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
                    <label class="form-label" for="validationCustom0-a">Alayacare Service Code<span
                            class="txt-danger">*</span></label>
                    <input class="form-control @error('alayacare_service_code') is-invalid @enderror"
                        id="validationCustom0-a" name="alayacare_service_code" type="text"
                        placeholder="Enter service code" value="{{ $booking->alayacare_service_code }}" required>
                    @error('alayacare_service_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-xxl-4 col-sm-6">
                    <label class="form-label" for="school_id">School Name</label>
                    <select class="form-select @error('school_id') is-invalid @enderror school" name="school_id"
                        id="school_id">
                        <option value="">Select School</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}"
                                {{ old('school_id', $booking->school_id ?? '') == $school->id ? 'selected' : '' }}>
                                {{ $school->school_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('school_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-xxl-4 col-sm-6">
                    <label class="form-label" for="validationCustom0-a">Private Room/Area</label>
                    <input class="form-control @error('private_room_area') is-invalid @enderror"
                        name="private_room_area" type="text" placeholder="Ente private room/area"
                        value="{{ $booking->private_room_area }}">
                    @error('private_room_area')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-xxl-4 col-sm-6">
                    <label class="form-label" for="validationCustom0-a">Specific time of day/Activity</label>
                    <input class="form-control @error('specific_time') is-invalid @enderror" name="specific_time"
                        type="text" placeholder="Ente specific time of day"
                        value="{{ $booking->specific_time }}">
                    @error('specific_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-xxl-4 col-sm-6">
                    <label class="form-label" for="validationCustom-b">Area of Town<span
                            class="txt-danger">*</span></label>
                    <select class="form-select @error('area_of_town') is-invalid @enderror" name="area_of_town"
                        required>
                        <option>Select Area</option>
                        <option value="central" {{ $booking->area_of_town == 'central' ? 'selected' : '' }}>Central
                        </option>
                        <option value="east" {{ $booking->area_of_town == 'east' ? 'selected' : '' }}>East</option>
                        <option value="west" {{ $booking->area_of_town == 'west' ? 'selected' : '' }}>West</option>
                    </select>
                    @error('area_of_town')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-xxl-4 col-sm-6">
                    <label class="form-label" for="client-name">Set Up Room</label>
                    <div class="input-group">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" name="room_setup" type="checkbox" value="1"
                                {{ $booking->room_setup ? 'checked' : '' }}>
                        </div>
                        <input id="client-name" class="form-control" type="text" value="SetUP Room" disabled>
                    </div>
                </div>


                <div class="card-wrapper border rounded-3 input-radius">
                    <h6 class="sub-title fw-bold">Units</h6>
                    <div class="row g-3">
                        <div class="col-xxl-6 col-sm-6">
                            <label class="form-label" for="validationCustom04">Units<span
                                    class="txt-danger">*</span></label>
                            <select class="form-select @error('units_from') is-invalid @enderror"
                                id="validationCustom04" required="" name="units_from" id="units_from">
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

                        <div class="col-xxl-6 col-sm-6">
                            <label class="form-label" for="validationCustom04">Units to<span
                                    class="txt-danger">*</span></label>
                            <select class="form-select @error('units_to') is-invalid @enderror"
                                id="validationCustom04" required="" name="units_to" id="units_to">
                                <option value="">Select Units</option>
                                @foreach (config('booking.unit_to') as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ old('units_to', $booking->units_to ?? '') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('units_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-sm-6">
                    <label class="form-label" for="validationemail-b">Travel Time<span
                            class="txt-danger">*</span></label>
                    <input class="form-control @error('trvel_time') is-invalid @enderror" id="validationemail-b"
                        name="trvel_time" type="text" required="" placeholder="Enter travel time"
                        value="{{ $booking->trvel_time }}">
                    @error('trvel_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-xxl-4 col-sm-6">
                    <label class="form-label" for="validationCustom04">Therapist<span
                            class="txt-danger">*</span></label>
                    <select class="form-select @error('therapist') is-invalid @enderror therapist"
                        id="validationCustom04" name="therapist" required>
                        <option selected disabled value="">Select Therapist</option>
                        @foreach ($therapists as $therapist)
                            <option value="{{ $therapist->id }}"
                                {{ old('therapist', $booking->therapist_id ?? '') == $therapist->id ? 'selected' : '' }}>
                                {{ $therapist->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('therapist')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="card-wrapper border rounded-3 input-radius">
                    <h6 class="sub-title fw-bold">Informs</h6>
                    <div class="row g-3">

                        <div class="col-xxl-4 col-sm-6">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" name="inform_to[]" type="checkbox"
                                        value="parent_only" {{ in_array('parent_only', $informTo) ? 'checked' : '' }}>
                                </div>
                                <input class="form-control" type="text" value="Parent only" disabled>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-sm-6">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" name="inform_to[]" type="checkbox"
                                        value="parent_and_child"
                                        {{ in_array('parent_and_child', $informTo) ? 'checked' : '' }}>
                                </div>
                                <input class="form-control" type="text" value="Parent and child" disabled>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-sm-6">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" name="inform_to[]" type="checkbox"
                                        value="parent_inform_only"
                                        {{ in_array('parent_inform_only', $informTo) ? 'checked' : '' }}>
                                </div>
                                <input class="form-control" type="text" value="Parent-inform only" disabled>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-sm-6">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" name="inform_to[]" type="checkbox"
                                        value="cas_inform_only"
                                        {{ in_array('cas_inform_only', $informTo) ? 'checked' : '' }}>
                                </div>
                                <input class="form-control" type="text" value="CAS-inform only" disabled>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-sm-6">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" name="inform_to[]" type="checkbox"
                                        value="cas_to_attend"
                                        {{ in_array('cas_to_attend', $informTo) ? 'checked' : '' }}>
                                </div>
                                <input class="form-control" type="text" value="CAS-to attend" disabled>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-sm-6">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" name="inform_to[]" type="checkbox"
                                        value="educator_only"
                                        {{ in_array('educator_only', $informTo) ? 'checked' : '' }}>
                                </div>
                                <input class="form-control" type="text" value="Educator only" disabled>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="card-wrapper border rounded-3 input-radius">
                    <h6 class="sub-title fw-bold">Appointment Scheduling Information</h6>
                    <div class="row g-3">

                        <div class="col-xxl-6 col-sm-6">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" name="other_app_scheduling_info[]"
                                        type="checkbox" value="am"
                                        {{ in_array('am', old('other_app_scheduling_info', $other_app_scheduling_info)) ? 'checked' : '' }}>


                                </div>
                                <input id="client-name" class="form-control" type="text" value="AM" disabled>
                            </div>
                        </div>

                        <div class="col-xxl-6 col-sm-6">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" name="other_app_scheduling_info[]"
                                        type="checkbox" value="pm"
                                        {{ in_array('pm', old('other_app_scheduling_info', $other_app_scheduling_info)) ? 'checked' : '' }}>
                                </div>
                                <input id="client-name" class="form-control" type="text" value="PM" disabled>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="col-xxl-4 col-sm-6">
                    <label class="form-label" for="days_off_week">Day of the Week</label>
                    <select class="form-select select2 @error('days_off_week') is-invalid @enderror"
                        name="days_off_week[]" id="days_off_week" multiple>
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <option value="{{ $day }}"
                                {{ in_array($day, old('days_off_week', $daysOffWeek)) ? 'selected' : '' }}>
                                {{ $day }}
                            </option>
                        @endforeach
                    </select>
                    @error('days_off_week')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-xxl-4 col-sm-6">
                    <label class="form-label" for="validationCustom04">Report Time</label>
                    <select class="form-select @error('report_time') is-invalid @enderror" id="validationCustom04"
                        name="report_time" id="report_time">
                        <option value="">Select Time</option>
                        @foreach (config('booking.report_time') as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('units_from', $booking->report_time ?? '') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('report_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-xxl-4 col-sm-6">
                    <label class="form-label" for="validationemail-b">Reoccuring Appointment Information</label>
                    <input class="form-control @error('reoccur_app_info') is-invalid @enderror"
                        id="validationemail-b" type="text" name="reoccur_app_info"
                        placeholder="Enter information" value="{{ $booking->reoccur_app_info }}">
                    @error('reoccur_app_info')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
