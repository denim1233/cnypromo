@extends('layouts.admin')

@section('content')
<div class="content-header">
    <!-- Content Header (Page header) -->
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Orders</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Orders</li>
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
                        {{-- <button id="editBtn" class="btn btn-warning" data-toggle="modal" data-backdrop="static"
                            data-keyboard="false" data-target="#itemModal"><i class="fas fa-edit"></i> Edit
                        </button> --}}
                    </div>

                    <div class = "col-12" style = 'margin-left:1rem;'>
                                    <label style = 'display: block;'>PICK-UP LOCATION</label>
                                    <select style = 'width: 20rem; display: inline-flex;' class="form-control" id="pickLocationSelect">


                                         {{Auth::user()->branch_name}}
                                            @if(Auth::user()->branch_name === 'SSC' || Auth::user()->branch_name === 'DC')         
                                                      <option value="All" >All</option>
                                                                 @foreach ($branch as $item)
                                                        <option>{{ $item->branch_name }}</option>
                                                        @endforeach 
                                            @else

                                             <option value = '{{Auth::user()->branch_name}}'>{{Auth::user()->branch_name}}</option>
                                                      
                                            @endif
                                    </select>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <input type="hidden" id="itemId">
                        <input type="hidden" id="employeeId">
                        <table id="orderadminTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Cart No.</th>
                                    <th>Order No.</th>
                                    <th>Employee Location</th>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Barcode</th>
                                    <th>Item Name</th>
                                    <th>Description</th>
                                    <th>Cash Price</th>
                                    <th>Loan Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Pay Mode</th>
                                    <th>Date Ordered</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td class="id">
                                        @if ($item->order_no == null)
                                        None
                                        @endif
                                        {{ $item->order_no }}
                                    </td>
                                    <td>{{ $item->branch_name }}</td>
                                    <td>{{ $item->userId }}</td>
                                    <td>{{ $item->emp_name }}</td>
                                    <td>{{ $item->barcode }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->cash_price }}</td>
                                    <td>{{ $item->loan_price }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->totalAmount }}</td>
                                    @if ($item->pay_mode == 0)
                                    <td>
                                    <!-- <span class="badge badge-pill badge-primary">Cash payment</span> -->
                                        Cash Payment
                                    </td>
                                    @else
                                    <td>
                                        Salary Deduction
                                    </td>
                                    @endif
                                    <td>
                                        {{ $item->updated_at }}
                                    </td>
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
<script src="{{ asset('js/orderadmin.js') }}?v=3"></script>
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
<script src="{{ asset('css/orderadmin.css') }}"></script>
@endsection