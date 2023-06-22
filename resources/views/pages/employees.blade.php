@extends('layouts.admin')

@section('content')
<div class="content-header">
    <!-- Content Header (Page header) -->
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Employees</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Employees</li>
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
                       <!--  <button class="btn btn-primary" style="float: right;" data-toggle="modal" data-backdrop="static"
                            data-keyboard="false" data-target="#itemModal"><i class="fas fa-plus"></i> Add</button> -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Employee Location</th>
                                    <th>Department</th>
                                    <th>Table ID</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Contact Number</th>
                                    <!-- <th>Position</th> -->

                           <!--          <th>Admin</th>
                                    <th class="text-center">Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $employee->branch_name }}</td>
                                    <td>{{ $employee->department }}</td>
                                    <td>{{ $employee->id }}</td>
                                    <td>{{ $employee->emp_id }}</td>
                                    <td>{{ $employee->emp_name }}</td>
                                    <td>{{ $employee->username }}</td>
                                    <td>{{ $employee->contact_number }}</td>
                                    <!-- <td>{{ $employee->position }}</td> -->

                                  <!--   <td class="text-center">
                                        <input type="checkbox" name="" id="" style="width: 15px; height: 17px;" />
                                    </td> -->
                                   <!--  <td class="text-center">
                                        <button id="editBtn" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-backdrop="static" data-keyboard="false" data-target="#itemEditModal"><i
                                                class="fas fa-edit"></i>
                                        </button>
                                        <a href=""></a>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteModal" id="promptDel">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td> -->
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

{{-- Start of modal --}}
<div class="modal fade bd-example-modal-lg" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itemModalLabel">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md">
                                <label for="barcode" class="col-form-label">Barcode</label>
                                <input type="text" class="form-control" id="barcode">
                            </div>
                            <div class="col-md">
                                <label for="item_name" class="col-form-label">Item Name</label>
                                <input type="text" class="form-control" id="item_name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Description</label>
                        <textarea id="summernote">

                        </textarea>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md">
                                <label for="stocks" class="col-form-label">Stocks</label>
                                <input type="number" class="form-control" id="stocks">
                            </div>
                            <div class="col-md">
                                <label for="price" class="col-form-label">Price</label>
                                <input type="number" class="form-control" id="price">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
{{-- End of modal --}}

@endsection

@section('scripts')
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
<script>
    $(function () {
        var dTable = $("#example1").DataTable({
          "responsive": true, 
          "lengthChange": false,
          "pageLength": 25, 
          "autoWidth": false,
          "buttons": [
              "copy", 
              "csv", 
              "excel", 
              "pdf", 
              "print", 
              "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        // Summernote
        var sumNote = $('#summernote').summernote(
            {
                height: 100,
                focus: true
            }
        )
      });
</script>
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection