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
                                    <a class="btn btn-primary" href="{{ route('bookings.create') }}"><i class="fa fa-plus"></i>Add Booking</a>
                                        <button id="makeGroupBtn" class="btn btn-success d-none" data-bs-toggle="modal" data-bs-target="#makeGroupModal">
                                            <i class="fa fa-users"></i> Make a Group
                                        </button>

                                </div>

                            </div>
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
              @foreach($existingGroups as $group)
                <option value="{{ $group->id }}">{{ $group->title }}</option>
              @endforeach
            </select>

             <button class="btn btn-primary mt-2 w-100" name="action_type" value="add_to_existing" type="submit" data-bs-dismiss="modal">Submit</button>
          </div>

          {{-- New Grouping Section --}}
          <div class="pt-3 mt-3">
            <h6>Make a new Grouping</h6>
            <div class="mb-2 mt-4">
              <label for="group_name" class="form-label">Title:</label>
              <input type="text" class="form-control @error('group_name') is-invalid @enderror" name="group_name" id="group_name">
               @error('group_name')
                   <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
            <div class="mb-2">
              <label for="group_description" class="form-label">Description:</label>
              <textarea class="form-control" name="group_description" id="group_description" rows="3"></textarea>
            </div>
            <button class="btn btn-primary mt-2 w-100" name="action_type" value="create_new" type="submit" data-bs-dismiss="modal">Create</button>
          </div>

          {{-- Hidden selected booking IDs --}}
          <input type="hidden" name="booking_ids" id="bookingIds">
        </div>
      </form>
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
            table = $('#schoolTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('booking.getdata') }}",
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
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
       $(document).ready(function () {
            function toggleMakeGroupBtn() {
                let checkedCount = $('.rowCheckbox:checked').length;
                $('#makeGroupBtn').toggleClass('d-none', checkedCount === 0);
            }

            $(document).on('change', '.rowCheckbox', toggleMakeGroupBtn);
            $('#selectAll').on('change', function () {
                $('.rowCheckbox').prop('checked', $(this).prop('checked'));
                toggleMakeGroupBtn();
            });

            // When Make Group modal opens, collect selected IDs
            $('#makeGroupModal').on('show.bs.modal', function () {
                let selectedIds = $('.rowCheckbox:checked').map(function () {
                    return $(this).val();
                }).get();

                $('#bookingIds').val(selectedIds.join(','));
            });
        });
    </script>
@endsection
