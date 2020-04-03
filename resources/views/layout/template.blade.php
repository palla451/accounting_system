
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Accounting System - @yield('title')</title>

    <link href="{{ asset('dataTable/css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <!-- Gijgo Datepicker -->
    <link href="{{ asset('gijgo/css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/simple-sidebar.css') }}" rel="stylesheet">

    <!-- Pre Loading for all pages...-->
    <link href="{{ asset('css/preloading.css') }}" rel="stylesheet">

</head>

<body>
    <!-- Loading pages.... -->
    <div class="se-pre-con"></div>
    <!-- end loading pages.... -->

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
    @include('layout.sidebar')
    <!-- /#sidebar-wrapper -->

        <div id="page-content-wrapper">

            <!-- Navbar -->
        @include('layout.navbar', ['user' => $user])
        <!-- /#navbar-toggle -->

            <!-- Content -->
            <div class="container-fluid">
                @yield('graphic')

                @yield('content')

            </div>
            <!-- /#content -->
            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">
                <p class="mt-5 mb-3 text-muted">&copy; 2020-2021 by Giovanni D'Apote</p>
            </div>
            <!-- Copyright -->
        </div>
        <!-- /#page-content-wrapper -->




    </div>

<!-- Bootstrap core JavaScript -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/preLoading.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.validate.js') }}"></script>
<script src="{{ asset('dataTable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('dataTable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('gijgo/js/gijgo.min.js') }}"></script>

<!-- Custom JS for dashboard -->
<script src="{{ asset('js/dashboard.js') }}"></script>



@yield('scripts')

</body>

</html>

