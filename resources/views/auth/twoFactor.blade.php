@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if(session()->has('message'))
                <p class="alert alert-info">
                    {{ session()->get('message') }}
                </p>
            @endif

            <div class="card">
                {{-- <img class="card-img-top" src="holder.js/100x180/" alt=""> --}}
                <div class="card-body">
                    <h4 class="card-title">Verify it's you</h4>
                    <p class="card-text">We sent a verification code to your email. Enter the code from the email in the field below.</p>

                    <form method="POST" action="{{ route('verify.store') }}">
                        {{ csrf_field() }}
                            <div class="form-group">
                            <label for="">6-digit code<span class="text-danger">*</span></label>
                            <input name="two_factor_code" type="text" value="{{ app('request')->input('code') }}"
                                    class="form-control{{ $errors->has('two_factor_code') ? ' is-invalid' : '' }}" 
                                    required autofocus placeholder="Enter 6-digit code">
                                @if($errors->has('two_factor_code'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('two_factor_code') }}
                                    </div>
                                @endif
                            </div>
                            
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary px-4">
                                    Verify code
                                </button>
                                <a class="btn btn-danger" href="{{ route('verify.cancellogin') }}">Cancel</a>.
                            </div>
                        </div>
                    </form>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            If you haven't received it, press <a href="{{ route('verify.resend') }}">here</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection

{{-- You have received an email which contains two factor login code. --}}
                    {{-- If you haven't received it, press <a href="{{ route('verify.resend') }}">here</a>. --}}