@extends('layouts.master')

@section('title')
    Reports
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/sweetalert2.css') }}">

    <style>
        td.description-column {
            white-space: normal !important;
            word-break: break-word;
            max-width: 300px;
        }
    </style>
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Booking List</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Data Tables</li>
                            <li class="breadcrumb-item active">Booking Reports</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <!-- Zero Configuration  Starts-->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="list-product-header">
                                <div>
                                    <div class="light-box">
                                        <a data-bs-toggle="collapse" href="#collapseProduct" role="button"
                                            aria-expanded="false" aria-controls="collapseProduct" id="filterToggle">
                                            <i class="filter-icon" data-feather="filter"></i>
                                            <i class="icon-close filter-close hide" data-feather="x"></i>
                                        </a>
                                    </div>
                                    <a class="btn btn-primary" id="downloadReport"><i class="fa fa-download"></i>
                                        Download</a>
                                </div>
                            </div>

                            <form id="filterForm">
                                <div class="collapse" id="collapseProduct">
                                    <div class="card card-body list-product-body">
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <select class="form-select" name="contact_type">
                                                    <option value="">Booking Status</option>
                                                    <option value="booked">Booked</option>
                                                    <option value="unbooked">UnBooked</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-select @error('therapist') is-invalid @enderror therapist" id="therapist1" name="therapist">
                                                    <option value="">Select Therapist</option>
                                                    @foreach ($therapists as $therapist)
                                                        <option value="{{ $therapist->id }}">{{ $therapist->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('therapist')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" type="text" name="client_name"
                                                    placeholder="Client Name" value="{{ old('client_name') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" type="text" name="location"
                                                    placeholder="Location" value="{{ old('location') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-select" name="archive">
                                                    <option value="">Choose Status</option>
                                                    <option value="active">Active</option>
                                                    <option value="archive">Archive</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-select" name="type">
                                                    <option value="">Choose Booking</option>
                                                    <option value="centre_home_community">Centre Home</option>
                                                    <option value="school">School</option>
                                                    <option value="fsp_csp">FSP</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-select" name="school_id">
                                                    <option value="">Choose School</option>
                                                    @foreach ($schools as $school)
                                                        <option value="{{ $school->id }}">{{ $school->school_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="text-end mt-3">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="schoolTable">
                                    <thead>
                                        <tr>
                                            <th>Group Name</th>
                                            <th>Client Name</th>
                                            <th>Added</th>
                                            <th>Last Change</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    {{-- Get Group Data --}}
    <script>
        // Define table globally
        let table;
        $(function() {
            // Initialize DataTable
            let table = $('#schoolTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('reports.data') }}",
                    data: function(d) {
                        d.status = $('select[name="contact_type"]').val();
                        d.therapist = $('select[name="therapist"]').val();
                        d.client_name = $('input[name="client_name"]').val();
                        d.location = $('input[name="location"]').val();
                        d.archive = $('select[name="archive"]').val();
                        d.type = $('select[name="type"]').val();
                        d.school_id = $('select[name="school_id"]').val();
                    }
                },
                columns: [

                    {
                        data: 'group_name',
                        name: 'group_name'
                    },
                    {
                        data: 'client_name',
                        name: 'client_name'
                    },
                    {
                        data: 'added',
                        name: 'created_at'
                    },
                    {
                        data: 'last_change',
                        name: 'updated_at'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }
                ]
            });

            // On filter form submit
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                table.draw();

                // Show close icon, hide filter icon
                $('.filter-icon').addClass('hide');
                $('.filter-close').removeClass('hide');
            });

            // On close icon click — reset filters
            $('.filter-close').on('click', function(e) {
                e.preventDefault();

                // Reset all form fields dynamically
                $('#filterForm')[0].reset(); // Reset all <input>, <select>, etc.

                // Hide close icon, show filter icon
                $('.filter-close').addClass('hide');
                $('.filter-icon').removeClass('hide');

                // Collapse the filter section
                $('#collapseProduct').collapse('hide');

                // Redraw DataTable with cleared filters
                table.draw();
            });


        });
        $('#downloadReport').on('click', function(e) {
            e.preventDefault();

            // Build query string from filters
            let params = $('#filterForm').serialize();
            window.location.href = "{{ route('reports.download') }}?" + params;
        });
    </script>
@endsection
