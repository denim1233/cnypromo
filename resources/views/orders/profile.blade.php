<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CitiHardware | Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="icon" href="{{asset('img/logo.png')}}">
    <!------ Include the above in your HEAD tag ---------->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">

</head>

<body>
    <div class="wrapper bg-white mt-sm-5">
      

        <h4 class="pb-4 border-bottom">Account settings</h4>

        <div class="d-flex align-items-start py-3 border-bottom"> <img
                src="https://images.pexels.com/photos/1037995/pexels-photo-1037995.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"
                class="img" alt="">
            <div class="pl-sm-4 pl-2" id="img-section"> <b>{{ Auth::user()->emp_name }}</b>
                <p>ID. Number : <b style="color: #cf120e;">{{ Auth::user()->emp_id }}</b></p>
                {{-- <button class="btn button border"><b>Upload</b></button> --}}
            </div>
        </div>
        <div class="py-2">
            <form action="{{ route('auth.checknew') }}" method="post">
                @csrf
                @if (Session::get('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
                @else
                <div class="results">
                    @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                    @endif
                </div>
                @endif
                <input type="hidden" name="idnum" value="{{ Auth::user()->emp_id }}">
                {{-- <div class="row py-2">
                    <div class="col-md-12">
                        <label for="fullname">Full Name</label>
                        <input name="fullname" type="text" class="bg-light form-control"
                            placeholder="{{ Auth::user()->emp_name }}" value="{{ Auth::user()->emp_name }}" disabled>
        </div>
    </div> --}}
    <div class="row py-2">
        <div class="col-md-12">
            <label for="oldPass">Old Password</label>
            <input name="oldPass" type="password" class="bg-light form-control">
            @if ($errors->any('oldPass'))
            <span class="text-danger">
                <strong>{{ $errors->first('oldPass') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="row py-2">
        <div class="col-md-12">
            <label for="newPass">New Password</label>
            <input name="newPass" type="password" class="bg-light form-control">
            @if ($errors->any('newPass'))
            <span class="text-danger">
                <strong>{{ $errors->first('newPass') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="row py-2">
        <div class="col-md-12">
            <label for="confirmPass">Confirm New Password</label>
            <input name="confirmPass" type="password" class="bg-light form-control">
            @if ($errors->any('confirmPass'))
            <span class="text-danger">
                <strong>{{ $errors->first('confirmPass') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="py-3 pb-4 border-bottom">
        <button class="btn btn-primary mr-3" type="submit" id="saveBtn">Save Changes</button>
        <button class="btn border button" id="btnCancel">
            <a href="{{ route('initialItems')}}" id="cancelBtn">Cancel</a>
        </button>

      

         
    </div>
          <a href = 'http://192.168.8.107:8083/cnypromo_dev/public/order/items'>< Back to Main Menu</a>
    <div class="d-sm-flex align-items-center pt-3" id="deactivate" style = 'display: none !important;'>
        <div>
            <b>Deactivate your account</b>
            <p>Details about your company account and password</p>
        </div>
        <div class="ml-auto">
            <button class="btn danger" id="btnDeactivate" type="button">Deactivate</button>
        </div>
    </div>
    </form>
    </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>

    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('js/profile.js') }}"></script>

</body>

</html>