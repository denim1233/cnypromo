@extends('layouts.admin')

@section('content')
<div class="content-header">
    <!-- Content Header (Page header) -->
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Employee's Cart</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Item Order Reports</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>PICK-UP LOCATION</label>
                                    <select class="form-control" id="pickLocationSelectEmployeeCart">


                                         {{Auth::user()->branch_name}}
                                            @if(Auth::user()->branch_name === 'SSC' || Auth::user()->branch_name === 'DC')         
                                                      <option value="" selected disabled>Please select pick-up location</option>
                                                                 @foreach ($branch as $item)
                                                        <option>{{ $item->branch_name }}</option>
                                                        @endforeach 
                                            @else

                                             <option value = '{{Auth::user()->branch_name}}'>{{Auth::user()->branch_name}}</option>
                                                      
                                            @endif

                               
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="itemOrderTable" class="table table-bordered table-hover">
                            <input type="hidden" name="" id="employee_ID">
                            <thead>
                                <tr>
                                    <th>Employee Id</th>
                                    <th>Employee Name</th>
                                    <th>OR Number</th>
                                    <th>Barcode</th>
                                    <th>Item Description</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $val)
                                <tr>
                                    <td>{{ $val->emp_id }}</td>
                                    <td>{{ $val->emp_name }}</td>
                                    <td class="id">
                                        @if ($val->order_no == null)
                                        None
                                        @endif
                                        {{ $val->order_no }}
                                    </td>
                                    <td>{{ $val->barcode }}</td>
                                    <td>{{ $val->name }} {{ $val->description }}
                                    </td>
                                    <td>{{ $val->itemPrice }}</td>
                                    <td>{{ $val->quantity }}</td>
                                    <td><b>{{ $val->totalAmount }}</b></td>
                                </tr>
                                @endforeach
                            </tbody>
                           
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
@endsection

@section('scripts')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Bootstrap Switch -->
<script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

<script src="{{ asset('js/itemorder.js') }}"></script>

@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="{{ asset('css/itemorder.css') }}">
@endsection