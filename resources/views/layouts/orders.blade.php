<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CitiHardware | Chinese New Year 2022</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" crossorigin="anonymous">
    <link rel="icon" href="{{asset('img/logo.png')}}">
    <!------ Include the above in your HEAD tag ---------->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">

    @yield('styles')
</head>

<body>
    <div class="super_container">
        <!-- Header -->
        <header class="header">
            <!-- Top Bar -->
            <div class="top_bar">
                <div class="container">
                    <div class="row">
                        <div class="col d-flex flex-row">
                            <div class="top_bar_contact_item">
                                <div class="top_bar_icon">
                                    <img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1560918577/phone.png"
                                        alt="">
                                </div>0943-688-1637
                            </div>
                            <div class="top_bar_contact_item">
                                <div class="top_bar_icon">
                                    <img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1560918597/mail.png"
                                        alt="">
                                </div><a href="mailto:marketing.web@citihardware.com">marketing.web@citihardware.com</a>
                            </div>
                            <div class="top_bar_content ml-auto">
                                <div class="top_bar_menu">
                                    @if (!Auth::guest())
                                    <ul class="standard_dropdown top_bar_dropdown">
                                        <li>
                                            <a href="{{ route('userProfile') }}" style="font-weight: 400;">
                                                {{ Auth::user()->emp_name }} <span style="color:#ed202e;">(CREDIT LIMIT
                                                    : {{ $credlimit }})</span>
                                            </a>
                                            <ul>
                                                <li><a href="{{ route('userProfile') }}">Account Settings</a></li>
                                                <li>
                                                    <a href="{{ route('viewCart') }}">Orders</a>
                                                </li>
                                                @if (Auth::user()->isAdmin == 1)
                                                <li>
                                                    <a href="{{ route('home') }}">Go to Admin</a>
                                                </li>
                                                @endif
                                                <li>
                                                    <a href="{{ route('auth.signout') }}"
                                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        <i class="nav-icon fas fa-sign-out-alt"></i>
                                                        {{ __('Logout') }}
                                                    </a>
                                                    <form id="logout-form" action="{{ route('auth.signout') }}"
                                                        method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                    @else
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Header Main -->
            @yield('header_main')
            <!-- Main Navigation -->
        </header>
    </div>



    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>



    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    @yield('scripts')
</body>


@yield('modals')
<!-- Footer -->
<footer class="page-footer font-small elegant-color">

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2022 Copyright:
        <a href="https://citihardware.com/" target="_blank"> CitiHardware</a>
    </div>
    <!-- Copyright -->

</footer>
<!-- Footer -->

</html>