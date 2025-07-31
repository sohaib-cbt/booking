@extends('layouts.master')

@section('title')
    Profile
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <form class="card" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-header">
                            <h4 class="card-title mb-0">Edit Profile</h4>
                        </div>

                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input class="form-control" type="text" name="name" placeholder="Name"
                                            value="{{ old('name', auth()->user()->name) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input class="form-control" type="email" name="email" placeholder="Email"
                                            value="{{ old('email', auth()->user()->email) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input class="form-control" type="password" name="password"
                                            placeholder="Password (leave blank to keep current)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <input class="form-control" type="password" name="password_confirmation"
                                            placeholder="Confirm Password">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Image</label>
                                        <input class="form-control" type="file" name="image">
                                    </div>
                                </div>

                                @if (auth()->user()->image)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label d-block">Current Image</label>
                                            <img src="{{ asset(auth()->user()->image) }}" alt="Profile Image" width="100"
                                                height="100">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Update Profile</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
