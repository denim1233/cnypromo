<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CitiHardware | Summer Great Value Deals</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" crossorigin="anonymous">
    <link rel="icon" href="{{asset('img/logo.png')}}">
    <link rel="stylesheet" media="print" href="{{ asset('css/print.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/empreport.css') }}" />
    <title>AdminLTE 3 | Invoice Print</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <a class="btn btn-danger mr-2" href="{{ route('itemOrderReports') }}" id="menuBtn"><i
                        class="fas fa-arrow-left"></i> Back to
                    main menu</a>
            </div>
            <div class="row">

                <div class="container">

                    @foreach ($stubinfo as $stub)
                    <div class="row">
                        <div class="col-md-12">
                            <img class="img-fluid center" src="{{ asset('img/claimstub.jpg') }}" alt="Claim Stub"
                                id="claimStubImg">
                            </p>
                            {{-- COOP COPY --}}
                            <div class="coop">
                                <div class="orderno1">{{ $stub->order_no }}</div>
                                <div class="empname1">{{ $stub->emp_name }}</div>
                                <div class="orderid1">{{ $stub->order_no }}</div>
                                <div class="itemname1">{{ $stub->name }} </div>
                                <div class="itemdesc1">{{ $stub->description }}</div>
                                <div class="quantity1">{{ $stub->quantity }}</div>
                                <div class="picklocation1">{{ $stub->pick_location }}</div>
                            </div>
                            {{-- EMPLOYEE COPY --}}
                            <div class="claimstub">
                                <div class="orderno2">{{ $stub->order_no }}</div>
                                <div class="empname2">{{ $stub->emp_name }}</div>
                                <div class="orderid2">{{ $stub->order_no }}</div>
                                <div class="itemname2">{{ $stub->name }} </div>
                                <div class="itemdesc2">{{ $stub->description }}</div>
                                <div class="quantity2">{{ $stub->quantity }}</div>
                                <div class="picklocation2">{{ $stub->pick_location }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- info row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>