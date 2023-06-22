@extends('layouts.auth')

@section('content')
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="card-wrapper">
                <div class="container logo">
                    <img src="{{ asset('dist/img/citihardware.jpg') }}" alt="logo">
                </div>
                <div class="card fat">
                    <div class="card-body">
                        <h4 class="card-title">Login</h4>
                        <form action="{{ route('auth.check') }}" method="post">
                            @csrf
                            <div class="results">
                                @if (Session::get('error'))
                                <div class="alert alert-danger">
                                    <b>{{ Session::get('error') }}</b>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="idnum">Employee ID No.</label>
                                <input id="idnum" type="text" class="form-control" name="idnum" autocomplete="off"
                                    value="{{ old('idnum') }}">
                                @if ($errors->has('idnum'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('idnum') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="logpass">Password
                                </label>
                                <input id="logpass" type="password" class="form-control" name="logpass"
                                    value="{{ old('logpass') }}">
                                @if ($errors->has('logpass'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('logpass') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group m-0">
                                <button type="submit" id="btnLogin" class="btn btn-block">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="footer">
                    Copyright &copy; 2020 &mdash; CitiHardware
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')

@endsection

@section('styles')

@endsection