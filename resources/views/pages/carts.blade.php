@extends('layouts.orders')

@section('header_main')
<div class="cart_section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="cart_container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="cart_title">Your list of Orders<small> ({{ $count }} item(s))
                                </small></div>
                        </div>
                        <div class="col-md-6">
                            <div class="cart_title">Pick-up location : <small
                                    style="text-transform: uppercase; color: #ed202e;">
                                    @if (empty($picklocation[0]))
                                    None
                                    @else
                                    {{ $picklocation[0] }}
                                    @endif
                                </small>
                                <!-- <span id="editPick">[ Edit ]</span> -->
                            </div>
                        </div>
                    </div>
                    <div class="cart_items">
                        @foreach ($carts as $item)
                        <ul class="cart_list">
                            <li class="cart_item clearfix">
                                <div class="cart_item_image">
                                    <img src="{{ asset('assets/img/' . $item->itemImage) }}" class="img-resposive"
                                        style="max-width:100px;padding-right:20px" >
                                </div>
                                <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                                    <div class="cart_item_name cart_info_col" style="word-wrap: break-word; width:12rem;">
                                        <div class="cart_item_title">Barcode</div>
                                        <div class="cart_item_text">{{ $item->barcode }}</div>
                                    </div>
                                    <div class="cart_item_color cart_info_col" style="word-wrap: break-word; width:25rem;">
                                        <div class="cart_item_title">Item Name</div>
                                        <div class="cart_item_text">{{ $item->name }}</div>
                                    </div>
                                    <div class="cart_item_quantity cart_info_col" style="word-wrap: break-word; width:25rem;">
                                        <div class="cart_item_title" >Description</div>
                                        <div class="cart_item_text">{{ $item->description }}</div>
                                    </div>
                                    <div class="cart_item_price cart_info_col">
                                        <div class="cart_item_title">Price</div>
                                        <div class="cart_item_text">{{ $item->itemPrice }}</div>
                                    </div>
                                    <div class="cart_item_total cart_info_col">
                                        <div class="cart_item_title">Qty</div>
                                        <div class="cart_item_text">{{ $item->quantity }}</div>
                                    </div>
                                    <div class="cart_item_total cart_info_col">
                                        <div class="cart_item_title">Total Price</div>
                                        <div class="cart_item_text">{{ $item->totalAmount }}</div>
                                    </div>
                                    <div class="cart_item_total cart_info_col">
                                        <div class="cart_item_title">Payment Mode</div>
                                        @if ($item->pay_mode == 0)
                                        <div class="cart_item_text">Cash payment</div>
                                        @else
                                        <div class="cart_item_text">Salary deduction</div>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        </ul>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="cart_title">
                                <small id="backLink">
                                    <a href="{{ route('initialItems') }}">
                                        < Back to Main Menu</a> </small> </div> </div> <div class="col-md-6">
                                            <div class="cart_title">Order status :
                                                <small style="text-transform: uppercase; color: #ed202e;">
                                                    @if (empty($status[0]->isReceived) &&
                                                    empty($status[0]->isProcessed))
                                                    None
                                                    @else
                                                    @if ($status[0]->isReceived == 0)
                                                    @if ($status[0]->isProcessed == 0)
                                                    Not yet processed
                                                    @else
                                                    Processed
                                                    @endif
                                                    @else
                                                    Received
                                                    @endif
                                                    @endif

                                                </small>
                                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('scripts')
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/usercarts.js') }}"></script>
    @endsection

    @section('styles')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/usercarts.css') }}">
    @endsection