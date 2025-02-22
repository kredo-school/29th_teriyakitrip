@extends('layouts.app')

@section('logo')
    <img src="{{ asset('images/Teriyaki_logo.png') }}" alt="ロゴ" width="96" height="80">
@endsection

@section('content')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="{{ asset('css/style.css')}}">

<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="card border-0 bg-white">
            <div class="text-center" style="font-size: 3rem; font-weight: bold; color: rgb(255, 136, 0);">
                {{ __('Reset Password') }}</div><br>

                <div class="col-md-8 mx-auto">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row justify-content-center mb-3">
                            <div class="col-md-8 text-start">
                            <label for="email" class="form-label">{{ __('EMAIL') }}</label>
                            <input id="email" type="email" class="form-control custom-width custom-input d-block @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><br>

                        <style>
                            .custom-input {
                                border: 2px solid #ccc;
                                border-radius: 5px;
                                padding: 10px;
                                font-size: 16px;
                                transition: border-color 0.3s ease;
                            }
                        
                            .custom-input:focus {
                                border-color: #007bff;
                                box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
                                outline: none;
                            }
                        
                            .custom-input::placeholder {
                                color: #999;
                                font-style: italic;
                            }
                            
                            .custom-width{
                                max-width: 100%;
                                width: 100%;
                            }
                        </style>

                        <br>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-3 text-center">
                                <button type="submit" class="btn btn-primary orange-button mb-4" >
                                    {{ __('Send') }}
                                </button>
                            </div><br>
                            <style>
                                .orange-button {
                                    background-color: rgb(255, 136, 0);
                                    border-color: rgb(255, 136, 0);
                                    color: white;
                                    font-weight: bold; 
                                    padding: 10px 40px;
                                }
                                .orange-button:hover, .orange-button:focus {
                                    background-color: rgb(230, 122, 0);
                                    border-color: rgb(230, 122, 0);
                                    color: white;
                                }
                            </style>

                            @if (Route::has('login'))
                                <a class="btn btn-link" href="{{ route('login') }}">
                                    {{ __('Already registered? Login') }}
                                </a><br>
                            @endif

                            @if (Route::has('register'))
                                <a class="btn btn-link" href="{{ route('register') }}">
                                    {{ __("Don't have an account? Register") }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection