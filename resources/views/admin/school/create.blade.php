@extends('layouts.master');


@section('title')
    Create School
@endsection


@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>School</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('schools.index') }}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Schools</li>
                            <li class="breadcrumb-item active">Create School</li>
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


                                <form class="row g-3" action="{{ route('schools.store') }}" method="POST">
                                    @csrf

                                    <div class="col-md-6">
                                        <label class="form-label" for="inputName">Name</label>
                                        <input class="form-control @error('school_name') is-invalid @enderror" id="inputName" type="text" name="school_name" placeholder="Enter name" value="{{ old('school_name') }}" required>
                                        @error('school_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="inputPhone">Phone Number</label>
                                        <input class="form-control @error('phone_no') is-invalid @enderror" id="inputPhone" type="text" name="phone_no" placeholder="Enter phone no" value="{{ old('phone_no') }}">
                                        @error('phone_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="inputFax">Fax</label>
                                        <input class="form-control @error('fax') is-invalid @enderror" id="inputFax" type="text" name="fax" placeholder="Enter fax" value="{{ old('fax') }}">
                                        @error('fax')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="inputAddress">Address</label>
                                        <input class="form-control @error('address') is-invalid @enderror" id="inputAddress" type="text" name="address" placeholder="Enter address" value="{{ old('address') }}">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary me-2" type="submit">Submit</button>
                                        <a href="{{ route('schools.index') }}" class="btn btn-light">Cancel</a>
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
