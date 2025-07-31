@extends('layouts.master')

@section('title')
    Teams
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
                        <h4>Team List</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item active">Teams</li>
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
                                <div class="d-flex align-items-center gap-3">
                                    <!-- Filter Toggle Icons -->
                                    <div class="light-box">
                                        <a data-bs-toggle="collapse" href="#collapseProduct" role="button" aria-expanded="false" aria-controls="collapseProduct" id="filterToggle">
                                            <i class="filter-icon" data-feather="filter"></i>
                                            <i class="icon-close filter-close hide" data-feather="x"></i>
                                        </a>
                                    </div>

                                    <!-- Add Team Button -->
                                    <a class="btn btn-primary" href="{{ route('teams.create') }}">
                                        <i class="fa fa-plus"></i> Add Team
                                    </a>
                                </div>
                            </div>

                            <!-- Filter Form -->
                            <form id="filterForm">
                                <div class="collapse" id="collapseProduct">
                                    <div class="card card-body list-product-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <select class="form-select" name="type">
                                                    <option value="">Choose Team Type</option>
                                                    <option value="internal">Internal</option>
                                                    <option value="external">External</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control" type="text" name="role" placeholder="Enter role" value="{{ old('role') }}">
                                            </div>
                                        </div>
                                        <div class="text-end mt-3">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            {{-- <div class="list-product-header">
                                <div>
                                    <a class="btn btn-primary" href="{{ route('teams.create') }}"><i class="fa fa-plus"></i>Add Team</a>
                                </div>

                            </div> --}}
                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="teamTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Team Type</th>
                                            <th>Name</th>
                                            <th>EmaIl</th>
                                            <th>Phone No</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
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
    let table;

    $(function () {
        // Initialize DataTable
        table = $('#teamTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('team.getdata') }}",
                data: function (d) {
                    d.type = $('select[name=type]').val();
                    d.role = $('input[name=role]').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'type', name: 'type' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone_no', name: 'phone_no' },
                { data: 'role', name: 'role' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Handle Filter Submit
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            table.draw();

            // Show close icon, hide filter icon
            $('.filter-icon').addClass('hide');
            $('.filter-close').removeClass('hide');
        });

        // Handle Filter Close (reset)
        $('.filter-close').on('click', function (e) {
            e.preventDefault();

            // Reset form values
            $('select[name=type]').val('');
            $('input[name=role]').val('');

            // Reset icons
            $('.filter-close').addClass('hide');
            $('.filter-icon').removeClass('hide');

            // Collapse filter section
            $('#collapseProduct').collapse('hide');

            // Redraw table with default data
            table.draw();
        });

        // Delete Record Handler
        $(document).on('click', '.delete-record', function (e) {
            e.preventDefault();
            let route = $(this).data('route');

            swal({
                title: "Are you sure?",
                text: "This team will be permanently deleted!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: route,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            swal("Deleted! The team has been removed.", {
                                icon: "success",
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            swal("Oops!", "Something went wrong while deleting.", "error");
                        }
                    });
                } else {
                    swal("The team is safe!", "Deletion was cancelled.", "info");
                }
            });
        });
    });
</script>

@endsection
