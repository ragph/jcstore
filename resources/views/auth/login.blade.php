@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
                <img src="./public/skinlogo.png" width="160">
        </div>
    </div>
    <div class="row justify-content-center">
    <div class="col-md-4 text-center">
        <h5>Login</h5>
    </div>
    </div>
    <form method="POST" action="{{ route('login') }}"> @csrf


   <div class="row justify-content-center mt-4">
        <div class="col-md-4">
                <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="email" placeholder="{{ __('Username / email') }}" autofocus >
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>
   </div>
   <div class="row justify-content-center mt-3">
        <div class="col-md-4">
                <input  id="password" type="password"  placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>
   </div>

   <div class="row justify-content-center  mt-5">
        <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-block">Login</button>
        </div>
   </div>
   </form>
</div>
@endsection
