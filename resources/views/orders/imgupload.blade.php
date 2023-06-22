@extends('layouts.orders')
@section('header_main')

<div class="d-flex p-2">
    <img src="{{ asset('img/cnyMechanics.png') }}" alt="" id="banner">
</div>


<div class="container">



    <form method="post" id="uploadForm" action="{{ route('submitUploads') }}" enctype='multipart/form-data'>
        @csrf
        <input type="hidden" name="idnumber" value="{{ Auth::user()->emp_id }}">
        <div class="container mb-4">
            <main class="main_full">
                <div class="container">
                    <div class="panel_like">
                        <div class="button_outer_like">
                            <div class="btn_upload_like">
                                <input type="file" required="required" accept="image/*" id="upload_page_like"
                                    name="upload_page_like">
                                Upload Facebook Page Like Screenshot
                            </div>
                            <div class="processing_bar_like"></div>
                            <div class="success_box_like"></div>
                        </div>
                    </div>
                    <div class="error_msg_like">
                        @if ($errors->has('upload_page_like'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('upload_page_like') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="uploaded_file_view_like" id="uploaded_view_like">
                        <span class="file_remove_like">X</span>
                    </div>
                </div>
            </main>
        </div>
        <div class="container mb-4">
            <main class="main_full">
                <div class="container">
                    <div class="panel_share">
                        <div class="button_outer_share">
                            <div class="btn_upload_share">
                                <input type="file" required="required" accept="image/*" id="upload_post_like"
                                    name="upload_post_like">
                                Upload Facebook Post Like Screenshot
                            </div>
                            <div class="processing_bar_share"></div>
                            <div class="success_box_share"></div>
                        </div>
                    </div>
                    <div class="error_msg_share">
                        @if ($errors->has('upload_post_like'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('upload_post_like') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="uploaded_file_view_share" id="uploaded_view_share">
                        <span class="file_remove_share">X</span>
                    </div>
                </div>
            </main>
        </div>
        <div class="container mb-4">
            <main class="main_full">
                <div class="container">
                    <div class="panel">
                        <button types="submit" id="submitButton">Submit Images</button>
                    </div>
                </div>
            </main>
        </div>
    </form>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
<link rel="stylesheet" href="{{ asset('css/upload.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/cart.js') }}"></script>
<script src="{{ asset('js/upload.js') }}"></script>
@endsection