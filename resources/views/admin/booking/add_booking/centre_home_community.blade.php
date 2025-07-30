

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


  <form class="row g-3 needs-validation custom-input" action="{{ route('bookings.store') }}" method="POST">
      @csrf
      <input type="hidden" value="centre_home_community" name="centre_home_community">
      <div class="col-xxl-4 col-sm-6">
          <label class="form-label" for="validationCustom0-a">Client name<span class="txt-danger">*</span></label>
          <input class="form-control @error('client_name') is-invalid @enderror" id="validationCustom0-a"
              name="client_name" type="text" placeholder="Enter client name" value="{{ old('client_name') }}"
              required="">
          @error('client_name')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
      </div>

      <div class="col-xxl-4 col-sm-6">
          <label class="form-label" for="validationCustom-b">Language<span class="txt-danger">*</span></label>
          <select class="form-select @error('language') is-invalid @enderror" name="language" required="">
              <option>Select Language</option>
              <option value="english" {{ old('language') == 'english' ? 'selected' : '' }}>English</option>
              <option value="french" {{ old('language') == 'french' ? 'selected' : '' }}>French</option>
          </select>
          @error('language')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
      </div>

      <div class="col-xxl-4 col-sm-6">
          <label class="form-label" for="validationCustom-b">Priority</label>
          <select class="form-select @error('priority') is-invalid @enderror" name="priority">
              <option>Select Priority</option>
              <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
              <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
              <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
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
                      aria-label="Checkbox for following text input" {{ old('reminder_call') ? 'checked' : '' }}>
              </div>
              <input id="client-name" class="form-control" type="text" value="Reminder Call" disabled>
          </div>
      </div>


      <div class="col-xxl-4 col-sm-6">
          <label class="form-label" for="alayacare_type">Alayacare Activity Type<span
                  class="txt-danger">*</span></label>
          <select class="form-select @error('alayacare_type') is-invalid @enderror" name="alayacare_type"
              id="alayacare_type" required="">
              <option value="">Activity Type</option>
              @foreach (config('booking.alayacare') as $key => $label)
                  <option value="{{ $key }}" {{ old('alayacare_type') == $key ? 'selected' : '' }}>
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
          <input class="form-control @error('alayacare_service_code') is-invalid @enderror" id="validationCustom0-a"
              name="alayacare_service_code" type="text" placeholder="Enter service code"
              value="{{ old('alayacare_service_code') }}">
          @error('alayacare_service_code')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
      </div>


      <div class="col-xxl-4 col-sm-6">
          <label class="form-label" for="client-name">Set Up Room</label>
          <div class="input-group">
              <div class="input-group-text">
                  <input class="form-check-input mt-0" name="room_setup" type="checkbox" value="1"
                      {{ old('room_setup') ? 'checked' : '' }}>
              </div>
              <input id="client-name" class="form-control" type="text" value="SetUP Room" disabled>
          </div>
      </div>

      <div class="col-xxl-4 col-sm-6">
          <label class="form-label" for="validationCustom04">Units<span class="txt-danger">*</span></label>
          <select class="form-select @error('units_from') is-invalid @enderror" id="validationCustom04" required=""
              name="units_from" id="units_from">
              <option value="">Select Units</option>
              @foreach (config('booking.unit_from') as $key => $label)
                  <option value="{{ $key }}" {{ old('units_from') == $key ? 'selected' : '' }}>
                      {{ $label }}
                  </option>
              @endforeach
          </select>
          @error('units_from')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
      </div>

      <div class="col-xxl-4 col-sm-6">
          <label class="form-label" for="validationemail-b">Travel Time<span class="txt-danger">*</span></label>
          <input class="form-control @error('trvel_time') is-invalid @enderror" id="validationemail-b"
              name="trvel_time" type="text" required="" placeholder="Enter travel time"
              value="{{ old('trvel_time') }}">
          @error('trvel_time')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
      </div>


      <div class="col-xxl-4 col-sm-6">
          <label class="form-label" for="validationCustom-b">Area of Town</label>
          <select class="form-select @error('area_of_town') is-invalid @enderror" name="area_of_town">
              <option>Select Area</option>
              <option value="central" {{ old('area_of_town') == 'central' ? 'selected' : '' }}>Central</option>
              <option value="east" {{ old('area_of_town') == 'east' ? 'selected' : '' }}>East</option>
              <option value="west" {{ old('area_of_town') == 'west' ? 'selected' : '' }}>West</option>
          </select>
          @error('area_of_town')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
      </div>

      <div class="col-xxl-4 col-sm-6">
          <label class="form-label" for="validationemail-b">Location</label>
          <input class="form-control @error('location') is-invalid @enderror" id="validationemail-b" type="text"
              name="location" placeholder="Enter location" value="{{ old('location') }}">
          @error('location')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
      </div>

      <div class="col-xxl-4 col-sm-6">
          <label class="form-label" for="validationCustom04">Therapist<span class="txt-danger">*</span></label>
          <select class="form-select @error('therapist') is-invalid @enderror therapist" id="therapist1"
              name="therapist" required>
              <option selected disabled value="">Select Therapist</option>
              @foreach ($therapists as $therapist)
                  <option value="{{ $therapist->id }}" {{ old('therapist') == $therapist->id ? 'selected' : '' }}>
                      {{ $therapist->name }}
                  </option>
              @endforeach
          </select>
          @error('therapist')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
      </div>

      <div class="col-xxl-4 col-sm-6">
          <label class="form-label" for="validationCustom04">Report Time</label>
          <select class="form-select @error('report_time') is-invalid @enderror" id="validationCustom04"
              name="report_time" id="report_time">
              <option value="">Select Time</option>
              @foreach (config('booking.report_time') as $key => $label)
                  <option value="{{ $key }}" {{ old('units_from') == $key ? 'selected' : '' }}>
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
          <input class="form-control @error('reoccur_app_info') is-invalid @enderror" id="validationemail-b"
              type="text" name="reoccur_app_info" placeholder="Enter information"
              value="{{ old('reoccur_app_info') }}">
          @error('reoccur_app_info')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
      </div>

    <div class="card-wrapper border rounded-3 input-radius">
        <h6 class="sub-title fw-bold">Rooms</h6>
        <div class="row g-3">
            <div class="col-xxl-4 col-sm-6">
                <label class="form-label" for="room1">1st Room <span class="txt-danger">*</span></label>
                <select class="form-select @error('rooms.0') is-invalid @enderror rooms" name="rooms[]" required>
                    <option value="">Select Room</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ (old('rooms')[0] ?? '') == $room->id ? 'selected' : '' }}>
                            {{ ucwords(strtolower($room->name)) }}
                        </option>
                    @endforeach
                </select>
                @error('rooms.0')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-xxl-4 col-sm-6">
                <label class="form-label" for="room2">2nd Room <span class="txt-danger">*</span></label>
                <select class="form-select @error('rooms.1') is-invalid @enderror rooms" name="rooms[]" required>
                    <option value="">Select Room</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ (old('rooms')[1] ?? '') == $room->id ? 'selected' : '' }}>
                            {{ ucwords(strtolower($room->name)) }}
                        </option>
                    @endforeach
                </select>
                @error('rooms.1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-xxl-4 col-sm-6">
                <label class="form-label" for="room3">3rd Room</label>
                <select class="form-select rooms" name="rooms[]">
                    <option value="">Select Room</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ (old('rooms')[2] ?? '') == $room->id ? 'selected' : '' }}>
                            {{ ucwords(strtolower($room->name)) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>


      <div class="card-wrapper border rounded-3 input-radius">
          <h6 class="sub-title fw-bold">Informs</h6>
          <div class="row g-3">

              <div class="col-xxl-4 col-sm-6">
                  <div class="input-group">
                      <div class="input-group-text">
                          <input class="form-check-input mt-0" name="inform_to[]" type="checkbox"
                              value="parent_only"
                              {{ in_array('parent_only', old('inform_to', [])) ? 'checked' : '' }}>
                      </div>
                      <input class="form-control" type="text" value="Parent only" disabled>
                  </div>
              </div>

              <div class="col-xxl-4 col-sm-6">
                  <div class="input-group">
                      <div class="input-group-text">
                          <input class="form-check-input mt-0" name="inform_to[]" type="checkbox"
                              value="parent_and_child"
                              {{ in_array('parent_and_child', old('inform_to', [])) ? 'checked' : '' }}>
                      </div>
                      <input class="form-control" type="text" value="Parent and child" disabled>
                  </div>
              </div>

              <div class="col-xxl-4 col-sm-6">
                  <div class="input-group">
                      <div class="input-group-text">
                          <input class="form-check-input mt-0" name="inform_to[]" type="checkbox"
                              value="parent_inform_only"
                              {{ in_array('parent_inform_only', old('inform_to', [])) ? 'checked' : '' }}>
                      </div>
                      <input class="form-control" type="text" value="Parent-inform only" disabled>
                  </div>
              </div>

              <div class="col-xxl-4 col-sm-6">
                  <div class="input-group">
                      <div class="input-group-text">
                          <input class="form-check-input mt-0" name="inform_to[]" type="checkbox"
                              value="cas_inform_only"
                              {{ in_array('cas_inform_only', old('inform_to', [])) ? 'checked' : '' }}>
                      </div>
                      <input class="form-control" type="text" value="CAS-inform only" disabled>
                  </div>
              </div>

              <div class="col-xxl-4 col-sm-6">
                  <div class="input-group">
                      <div class="input-group-text">
                          <input class="form-check-input mt-0" name="inform_to[]" type="checkbox"
                              value="cas_to_attend"
                              {{ in_array('cas_to_attend', old('inform_to', [])) ? 'checked' : '' }}>
                      </div>
                      <input class="form-control" type="text" value="CAS-to attend" disabled>
                  </div>
              </div>

          </div>
      </div>

      <div class="col-12">
          <label class="form-label" for="exampleFormControlTextarea-01">Comments</label>
          <textarea class="form-control" id="exampleFormControlTextarea-01" name="comments" rows="3"
              placeholder="Enter your queries...">{{ old('comments') }}</textarea>
      </div>


      <div class="card-footer text-end">
          <button class="btn btn-primary me-2" type="submit">Submit</button>
          <a href="{{ route('bookings.index') }}" class="btn btn-light">Cancel</a>
      </div>
  </form>
