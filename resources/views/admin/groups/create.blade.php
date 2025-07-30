@extends('layouts.master');


@section('title')
    Create Group
@endsection


@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Groups</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Groups</li>
                            <li class="breadcrumb-item active">Create Group</li>
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
                        {{-- <div class="card-header">
                            <h4>Basic form</h4>
                            <p class="f-m-light mt-1">
                                Use the <code>.form-label </code>and <code>.form-control </code>through create basic form.
                            </p>
                        </div> --}}
                        <div class="card-body">
                            <div class="card-wrapper border rounded-3">
                                <form class="row g-3" action="{{ route('groups.store') }}" method="POST">
                                    @csrf
                                    <div class="col-md-12">
                                        <label class="form-label" for="inputEmail4">Title</label>
                                        <input class="form-control @error('title') is-invalid @enderror" id="inputEmail4" type="text" name="title" placeholder="Enter group title" value="{{ old('title') }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="inputPassword4">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="exampleFormControlTextarea19" rows="3" name="description"  placeholder="Enter Description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary me-2" type="submit">Submit</button>
                                        <a href="{{ route('groups.index') }}" class="btn btn-light">Cancel</a>
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
