@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Avatar Display -->
                        <div class="mb-3 text-center">
                            <div class="avatar-wrapper">
                                @if($user->avatar)
                                    <img src="{{ Storage::url($user->avatar) }}" alt="Current Avatar" class="rounded-circle img-thumbnail" width="100">
                                @else
                                    <img src="{{ asset('images/default-avatar.jpeg') }}" alt="Default Avatar" class="rounded-circle img-thumbnail" width="100">
                                @endif
                                <div class="camera-icon">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            <h4 style="margin-top: 1rem;">{{ $user->user_name }}</h4>
                        </div><br>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="user_name" class="form-label">{{ __('USERNAME') }}</label>
                            <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name', $user->user_name) }}" required autocomplete="user_name" autofocus>

                            @error('user_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div><br>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}<small class="text-danger">   (can not be changed)</small></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email" readonly>
                            

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div><br>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div><br>

                        <!-- Introduction -->
                        <div class="mb-3">
                            <label for="introduction" class="form-label">{{ __('Introduction') }}</label>
                            <textarea id="introduction" class="form-control @error('introduction') is-invalid @enderror" name="introduction" rows="5">{{ old('introduction', $user->introduction) }}</textarea>

                            @error('introduction')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div><br>

                        <!-- Avatar Upload -->
                        <div class="mb-3">
                            <label for="avatar" class="form-label">{{ __('Select profile photo') }}</label>
                            <input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar">

                            @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div><br>

                        <!-- Buttons -->
                        <div class="mb-0 d-flex justify-content-center">
                            <button type="submit" class="btn custom-btn me-2">
                                {{ __('Save') }}
                            </button>
                        
                            <button type="button" class="btn custom-btn" onclick="window.location.href='{{ url()->previous() }}'">
                                {{ __('Cancel') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelector('.camera-icon').addEventListener('click', function() {
        document.querySelector('#avatar').click();
    });
</script>
@endsection
