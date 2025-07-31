@extends('layouts.master')

@section('title')
    Bookings
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
                            <li class="breadcrumb-item active">Booking</li>
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
                                    <a class="btn btn-primary" href="{{ route('bookings.create') }}"><i
                                            class="fa fa-plus"></i>Add Booking</a>
                                    <button id="makeGroupBtn" class="btn btn-primary d-none" data-bs-toggle="modal"
                                        data-bs-target="#makeGroupModal">
                                        <i class="fa fa-users"></i> Make a Group
                                    </button>
                                </div>
                            </div>

                            <form id="filterForm">
                                <div class="collapse" id="collapseProduct">
                                    <div class="card card-body list-product-body">
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <select class="form-select" name="contact_type">
                                                    <option value="">Choose Status</option>
                                                    <option value="booked">Booked</option>
                                                    <option value="unbooked">UnBooked</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select
                                                    class="form-select @error('therapist') is-invalid @enderror therapist"
                                                    id="therapist1" name="therapist">
                                                    <option selected disabled value="">Select Therapist</option>
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
                                                    <option value="">Choose Archive</option>
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
                                            <th>
                                                <input type="checkbox" id="selectAll">
                                            </th>
                                            <th>Group Name</th>
                                            <th>Client Name</th>
                                            <th>Contacts</th>
                                            <th>Added</th>
                                            <th>Last Change</th>
                                            <th>Status</th>
                                            <th>Action</th>
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


    <!-- Group Modal -->
    <div class="modal fade" id="makeGroupModal" tabindex="-1" aria-labelledby="makeGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="makeGroupForm" method="POST" action="{{ route('group.bookings') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="makeGroupModalLabel">Manage Booking Group</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        {{-- Existing Grouping Section --}}
                        <div class="border p-2 mb-3">
                            <label for="existing_group_id" class="form-label">Existing Groupings:</label>
                            <select name="existing_group_id" id="existing_group_id" class="form-select">
                                <option value="">Select a group</option>
                                @foreach ($existingGroups as $group)
                                    <option value="{{ $group->id }}">{{ $group->title }}</option>
                                @endforeach
                            </select>

                            <button class="btn btn-primary mt-2 w-100" name="action_type" value="add_to_existing"
                                type="submit" data-bs-dismiss="modal">Submit</button>
                        </div>

                        {{-- New Grouping Section --}}
                        <div class="pt-3 mt-3">
                            <h6>Make a new Grouping</h6>
                            <div class="mb-2 mt-4">
                                <label for="group_name" class="form-label">Title:</label>
                                <input type="text" class="form-control @error('group_name') is-invalid @enderror"
                                    name="group_name" id="group_name">
                                @error('group_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for="group_description" class="form-label">Description:</label>
                                <textarea class="form-control" name="group_description" id="group_description" rows="3"></textarea>
                            </div>
                            <button class="btn btn-primary mt-2 w-100" name="action_type" value="create_new"
                                type="submit" data-bs-dismiss="modal">Create</button>
                        </div>

                        {{-- Hidden selected booking IDs --}}
                        <input type="hidden" name="booking_ids" id="bookingIds">
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Booking Group Modal --}}
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myExtraLargeModal">Selected Group</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body dark-modal">
                    <div class="large-modal-header mb-2">
                        <h6>Title</h6>
                    </div>
                    <p class="modal-padding-space mb-0" id="groupModalTitle"></p>
                    <div class="large-modal-header mb-2">
                        <h6>Description</h6>
                    </div>
                    <p class="modal-padding-space mb-0" id="groupModalDescription"></p>

                    <div class="large-modal-header mb-2" style="margin-top: 20px">
                        <h6>Clients</h6>
                    </div>
                    <ul id="clientList" class="ps-3"></ul>
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
                    url: "{{ route('booking.getdata') }}",
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
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'group_name',
                        name: 'group_name'
                    },
                    {
                        data: 'client_name',
                        name: 'client_name'
                    },
                    {
                        data: 'contacts',
                        name: 'contacts',
                        orderable: false,
                        searchable: false
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
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
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

                // ✅ Reset all form fields dynamically
                $('#filterForm')[0].reset(); // Reset all <input>, <select>, etc.

                // Hide close icon, show filter icon
                $('.filter-close').addClass('hide');
                $('.filter-icon').removeClass('hide');

                // Collapse the filter section
                $('#collapseProduct').collapse('hide');

                // Redraw DataTable with cleared filters
                table.draw();
            });



            // Delete Record Handler
            $(document).on('click', '.delete-record', function(e) {
                e.preventDefault();
                let route = $(this).data('route');

                swal({
                    title: "Are you sure?",
                    text: "This booking will be permanently deleted!",
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
                            success: function(response) {
                                swal("Deleted! The booking has been removed.", {
                                    icon: "success",
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                swal("Oops!", "Something went wrong while deleting.",
                                    "error");
                            }
                        });
                    } else {
                        swal("The booking is safe!", "Deletion was cancelled.", "info");
                    }
                });
            });


            $(document).on('click', '.change-status', function(e) {
                e.preventDefault();
                let route = $(this).data('route');

                swal({
                    title: "Are you sure?",
                    text: "This booking will be archived!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willChange) => {
                    if (willChange) {
                        $.ajax({
                            url: route,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                swal("Success!",
                                    "This booking will be archived successfully.", {
                                        icon: "success",
                                    }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                swal("Oops!", "Something went wrong while updating.",
                                    "error");
                            }
                        });
                    } else {
                        swal("Cancelled", "The booking archive was not changed.", "info");
                    }
                });
            });


        });
    </script>

    <script>
        $(document).ready(function() {
            // Show/hide Make Group button based on selected checkboxes
            function toggleMakeGroupBtn() {
                let checkedCount = $('.rowCheckbox:checked').length;
                $('#makeGroupBtn').toggleClass('d-none', checkedCount === 0);
            }

            // When individual checkboxes are changed
            $(document).on('change', '.rowCheckbox', toggleMakeGroupBtn);

            // Select all only those that are not disabled
            $('#selectAll').on('change', function() {
                $('.rowCheckbox:not(:disabled)').prop('checked', $(this).prop('checked'));
                toggleMakeGroupBtn();
            });

            // On modal open, collect only non-empty, non-disabled selected IDs
            $('#makeGroupModal').on('show.bs.modal', function() {
                let selectedIds = $('.rowCheckbox:checked').map(function() {
                    return $(this).val();
                }).get().filter(id => id); // remove empty strings

                $('#bookingIds').val(selectedIds.join(','));
            });
        });
    </script>


    <script>
        $(document).on('click', '.delete-booking', function(e) {
            e.preventDefault();
            let route = $(this).data('route');

            swal({
                title: "Are you sure?",
                text: "Remove this booking from the group!",
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
                        success: function(response) {
                            swal("Removed! Booking removed from group.", {
                                icon: "success",
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            swal("Oops!", "Something went wrong while deleting.", "error");
                        }
                    });
                } else {
                    swal("The booking is safe!", "Deletion was cancelled.", "info");
                }
            });
        });
    </script>

<script>
    $(document).on('click', '.open-group-modal', function () {
        let groupTitle = $(this).data('label');
        let description = $(this).data('description');
        let clients = $(this).data('clients');

        $('#groupModalTitle').text(groupTitle);
        $('#groupModalDescription').text(description);

        let html = '';
        if (clients && clients.length > 0) {
            clients.forEach(function (client) {
                    html += '<li><i class="fa fa-user me-1 text-secondary p-1"></i>' + client + '</li>';
            });
        } else {
            html = '<li>No clients found.</li>';
        }

        $('#clientList').html(html);

        $('.bd-example-modal-lg').modal('show');
    });
</script>


@endsection
