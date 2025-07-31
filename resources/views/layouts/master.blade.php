<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="{{ asset('assets/images/company-logo-icon.png') }}" type="image/x-icon">
    <title>@yield('title', env('APP_URL'))</title>

    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link
        href="{{ asset('assets/fonts/css2.css?family=Montserrat:wght@200;300;400;500;600;700;800&amp;display=swap') }}"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css') }}">

    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">

    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
    @yield('style')
    <style>
        table.dataTable.no-footer {
            border-bottom: 1px solid #dee2e6 !important;
        }

        table.dataTable.no-footer {
            border-top: 1px solid #dee2e6 !important;
        }

        .sorting_1 {
            background-color: transparent !important;
        }

        div.dataTables_wrapper div.dataTables_processing {
            display: none !important;
        }
    </style>
</head>

<body>
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader">
            <div class="loader4"></div>
        </div>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        @include('admin._inc.header')
        <!-- Page Header Ends -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            @include('admin._inc.sidebar')
            <!-- Page Sidebar Ends-->
            <div style="margin-bottom: 30px">
                @yield('content')
            </div>
        </div>
    </div>
    @if (session('success') || session('error'))
        <div id="flash-toast" data-message="{{ session('success') ?? session('error') }}"
            data-type="{{ session('success') ? 'success' : 'error' }}">
        </div>
    @endif
    <!-- latest jquery-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- scrollbar js-->
    <script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar-pin.js') }}"></script>
    <script src="{{ asset('assets/js/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick/slick.js') }}"></script>
    <script src="{{ asset('assets/js/header-slick.js') }}"></script>


    <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/chart/apex-chart/moment.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script> --}}
    <!-- Plugins JS start-->


    {{-- <script src="{{ asset('assets/js/chart/echart/data/symbols.js') }}"></script> --}}
    <!-- calendar js-->
    <script src="{{ asset('assets/js/dashboard/default.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/typeahead/handlebars.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/typeahead/typeahead.bundle.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/typeahead/typeahead.custom.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/typeahead-search/handlebars.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/typeahead-search/typeahead-custom.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/height-equal.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/animation/wow/wow.min.js') }}"></script> --}}

    <!-- Theme js-->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme-customizer/customizer.js') }}"></script>

    @yield('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Find all sidebar links with 'active' class inside submenu
            const activeLinks = document.querySelectorAll('.sidebar-submenu a.active');

            activeLinks.forEach(link => {
                // Get the parent ul.sidebar-submenu
                const submenu = link.closest('.sidebar-submenu');
                if (submenu) {
                    // Show the submenu
                    submenu.style.display = 'block';

                    // Optionally, add an 'open' class to the parent <li> for styling
                    const parentLi = submenu.closest('li.sidebar-list');
                    if (parentLi) {
                        parentLi.classList.add('open');
                    }
                }
            });
        });
    </script>
    <script>
        (function() {
            const flash = document.getElementById('flash-toast');
            if (flash) {
                // Create toast container if it doesn't exist
                let toastContainer = document.querySelector(".toast-container");
                if (!toastContainer) {
                    toastContainer = document.createElement("div");
                    toastContainer.className = "toast-container position-fixed top-0 end-0 p-3 toast-index toast-rtl";
                    document.body.appendChild(toastContainer);
                }

                // Get message and type
                const message = flash.dataset.message;
                const type = flash.dataset.type;

                // Bootstrap alert classes based on type
                const bgClass = type === 'success' ? 'bg-success text-white' : 'bg-danger text-white';

                // Create toast HTML
                const toastHTML = `
                <div class="toast align-items-center text-white ${bgClass} border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;

                // Append and show toast
                toastContainer.insertAdjacentHTML("beforeend", toastHTML);
                const lastToast = toastContainer.querySelector(".toast:last-child");
                const toast = new bootstrap.Toast(lastToast);
                toast.show();
            }
        })();
    </script>
</body>

</html>
