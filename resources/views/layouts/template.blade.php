<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PresMa</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="{{asset('Edukate/img/favicon.ico')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('Edukate/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('Edukate/css/style.css')}}" rel="stylesheet">

    <!-- Data Table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- SweetAlert -->
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">


    <style>
        /* Ensure table container allows horizontal scrolling on small screens */
        .dataTables_wrapper {
            overflow-x: auto;
        }

        /* Wrap long text in table cells */
        #table-competitions td {
            word-wrap: break-word;
            word-break: break-all;
            max-width: 200px;
            /* Adjust as needed */
        }

        /* Optional: Ensure table fits within container */
        #table-competitions {
            width: 100%;
        }
    </style>
</head>

<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary rounded-0 btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

<body>

    <!-- Navbar Start -->
    @include('layouts.navbar')
    <!-- Navbar End -->

    <!-- breadcrumb Start -->
    @include('layouts.breadcrumb')
    <!-- breadcrumb End -->

    @if (url()->current() == url('/Admin/') || url()->current() == url('/Admin/Dashboard') || url()->current() == url('/Admin/User') || url()->current() == url('/Admin/Competition') || url()->current() == url('/Admin/Achievement'))
        <!-- Navbar Admin Start -->
        @include('layouts.adminNavbar')
        <!-- Navbar Admin End -->
    @endif

    <!-- Content Start -->
    @yield('content')
    <!-- Content End -->

    <!-- footer Start -->
    @include('layouts.footer')
    <!-- footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap JS (includes Popper.js for Bootstrap 4) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('Edukate/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('Edukate/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('Edukate/lib/counterup/counterup.min.js')}}"></script>
    <script src="{{asset('Edukate/lib/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{asset('Edukate/js/main.js')}}"></script>
    
    <!-- Validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    </script>
    @stack('js')
</body>

</html>