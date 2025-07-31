@extends('layouts.master');


@section('title')
    Edit Room
@endsection


@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Room</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Rooms</li>
                            <li class="breadcrumb-item active">Edit Room</li>
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
                                <form class="row g-3" action="{{ route('rooms.update', $room->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="col-md-12">
                                        <label class="form-label" for="inputName">Name</label>
                                        <input class="form-control @error('name') is-invalid @enderror" id="inputName" type="text" name="name" placeholder="Enter name" value="{{ $room->name }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                     <div class="col-12">
                                        <label class="form-label" for="exampleFormControlTextarea-01">Comments</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea-01" name="description" rows="3" placeholder="Enter your queries...">{{ $room->description }}</textarea>
                                    </div>

                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary me-2" type="submit">Submit</button>
                                        <a href="{{ route('rooms.index') }}" class="btn btn-light">Cancel</a>
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
