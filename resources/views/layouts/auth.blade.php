<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CitiHardware | Login</title>
    <!-- Icon -->
    <link rel="icon" href="{{asset('img/logo.png')}}">
    <link rel="stylesheet" href="{{ asset('css/loginbootstrap.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/my-login.css') }}">
    @yield('styles')
</head>

<body class="my-login-page">
    @yield('content')


    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    @yield('scripts')
    <script src="{{ asset('js/my-login.js') }}"></script>
</body>

</html>