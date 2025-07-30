@extends('layouts.master')

@section('title')
    Contacts
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
                        <h4 class="mb-3">
                            Contact List - <span class="">{{ $booking->client_name }}</span>
                        </h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Data Tables</li>
                            <li class="breadcrumb-item active">Contacts</li>
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
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#exampleModallogin"><i class="fa fa-plus"></i> Add
                                        Contact</a></button>
                                </div>

                            </div>
                            <div class="table-responsive custom-scrollbar">
                                <table class="display" id="contactTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Contact Type</th>
                                            <th>Time of contact</th>
                                            <th>Notes</th>
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


    {{-- Modal --}}
    <div class="modal fade" id="exampleModallogin" tabindex="-1" role="dialog" aria-labelledby="exampleModallogin"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content dark-sign-up">
                <div class="modal-body social-profile text-start">
                    <div class="modal-toggle-wrapper">
                        <h3>Contact</h3>
                        <p> Fill in your information below to continue.</p>
                        <form class="row g-3" action="{{ route('contacts.store') }}" method="POST">
                            @csrf
                            @php
                                $now = \Carbon\Carbon::now('America/Toronto')->format('Y-m-d\TH:i');
                            @endphp
                            <input type="hidden" name="booking_id" id="bookingIdInput" value="{{ request('booking_id') }}">

                            <div class="col-md-12">
                                <label class="form-label" for="inputEmailEnter">Contact Type</label>
                                <select class="form-select @error('contact_type') is-invalid @enderror" name="contact_type"
                                    required="">
                                    <option>Select Contact</option>
                                    <option value="booked" {{ old('contact_type') == 'booked' ? 'selected' : '' }}>Booked
                                    </option>
                                    <option value="unbooked" {{ old('contact_type') == 'unbooked' ? 'selected' : '' }}>
                                        UnBooked</option>
                                    <option value="telephone" {{ old('contact_type') == 'telephone' ? 'selected' : '' }}>
                                        Telephone</option>
                                    <option value="voice_mail" {{ old('contact_type') == 'voice_mail' ? 'selected' : '' }}>
                                        Voice Mail</option>
                                    <option value="expired" {{ old('contact_type') == 'expired' ? 'selected' : '' }}>Expired
                                    </option>
                                    <option value="other" {{ old('contact_type') == 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                                @error('contact_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" for="contactTime">Time of Contact</label>
                                <input class="form-control" id="contactTime" type="datetime-local" name="contact_time"
                                    value="{{ $now }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="exampleFormControlTextarea-01">Comments</label>
                                <textarea class="form-control" id="exampleFormControlTextarea-01" name="comments" rows="3"
                                    placeholder="Enter your queries...">{{ old('comments') }}</textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit" data-bs-dismiss="modal">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Edit Modal --}}
    <div class="modal fade" id="editContactModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content dark-sign-up">
                <div class="modal-body social-profile text-start">
                    <h3>Edit Contact</h3>
                    <form method="POST" action="{{ route('contacts.update', 0) }}" id="editContactForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="editContactId">
                        <input type="hidden" name="booking_id" id="editBookingId">

                        <div class="mb-3">
                            <label>Contact Type</label>
                            <select class="form-select" name="contact_type" id="editContactType">
                                <option value="booked">Booked</option>
                                <option value="unbooked">UnBooked</option>
                                <option value="telephone">Telephone</option>
                                <option value="voice_mail">Voice Mail</option>
                                <option value="expired">Expired</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Time of Contact</label>
                            <input type="datetime-local" name="contact_time" class="form-control" id="editContactTime">
                        </div>

                        <div class="mb-3">
                            <label>Comments</label>
                            <textarea name="comments" class="form-control" rows="3" id="editComments"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
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
            let bookingId = $('#bookingIdInput').val();
            // Initialize DataTable
            table = $('#contactTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('contact.getdata') }}",
                    data: function(d) {
                        d.booking_id = bookingId; // 👈 Yahaan send ho raha hai
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'contact_type',
                        name: 'contact_type'
                    },
                    {
                        data: 'contact_time',
                        name: 'contact_time'
                    },
                    {
                        data: 'comments',
                        name: 'comments'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });

            // Delete Record Handler
            $(document).on('click', '.delete-record', function(e) {
                e.preventDefault();
                let route = $(this).data('route');

                swal({
                    title: "Are you sure?",
                    text: "This contact will be permanently deleted!",
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
                                swal("Deleted! The contact has been removed.", {
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
                        swal("The contact is safe!", "Deletion was cancelled.", "info");
                    }
                });
            });

        });
    </script>

    <script>
        $(document).on('click', '.editContactBtn', function() {
            let contactId = $(this).data('id');
            let type = $(this).data('contact_type');
            let time = $(this).data('contact_time');
            let comments = $(this).data('comments');
            let bookingId = $(this).data('booking_id');

            $('#editContactId').val(contactId);
            $('#editContactType').val(type);
            $('#editContactTime').val(time);
            $('#editComments').val(comments);
            $('#editBookingId').val(bookingId);

            let formAction = "{{ route('contacts.update', ':id') }}";
            $('#editContactForm').attr('action', formAction.replace(':id', contactId));

        });
    </script>
@endsection
