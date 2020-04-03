<!-- Stored in resources/views/layouts/master.blade.php -->

<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" crossorigin="anonymous">

        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
        <!-- Custom styles for this template -->
        <link href="{{ asset('css/signin.css')  }}" rel="stylesheet">

        <title>Accounting System - @yield('title')</title>
    </head>
    <body class="text-center">

        <div class="container">
            @yield('content')
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.js') }}" crossorigin="anonymous"></script>
    </body>
</html>
