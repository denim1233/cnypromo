@extends('layouts.admin')

@section('content')
<div class="content-header">
    <!-- Content Header (Page header) -->
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Items</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Items</li>
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
                        {{-- <button id="csvBtn" class="btn btn-primary" data-toggle="modal" data-backdrop="static"
                            data-keyboard="false" data-target="#csvModal"><i class="fas fa-file-import"></i> Import CSV
                            File
                        </button> --}}
                        <button id="addBtn" class="btn btn-success" style="float: right;" data-toggle="modal"
                            data-backdrop="static" data-keyboard="false" data-target="#itemAddModal">
                            <i class="fas fa-plus"></i>
                            Add
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <input type="hidden" id="itemId">
                        <table id="itemTable" class="table table-bordered table-hover">
                            
                            <thead>
                                <tr>
                                    <th>Table ID</th>
                                    <th>Barcode</th>
                                    <th>Item Name</th>
                                    <th>Description</th>
                                    <th>Product Image</th>
                                    <th>Stocks</th>
                                    <th>Cash Price</th>
                                    <th>Credit Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                <tr>
                                    <td class="id">{{ $item->id }}</td>
                                    <td>{{ $item->barcode }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>
                                        <img src="{{ asset('assets/img/' . $item->itemImage) }}" class="img-fluid"
                                            style="width:100px;height:100px;margin-top20px;"
                                            onerror="if (this.src != '{{ asset('dist/img/default-150x150.png') }}') this.src = '{{ asset('dist/img/default-150x150.png') }}';">
                                    </td>
                                    <td>{{ $item->total_qty }}</td>
                                    <td>{{ $item->cash_price }}</td>
                                    <td>{{ $item->credit_price }}</td>
                                    <td>
                                        <button id="editBtn" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-backdrop="static" data-keyboard="false" data-target="#itemEditModal"><i
                                                class="fas fa-edit"></i>
                                        </button>
                                        <a href=""></a>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteModal" id="promptDel">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
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

{{-- Start of ADDING modal --}}
<div class="modal fade bd-example-modal-lg" id="itemAddModal" tabindex="-1" role="dialog"
    aria-labelledby="itemAddModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="item_Form" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="itemAddModalLabel">Add New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <form id="itemForm"> --}}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md">
                                <label for="barcode" class="col-form-label">Barcode: </label>
                                <input required="required" type="text" class="form-control" id="barcode" name="barcode">
                            </div>
                            <div class="col-md">
                                <label for="item_name" class="col-form-label">Item Name:</label>
                                <input required="required" type="text" class="form-control" id="item_name" name="name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Description:</label>
                        <textarea id="description" class="form-control" required="required"
                            name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md">
                                <label for="image" class="col-form-label">Image:</label>
                                <input type="file" class="form-control-file" id="image" accept="image/*"
                                    name="itemImage" onchange="previewFile(this)" required="required">
                                <img id="previewImg" style="max-width:130px;margin-top20px;">
                            </div>
                            <div class="col-md">
                                <label for="quantity" class="col-form-label">Stocks available:</label>
                                <input required="required" type="number" class="form-control" id="quantity"
                                    name="quantity">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md">
                                <label for="cash_price" class="col-form-label">Cash Price:</label>
                                <input required="required" type="number" class="form-control" id="cash_price" value="0"
                                    name="cash_price">
                            </div>
                            <div class="col-md">
                                <label for="credit_price" class="col-form-label">Credit Price:</label>
                                <input required="required" type="number" class="form-control" id="credit_price"
                                    value="0" name="credit_price">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="saveBtn">Save</button>
                </div>
            </form>
        </div>
        {{-- </form> --}}
    </div>
</div>
{{-- End of adding modal --}}

{{-- Start of EDITING modal --}}
<div class="modal fade bd-example-modal-lg" id="itemEditModal" tabindex="-1" role="dialog"
    aria-labelledby="itemEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="edit_Form" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="itemEditModalLabel">Edit Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <form id="itemForm"> --}}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md">
                                <label for="barcode" class="col-form-label">Barcode: </label>
                                <input name="barcode" required="required" type="text" class="form-control"
                                    id="edit_barcode">
                            </div>
                            <div class="col-md">
                                <label for="item_name" class="col-form-label">Item Name:</label>
                                <input name="name" required="required" type="text" class="form-control"
                                    id="edit_item_name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Description:</label>
                        <textarea name="description" id="edit_description" class="form-control" required="required">
                    </textarea>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md">
                                <label for="image" class="col-form-label">Image:</label>
                                <input name="itemImage" type="file" class="form-control-file" id="edit_image"
                                    accept="image/*" onchange="previewFile(this)">
                                <img id="previewImg" style="max-width:130px;margin-top20px;">
                            </div>
                            <div class="col-md">
                                <label for="quantity" class="col-form-label">Stocks available:</label>
                                <input name="quantity" required="required" type="number" class="form-control"
                                    id="edit_quantity">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md">
                                <label for="cash_price" class="col-form-label">Cash Price:</label>
                                <input name="cash_price" required="required" type="number" class="form-control"
                                    id="edit_cash_price" value="0">
                            </div>
                            <div class="col-md">
                                <label for="credit_price" class="col-form-label">Credit Price:</label>
                                <input name="credit_price" required="required" type="number" class="form-control"
                                    id="edit_credit_price" value="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" id="updateBtn">Update</button>
                </div>
            </form>
        </div>

        {{-- </form> --}}
    </div>
    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif --}}
</div>
{{-- End of editing modal --}}

<!-- Delete Modal -->
<div id="deleteModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100">Are you sure?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="deleteBtn" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- End of delete modal -->
<!-- CSV Modal -->
<div id="csvModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100">Import CSV File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form id="importForm">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlFile1">CSV File</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="csvUploadBtn" class="btn btn-success">Import</button>
            </div>
        </div>
    </div>
</div>
<!-- End of CSV modal -->
@endsection

@section('scripts')
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
<script src="{{ asset('js/customscript.js')}}"></script>
@endsection

@section('styles')
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
<script src="{{ asset('dist/css/custom.css')}}"></script>

@endsection
