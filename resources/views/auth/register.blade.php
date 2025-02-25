@extends('layouts.app')

@section('content')

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="{{ asset('css/style.css')}}">

<div class="container">
    <div class="row justify-content-center">
        <div class="card border-0 bg-white">
            <div class="text-center" style="font-size: 3rem; font-weight: bold; color: #E97911;">
                <span>Create New</span><br>
                <span>Account</span>
            </div>
        
        <div class="col-md-8 mx-auto">
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                  <div class="form-container">
                    <div class="form-group">
                        <label for="username">USERNAME</label>
                        <input id="username" type="text" class="form-control custom-width custom-input" name="username">

                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">EMAIL</label>
                        <input id="email" type="email" class="form-control custom-width custom-input" name="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password">PASSWORD</label>
                        <input id="password" type="password" class="form-control custom-width custom-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">CONFIRM PASSWORD</label>
                        <input id="password-confirm" type="password" class="form-control custom-width custom-input" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <!-- Input Field - Effects -->
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
                    
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary orange-button">
                                {{ __('SIgn in') }}
                            </button>
                    </div>
                    </form>

                            <style>
                                .orange-button {
                                    background-color: #E97911;
                                    border-color: #E97911;
                                    color: white;
                                    font-weight: bold; 
                                    padding: 10px 40px;
                                }
                                .orange-button:hover, .orange-button:focus {
                                    background-color: #E97911;
                                    border-color: #E97911;
                                    color: white;
                                }
                                .btn-link {
                                        display: inline-block;
                                        width: auto;
                                }
                            </style>

                            @if (Route::has('login'))
                            <div class="text-center mt-3">
                                <a class="btn btn-link" href="{{ route('login') }}">
                                    {{ __("Already Resistered? Login?") }}
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
