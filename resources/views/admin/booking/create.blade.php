@extends('layouts.master');

@section('title')
    Create booking
@endsection

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .form-control:disabled {
        background-color: unset;
        opacity: unset;
        pointer-events: none; /* Optional: keep it non-interactive */
    }

</style>
@endsection


@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Booking</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('teams.index') }}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Bookings</li>
                            <li class="breadcrumb-item active">Create Booking</li>
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
                  <div class="card-header">
                    <h4>Booking Information </h4>
                    <p class="f-m-light mt-1">Fill up the following information.</p>
                  </div>
                  <div class="card-body">
                    <div class="vertical-main-wizard">
                      <div class="row g-3">
                        <div class="col-xxl-3 col-xl-4 col-12">
                          <div class="nav flex-column header-vertical-wizard" id="wizard-tab" role="tablist" aria-orientation="vertical"><a class="nav-link active" id="wizard-contact-tab" data-bs-toggle="pill" href="#wizard-contact" role="tab" aria-controls="wizard-contact" aria-selected="true">
                              <div class="vertical-wizard">
                                <div class="stroke-icon-wizard"><i class="fa fa-user"></i></div>
                                <div class="vertical-wizard-content">
                                   <h6>Centre Home Community</h6>
                                    <p>Enter community info</p>
                                </div>
                              </div></a><a class="nav-link" id="wizard-cart-tab" data-bs-toggle="pill" href="#wizard-cart" role="tab" aria-controls="wizard-cart" aria-selected="false" tabindex="-1">
                              <div class="vertical-wizard">
                                <div class="stroke-icon-wizard"><i class="fa fa-chain-broken"></i></div>
                                <div class="vertical-wizard-content">
                                  <h6>School Information</h6>
                                  <p>Enter School Info</p>
                                </div>
                              </div></a><a class="nav-link" id="wizard-banking-tab" data-bs-toggle="pill" href="#wizard-banking" role="tab" aria-controls="wizard-banking" aria-selected="false" tabindex="-1">
                              <div class="vertical-wizard">
                                <div class="stroke-icon-wizard"><i class="fa fa-group"></i></div>
                                <div class="vertical-wizard-content">
                                  <h6>Family / Coordinated Service Plan</h6>
                                  <p>Enter FSP detail</p>
                                </div>
                              </div></a></div>
                        </div>
                        <div class="col-xxl-9 col-xl-8 col-12">
                          <div class="tab-content" id="wizard-tabContent">
                            <div class="tab-pane fade active show" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                      @include('admin.booking.add_booking.centre_home_community')
                            </div>

                            <div class="tab-pane fade" id="wizard-cart" role="tabpanel" aria-labelledby="wizard-cart-tab">
                                   @include('admin.booking.add_booking.school')

                            </div>

                            <div class="tab-pane fade custom-input" id="wizard-banking" role="tabpanel" aria-labelledby="wizard-banking-tab">
                                  @include('admin.booking.add_booking.fsp_csp')
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#days_off_week').select2({
                placeholder: "Select Day(s)",
                allowClear: true
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.rooms').select2({
                placeholder: "Select Room",
                allowClear: true
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.therapist').select2({
                placeholder: "Select therapist",
                allowClear: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.school').select2({
                placeholder: "Select school",
                allowClear: true
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.repeater').repeater({
                initEmpty: false,
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    if (confirm('Are you sure you want to delete this row?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                isFirstItemUndeletable: false
            });

            // Auto-fill role and phone when name is selected
            $(document).on('change', '.name-select', function () {
                const selected = $(this).find('option:selected');
                const role = selected.data('role') || '';
                const phone = selected.data('phone') || '';

                const row = $(this).closest('[data-repeater-item]');
                row.find('.role-input').val(role);
                row.find('.phone-input').val(phone);
            });
        });
    </script>


@endsection
