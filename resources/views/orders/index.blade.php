@extends('layouts.orders')
@section('header_main')



<div class="header_main">
    <div class="container">

         @if(trim(Auth::user()->isAdmin) == 0)  

            {{dd('Only admin can enter this page')}}

         @endif


        {{-- <div class="row" style="background-color: #2a68ad"> --}}
        <div class="row">
            <!-- Logo -->
            <div class="col-lg-2 col-sm-3 col-3 order-1">
                <div class="logo_container">
                    <div class="logo"><a href="{{ route('initialItems') }}"><img
                                src="{{ asset('dist/img/citihardware.jpg') }}" alt=""></a></div>

                </div>
            </div> <!-- Search -->
            <div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
                <div class="header_search">
                    <div class="header_search_content">
                        <div class="logo"><a href="{{ route('initialItems') }}"><img
                                    src="{{ asset('dist/img/logo.png') }}" alt=""></a></div>
                        {{-- </div> --}}
                    </div>
                </div>
            </div> <!-- Wishlist -->
            <div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
                <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                    <div class="wishlist d-flex flex-row align-items-center justify-content-end">
                        <div class="wishlist_icon"><img
                                src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1560918681/heart.png" alt="">
                        </div>
                        <div class="wishlist_content">
                            <form method="get">
                                @csrf
                                <div class="wishlist_text" id="wishListlink">
                                    <a type="button">Wishlist</a></div>
                                <div class="wishlist_count">{{ $wishCount }}</div>
                            </form>

                        </div>
                    </div> <!-- Cart -->
                    <div class="cart">
                        <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                            <div class="cart_icon"> <img
                                    src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1560918704/cart.png" alt="">
                                <div class="cart_count"><span id="cartCount">{{ $cartCount }}</span></div>
                            </div>
                            <div class="cart_content">
                                <form method="get">
                                    @csrf
                                    <div class="cart_text">
                                        <a type="button" data-target="#showCartModal" data-toggle="modal"
                                            id="showModalBtn">Cart</a>
                                    </div>
                                    <div class="cart_price">₱ {{ $cartTotalAmount }}</div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mb-4 itemBody">

    <div class="row">
        <div class="col-md-6">
            {{-- {{ $items->links() }} --}}
        </div>
        <div class="col-md-6">
            <form id="searchForm" type="GET" action="{{ route('searchCart') }}">
                <input type="text" id="searchBar" name="searchquery" class="form-control" placeholder="Search Item">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="container mt-5 mb-5">
                <div class="d-flex justify-content-center row">
                    <div class="col-md-10">
                        @foreach ($items as $item)
                        <div class="row p-2 bg-white border rounded">
                            <div class="col-md-3 mt-1 image">
                                <img src="{{ asset('assets/img/' . $item->itemImage) }}" class="img-resposive"
                                    style="max-width:150px;padding-right:20px" onerror="if (this.src != '{{ asset('dist/img/default-150x150.png') }}') this.src =
                                                                    '{{ asset('dist/img/default-150x150.png') }}';">
                            </div>
                            <div class="col-md-6 mt-1" style="margin-top: 2vh;">
                                <h3>
                                    <span id="itemname">
                                        {{ $item->name }}
                                    </span>
                                </h3>
                                <div class="mt-1 mb-1 spec-1" style="color: #ed202e" id="barcodeDiv">
                                    <span class="barcode">
                                        {{ $item->barcode }}
                                    </span>
                                </div>
                                <p class="text-justify text-truncate para mb-0">
                                    <span id="desc">
                                        {{ $item->description }}<br><br>


                                        


                           

                                    </span>
                                </p>

                                   <p class="text-justify text-truncate para mb-0">
                                    <span id="qty">
                                       Quantity:&nbsp {{ $item->total_qty }}
                                    </span>
                                </p>

                            </div>
                            <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                                <div class="d-flex flex-row align-items-center">
                                    <h4 class="mr-1">
                                        <span style="font-size: 1.5rem;">
                                            ₱ <span id="cash-price">{{ number_format($item->cash_price) }}</span>
                                        </span>
                                        <!-- <small style = 'display: none;'>
                                            (<span style="color: #ed202e">
                                                ₱ <span
                                                    id="credit-price">{{ number_format($item->credit_price) }}</span>
                                                credit
                                            </span>)
                                        </small> -->
                                    </h4>
                                </div>
                                <div class="d-flex flex-column mt-4">

                                    @if ($item->total_qty > 0)
                                        <button class="btn btn-danger btn-sm btnShowCartModal" id="{{ $item->barcode }}"type="button">Add to Cart</button>
                                    @else
                                        <button class="btn btn-danger btn-sm btnShowCartModal" id="{{ $item->barcode }}"type="button" disabled>Add to Cart</button>
                                    @endif 
                                
                                    <form id="submitForm">
                                        @csrf
                                        <input type="hidden" id="barcode" name="barcode">
                                        <input type="hidden" id="itemPrice" name="itemPrice">
                                        <input type="hidden" id="userId" value={{ Auth::user()->emp_id }} name="userId">
                                        <button class="btn btn-outline-danger btn-sm mt-2 btnWishlist" type="button"
                                            id="{{ $item->barcode }}" style="width: 100%">
                                            Add to wishlist
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
   <!--  <div class="row">
        <div class="col-md-6"></div> -->
       <!--  <div class="col-md-6" id="pagination">
            {{ $items->links() }}
        </div> -->
    <!-- </div> -->

      <div class="row" style = 'width: 37rem; float: right; '>
        <div class="col-md-10"></div>
        <div class="col-md-10" id="pagination" style = 'font-size: 1.2rem;'>
          @if($items->currentPage() != -1)
            <a href="{{ $items->url(1) }}">«&nbsp;</a>
            <a href="{{ $items->previousPageUrl() }}">Prev</a>
              @for($i=1; $i<=$items->lastPage(); $i++) 
                @if($i== $items->currentPage()) 
                    <a class="pranala" ><b>|{{ $i }}|</b>&nbsp;</a>
                 @else

                    @if($i == 1) 
                        <a href="{{ $items->url($i) }}">{{ $i }}&nbsp;</a>

                    @elseif ($i === $items->currentPage() + 2 ) 

                        <a href="{{ $items->url($i) }}">{{ $i }}&nbsp;</a>   &nbsp ... &nbsp

                    @elseif ($i === $items->currentPage() + 1 ) 

                        <a href="{{ $items->url($i) }}">{{ $i }}&nbsp;</a>

                    @elseif ($i === $items->currentPage() - 1 ) 

                        <a href="{{ $items->url($i) }}">{{ $i }}&nbsp;</a>

                    @elseif ($i === $items->currentPage() - 2 ) 

                        &nbsp ... &nbsp <a href="{{ $items->url($i) }}">{{ $i }}&nbsp;</a>

                    @elseif ($i === $items->lastPage()) 

                        <a href="{{ $items->url($i) }}">{{ $i }}&nbsp;</a>

                     @endif

                 @endif
              @endfor
              @if($items->currentPage() != $items->lastPage())
            <a href="{{ $items->nextPageUrl()}}">Next</a>
            <a href="{{ $items->url($items->lastPage()) }}">»</a>
               @endif
        @endif
        </div>
    </div>

    @if (Request::is('cart/search'))
    <div class="row">
        <h3 class="text-center"><a href="{{ route('initialItems') }}">Back to main menu</a></h3>
    </div>
    @endif
</div>
@endsection


@section('modals')


{{-- MODAL FOR THE PROMO MECHANICS --}}

@if ($user[0]->isValidated == 0)
<div class="modal fade" id="mechanicsModal" tabindex="-1" role="dialog" aria-labelledby="mechanicsModalTitle"
    data-keyboard="false" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-md-6">
                    <h3 class="modal-title" id="exampleModalLongTitle">PROMO MECHANICS</h3>
                </div>
                <div class="col-md-6">

                </div>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
            </div>
            <div class="modal-body">
                <img src="{{ asset('img/summerdeals.jpg') }}" alt="Promo mechanics" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success acceptButton" id="{{ $user[0]->emp_id }}">Accept terms and
                    conditions</button>
            </div>
        </div>
    </div>
</div>
@endif





{{-- END OF MODAL FOR THE PROMO MECHANICS --}}


{{-- Start of add to cart modal --}}
<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" id="cartForm">
                @csrf
                <div class="modal-header border-bottom-0">
                    <h2 class="modal-title" id="exampleModalLabel">
                        Add Items to your Cart
                    </h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-image" id="cartTable">
                        <input type="hidden" name="barcode" id="barcodeCart">
                        <input type="hidden" name="itemPrice" id="itemPriceCart">
                        <input type="hidden" name="payType" id="payType">
                        <thead>
                            <tr>
                                <th scope="col">Barcode</th>
                                <th scope="col">Item name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Cash Price</th>
                                <th scope="col">Loan Price</th>
                                <th scope="col">Qty</th>
                                <th scope="col" id="paymentColumn">Payment mode</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="barcodeColumn"></td>
                                <td id="nameColumn"></td>
                                <td id="descColumn"></td>
                                <td id="cashpriceColumn"></td>
                                <td id="creditpriceColumn"></td>
                                <td class="qty">
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="1">
                                </td>
                                <td>
                                    <div class="form-group">
                                        @if (Auth::user()->emp_mode == 0)
                                        <select class="form-control" id="paymentMode" name="cartModal">
                                            <option>Cash payment</option>
                                        </select>
                                        @else
                                        <select class="form-control" id="paymentMode" name="cartModal">
                                            <option>Cash payment</option>
                                            <option>Salary deduction</option>
                                        </select>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="btnAddCart">Add to Cart</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End of add to cart modal --}}

{{-- Start of view cart modal --}}
<div class="modal fade" id="showCartModal" tabindex="-1" role="dialog" aria-labelledby="showCartModallLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog" role="document">
        <div class="modal-content">
            {{-- <form method="post" id="cartForm">
                @csrf --}}
            <div class="modal-header border-bottom-0">
                <h3 class="modal-title" id="showCartModallLabel">
                    YOUR CART
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12" id="orderlink" style="display:none">
                        <h4 class="text-center">
                            <a style="color: #ed202e;" href="{{ route('viewCart') }}">Go to your Order list</a>
                        </h4>
                    </div>
                    <div class="col-sm-6"></div>

                    <div class="col-sm-6" id="locationColumn">
                        <!-- select -->
                        <div class="form-group">
                            <h4>Pick-up Location</h4>
                            <select class="form-control" style="margin-left: 0px" id="locationSelect">

                                    @if(trim(Auth::user()->branch_name) === 'SSC')         
                                              <option value="" selected disabled>Please select pick-up location</option>
                                                @foreach ($locations as $loc)
                                                <option>{{ $loc->branch_name }}</option>
                                                @endforeach
        
                                    @elseif(trim(Auth::user()->branch_name) === 'DC')         
                                              <option value="" selected disabled>Please select pick-up location</option>
                                                @foreach ($locations as $loc)
                                                <option>{{ $loc->branch_name }}</option>
                                                @endforeach
                                    @elseif(trim(Auth::user()->branch_name) === 'WAREHOUSE')         
                                              <option value="" selected disabled>Please select pick-up location</option>
                                                @foreach ($locations as $loc)
                                                <option>{{ $loc->branch_name }}</option>
                                                @endforeach
                                    @elseif(trim(Auth::user()->branch_name) === 'ANNEX')         
                                              <option value="" selected disabled>Please select pick-up location</option>
                                                @foreach ($locations as $loc)
                                                <option>{{ $loc->branch_name }}</option>
                                                @endforeach
                                    @else

                                        <option value = '{{Auth::user()->branch_name}}'>{{Auth::user()->branch_name}}</option>
                                              
                                    @endif

                            </select>

                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-image" id="showCartTable">
                        <input type="hidden" name="barcode" id="barcodeCart">
                        <input type="hidden" name="empId" id="empId" val="{{ Auth::user()->emp_id }}">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Barcode</th>
                                <th scope="col">Item name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Payment mode</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div style = 'padding: 5px;'>
                <button type="button" class="btn btn-secondary" style = 'float:left !important;'  data-dismiss="modal">Close</button>
                <button type="button" id = 'btnPrint' class = 'btn btn-dark' style = 'margin-left: 3px; float:left !important;'>Print</button>
                <button type="button" class="btn btn-success" id="btnConfirmCart" style = 'float:right !important;'>Confirm Cart</button>
            </div>
        </div>
    </div>
</div>
{{-- End of view cart modal --}}

{{-- Start of view wishlist modal --}}
<div class="modal fade" id="showWishlist" tabindex="-1" role="dialog" aria-labelledby="showWishlistlLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog" role="document">
        <div class="modal-content">
            {{-- <form method="post" id="cartForm">
                @csrf --}}
            <div class="modal-header border-bottom-0">
                <h3 class="modal-title" id="showWishlistlLabel">
                    YOUR WISHLIST
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-image" id="showWishlistTable">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Barcode</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Cash Price</th>
                            <th scope="col">Credit Price</th>
                            <th id="wishlistButton"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            {{-- </form> --}}
        </div>
    </div>
</div>
{{-- End of view wishlist modal --}}

{{-- VIEWING OF IMAGE MODAL --}}
<div class="modal fade bd-example-modal-lg" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <img src="" class="imagepreview" style="width: 100%;">
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/cart.js') }}"></script>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection