<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | {{ config('app.name') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" href="{{ asset('assets/images/company-logo-icon.png') }}" type="image/x-icon">
  <link rel="shortcut icon" href="{{ asset('assets/images/company-logo-icon.png') }}" type="image/x-icon">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Icons & CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/vendors/icofont.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/vendors/themify.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
  @yield('style')
</head>

<body class="login-page">
  @yield('content')

  <!-- Scripts -->
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
  <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
  <script src="{{ asset('assets/js/config.js') }}"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>

  @yield('script')
</body>
</html>
