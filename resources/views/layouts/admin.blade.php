<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Admin Opemedios') }} - @yield('title')</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  @yield('styles')
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>
<body>
  <div class="container-scroller" id="admin-app">
    @include('components.menus.navbar-user')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      @include('components.menus.main-menu')
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        <!-- content-wrapper ends -->
        @include('components.footers.footer-main-admin')
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="{{ asset('js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('js/vendor.bundle.addons.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="{{ asset('js/off-canvas.js') }}"></script>
  <script src="{{ asset('js/misc.js') }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{ asset('js/dashboard.js') }}"></script>
  <!-- End custom js for this page-->
  @yield('scripts-js')
</body>

</html>
