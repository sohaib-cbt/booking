@extends('layouts.master');


@section('title')
    Edit Team
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Team</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('teams.index') }}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Teams</li>
                            <li class="breadcrumb-item active">Edit Team</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-wrapper border rounded-3">
                               <form class="row g-3" action="{{ route('teams.update', $team->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="col-md-6">
                                        <label>Team Type</label>
                                        <select class="form-select" name="type">
                                            <option value="">Select Type</option>
                                            <option value="internal" {{ old('type', $team->type) == 'internal' ? 'selected' : '' }}>Internal</option>
                                            <option value="external" {{ old('type', $team->type) == 'external' ? 'selected' : '' }}>External</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="inputName">Name</label>
                                        <input class="form-control @error('name') is-invalid @enderror" id="inputName" type="text" name="name" placeholder="Enter name" value="{{ old('name', $team->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="inputEmail">Email</label>
                                        <input class="form-control @error('email') is-invalid @enderror" id="inputEmail" type="email" name="email" placeholder="Enter email" value="{{ old('email', $team->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="inputPhone">Phone Number</label>
                                        <input class="form-control @error('phone_no') is-invalid @enderror" id="inputPhone" type="text" name="phone_no" placeholder="Enter phone no" value="{{ old('phone_no', $team->phone_no) }}">
                                        @error('phone_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="inputRole">Role</label>
                                        <input class="form-control @error('role') is-invalid @enderror" id="inputRole" type="text" name="role" placeholder="Enter role" value="{{ old('role', $team->role) }}">
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="inputAddress">Address</label>
                                        <input class="form-control @error('address') is-invalid @enderror" id="inputAddress" type="text" name="address" placeholder="Enter address" value="{{ old('address', $team->address) }}">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary me-2" type="submit">Update</button>
                                        <a href="{{ route('teams.index') }}" class="btn btn-light">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
