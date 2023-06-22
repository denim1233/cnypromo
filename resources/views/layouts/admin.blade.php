<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CitiHardware | Chinese New Year 2022</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Icon -->
    <link rel="icon" href="{{asset('img/logo.png')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    @yield('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader">
            <img src="{{ asset('dist/img/citihardware.jpg') }}" alt="CitiHardware" height="120" width="120">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-link">
                <img src="{{ asset('dist/img/citihardware.jpg') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">CITIHARDWARE INC.</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('dist/img/citihardware.jpg') }}" class="img-circle elevation-2"
                alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->emp_name }}</a>
            </div>
    </div> --}}

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header">ADMIN</li>

            @if (Auth::user()->branch_name  === 'SSC')

            <li class="nav-item menu-open">
                <a href="{{ route('home') }}" class="{{ Request::is('/') ? 'nav-link active' : 'nav-link' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>

            @endif


            @if (Auth::user()->branch_name  === 'SSC')

              <li class="nav-item menu-open">
                <a href="{{ route('itemList') }}"
                    class="{{ Request::is('admin/items') ? 'nav-link active' : 'nav-link' }}">
                    <i class="nav-icon fas fa-shopping-bag"></i>
                    <p>
                        Items
                    </p>
                </a>
            </li>
            @endif


            <li class="nav-item menu-open">
                <a href="{{ route('employeeList') }}"
                    class="{{ Request::is('admin/employees') ? 'nav-link active' : 'nav-link' }}">
                    <i class="nav-icon fas fa-user-cog"></i>
                    <p>
                        Employees
                    </p>
                </a>
            </li>

                    <!-- hide the navigation -->
            @if (Auth::user()->branch_name  === 'jkfnsdkjnfkjsdnfkjsdfknds')

            <li class="nav-item menu-open">
                <a href="{{ route('validateLists') }}"
                    class="{{ Request::is('admin/validation') ? 'nav-link active' : 'nav-link' }}">
                    <i class="nav-icon fas fa-user-check"></i>
                    <p>
                        For Validation
                    </p>
                </a>
            </li>
            @endif



             @if (Auth::user()->branch_name  != 'SSC')
                    <li class="nav-header">CART</li>
                    <li class="nav-item menu-open">
                        <a href="{{ route('employeeCart') }}"
                            class="{{ Request::is('admin/employee-cart') ? 'nav-link active' : 'nav-link' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>
                                Employee's Cart
                            </p>
                        </a>
                    </li>
             @endif

            <li class="nav-header">ORDERS</li>
            <li class="nav-item menu-open">
                <a href="{{ route('orderAdmin') }}"
                    class="{{ Request::is('admin/orders') ? 'nav-link active' : 'nav-link' }}">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>
                        Orders
                    </p>
                </a>
            </li>
            <li class="nav-item menu-open">
                <a href="{{ route('orderstatus') }}"
                    class="{{ Request::is('admin/orderstats') ? 'nav-link active' : 'nav-link' }}">
                    <i class="nav-icon fas fa-question-circle"></i>
                    <p>
                        Order Status
                    </p>
                </a>
            </li>
            <li class="nav-header">REPORTS</li>
            <li class="nav-item menu-open">
                <a href="{{ route('itemOrderReports') }}"
                    class="{{ Request::is('reports/itemorder') ? 'nav-link active' : 'nav-link' }}">
                    <i class="nav-icon fas fa-file-invoice"></i>
                    <p>
                        Item Order Reports
                    </p>
                </a>
            </li>
            <li class="nav-item menu-open">
                <a href="{{ route('ItemQuantitySummary') }}"
                    class="{{ Request::is('reports/itemqtysummary') ? 'nav-link active' : 'nav-link' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>
                        Item Qty Summary
                    </p>
                </a>
            </li>

            <li class="nav-item menu-open">
                <a href="{{ route('cutOffReport') }}"
                    class="{{ Request::is('reports/cut-off') ? 'nav-link active' : 'nav-link' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>
                        Cut-off Orders Report
                    </p>
                </a>
            </li>


            {{-- <li class="nav-item menu-open">
                            <a href="{{ route('forReleasing') }}"
            class="{{ Request::is('admin/order/forreleasing') ? 'nav-link active' : 'nav-link' }}">
            <i class="nav-icon fas fa-truck-loading"></i>
            <p>
                For Releasing
            </p>
            </a>
            </li>
            <li class="nav-item menu-open">
                <a href="{{ route('forPurchase') }}"
                    class="{{ Request::is('admin/order/forpurchase') ? 'nav-link active' : 'nav-link' }}">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>
                        For Purchase Order
                    </p>
                </a>
            </li>
            <li class="nav-item menu-open">
                <a href="{{ route('listEmployees') }}"
                    class="{{ Request::is('admin/order/employees') ? 'nav-link active' : 'nav-link' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Employees with Order
                    </p>
                </a>
            </li> --}}
            <li class="nav-header">FRONTPAGE</li>
            <li class="nav-item menu-open">
                <a href="{{ route('initialItems') }}" class="nav-link">
                    <i class="nav-icon fas fa-share"></i>
                    <p>
                        Go to Item Listing
                    </p>
                </a>
            </li>
            <li class="nav-header">EXIT</li>
            <li class="nav-item menu-open">
                <a class="nav-link" href="{{ route('auth.signout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('auth.signout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2021 <a href="https://citihardware.com" target="_blank">CitiHardware</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Lloyd</b> Alcantara
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- Dynamic Scripts  -->
    @yield('scripts')
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
</body>

</html>