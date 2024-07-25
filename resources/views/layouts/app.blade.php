<!--
    =========================================================
    * Soft UI Dashboard - v1.0.3
    =========================================================

    * Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
    * Copyright 2021 Creative Tim (https://www.creative-tim.com)
    * Licensed under MIT (https://www.creative-tim.com/license)

    * Coded by Creative Tim

    =========================================================

    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->
    <!DOCTYPE html>

    @if (\Request::is('rtl'))
      <html dir="rtl" lang="ar">
    @else
      <html lang="en" >
    @endif

    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      @if (env('IS_DEMO'))
          <x-demo-metas></x-demo-metas>
      @endif

      <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">

      <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
      <title>
        Soft UI Dashboard by Creative Tim
      </title>

      <!-- SweetAlert CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">



      <!--     Fonts and icons     -->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />



      <!-- Nucleo Icons -->
      <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
      <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />

      <!-- Font Awesome Icons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


      <!-- CSS Files -->
      <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />



    </head>

    <body class="g-sidenav-show  bg-gray-100 {{ (\Request::is('rtl') ? 'rtl' : (Request::is('virtual-reality') ? 'virtual-reality' : '')) }} ">


        @auth
            @include('layouts.navbars.auth.sidebar')
            <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}">
                @include('layouts.navbars.auth.nav')
                <div class="container-fluid py-4">
                    @yield('auth-soft-ui')
                    @include('layouts.footers.auth.footer')
                </div>
            </main>
        @endauth



        @auth
            @yield('auth')
        @endauth
        @guest
            @yield('guest')
        @endguest



      @if(session()->has('success'))
        <div x-data="{ show: true}"
            x-init="setTimeout(() => show = false, 4000)"
            x-show="show"
            class="position-fixed bg-success rounded right-3 text-sm py-2 px-4">
          <p class="m-0">{{ session('success')}}</p>
        </div>
      @endif
        <!--   Core JS Files   -->
        <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/fullcalendar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
      @stack('rtl')
      @stack('dashboard')
      <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
          var options = {
            damping: '0.5'
          }
          Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
      </script>

      <!-- Github buttons -->
      <script async defer src="https://buttons.github.io/buttons.js"></script>
      <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
      <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>


      <!----------------------------------- Plugins ---------------------------------->
      <!------------- Flat Date Picker JS -------------->
      <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>

    <!------------- Flat Date Picker JS ENDS -------------->

    <!------------------- Sweet Alert JS ------------------>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--<script src="{{ asset('assets/js/plugins/sweetalert.min.js') }}"></script>-->

    <!------------ PDF File ------------>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" ></script>

    <!------------ Crest App code generator supporting code ------------>
    <script src="{{ asset('assets/js/crest-apps/code-generator-ui.js') }}"></script>






    </body>

</html>
