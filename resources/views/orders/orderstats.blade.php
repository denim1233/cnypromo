@extends('layouts.admin')
@section('content')
<div class="content-header">
    <!-- Content Header (Page header) -->
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Order Status</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Order Status</li>
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
                    <!-- /.card-header -->
                    <div class="card-body">
                        <input type="hidden" id="itemId">
                        <input type="hidden" id="employeeId">
                        <table id="orderadminTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Order No.</th>
                                    <th>Employees Location</th>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Pick-up Location</th>
                                    <th>Status</th>
                                    <th>Processing Status</th>
                                    <th>Receieving Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $item)
                                <tr>
                                    <td class="id">{{ $item->id }}</td>
                                    <td class="id">{{ $item->branch_name }}</td>
                                    <td>{{ $item->user_id }}</td>
                                    <td>{{ $item->emp_name }}</td>
                                    <td style="text-transform: uppercase; font-weight: bold">{{ $item->pick_location }}
                                    </td>
                                    <td>{{ $item->status }}</td>
                                    @if ($item->isProcessed == 1)
                                    <td>
                                        <span class="badge badge-pill badge-success">Processed</span>
                                    </td>
                                    @else
                                    <td>
                                        <span class="badge badge-pill badge-warning">Not yet processed</span>
                                    </td>
                                    @endif
                                    @if ($item->isReceived == 1)
                                    <td>
                                        <span class="badge badge-pill badge-success">Received</span>
                                    </td>
                                    @else
                                    <td>
                                        <span class="badge badge-pill badge-warning">Not yet received</span>
                                    </td>
                                    @endif
                                    <td class="text-center" id="lastColumn">

                                        @if($item->status === 'Confirmed')
                                            @if ($item->isProcessed == 0)
                                            <button id="showProc" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#processModal" id="promptDel">
                                                <strong>PROCESS</strong>
                                            </button>
                                            @endif
                                            @if ($item->isProcessed == 1 && $item->isReceived == 0)
                                            <button id="showRec" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#receieveModal" id="promptDel"><strong>RECEIVED</strong>
                                            </button>
                                            @endif
                                        @endif

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

<!-- Process Modal -->
<div id="processModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h4 class="modal-title w-100">Are you sure?</h4> -->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Do you want to process this item?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sucess" data-dismiss="modal">Cancel</button>
                <button type="button" id="processBtn" class="btn btn-success">PROCESS</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Process modal -->

<!-- Receieve Modal -->
<div id="receieveModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h4 class="modal-title w-100">Are you sure?</h4> -->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Have you received the item?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="receiveBtn" class="btn btn-warning">RECEIVED</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Receieve modal -->

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
<script src="{{ asset('js/orderadmin.js') }}"></script>
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