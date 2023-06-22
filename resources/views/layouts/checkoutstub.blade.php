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

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <a class="btn btn-danger" href="{{ route('itemOrderReports') }}" id="menuBtn"><i
                        class="fas fa-arrow-left"></i> Back to
                    main menu</a>
            </div>
            <div class="row">
                <div class="container" id="checkoutContainer">
                    @foreach ($stubinfo as $stub)
                    <div class="col-md-6">
                        <img class="img-fluid" src="{{ asset('img/checkout.jpg') }}" alt="Claim Stub"
                            id="checkoutStubImg">
                        </p>
                        {{-- COOP COPY --}}
                        <div class="coop">
                            <div class="orderno">{{ $stub->order_no }}</div>
                            <div class="empname">{{ $stub->emp_name }}</div>
                            <div class="orderid">{{ $stub->order_no }}</div>
                            <div class="itemname">{{ $stub->name }} </div>
                            <div class="itemdesc">{{ $stub->description }}</div>
                            <div class="quantity">{{ $stub->quantity }}</div>
                            <div class="picklocation">{{ $stub->pick_location }}</div>
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

  
        // 21rem
        window.addEventListener("load", window.print());


    var beforePrint = function() {
        console.log('Functionality to run before printing.');
    };

    var afterPrint = function() {
        
        $("#checkoutContainer .col-md-6 #checkoutStubImg").css({
            "margin-left":"21rem",
        });

    };

    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) {
                beforePrint();
            } else {
                afterPrint();
            }
        });
    }

    window.onbeforeprint = beforePrint;
    window.onafterprint = afterPrint;





    </script>
</body>

</html>