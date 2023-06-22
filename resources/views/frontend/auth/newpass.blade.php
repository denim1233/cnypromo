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
                        <h4 class="card-title">New Password</h4>
                        <form id="registerForm">
                            @if (Session::get('notmatch'))
                            <div class="alert alert-danger">
                                {{ Session::get('notmatch') }}
                            </div>
                            @endif
                            @if (Session::get('defpass'))
                            <div class="alert alert-danger">
                                {{ Session::get('defpass') }}
                            </div>
                            @endif
                            {{-- <input type="hidden" name="idnum" value="{{ $idnumber }}"> --}}
                            <div class="form-group">
                                <label for="idnum">Employee ID No.</label>
                                <input id="idnum" type="text" class="form-control" name="idnum" required
                                    autocomplete="new-password" value="{{ old('idnum') }}">
                                <span class="text-danger" id="">
                                    <strong>
                                        @error('idnum')
                                        {{ $message }}
                                        @enderror
                                    </strong>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control" name="password" required
                                    autocomplete="new-password" value="{{ old('password') }}">
                                @if ($errors->has('password'))
                                <span class="text-danger">
                                    <strong>
                                        @error('password')
                                        {{ $message }}
                                        @enderror
                                    </strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="newpass">Confirm New password</label>
                                <input id="newpass" type="password" class="form-control" name="newpass" required
                                    autocomplete="new-password" value="{{ old('newpass') }}">
                            </div>
                            <div class="form-group m-0">
                                <button type="submit" id="btnRegister" class="btn btn-block">
                                    Register
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