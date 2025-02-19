<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Font -->
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    </head> 
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

     <!-- Custom CSS -->
     <link rel="stylesheet" href="{{ asset('css/style.css')}}"


</head>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <header>
                    @if(!isset($hideLogo))
                        <div class="logo">
                            <a class="logo-link" href="{{ url('/home') }}">
                                <img src="{{ asset('images/Teriyaki_logo.png') }}" alt="ロゴ" width="96" height="80">
                            </a>
                        </div>
                    @endif
                </header>
            
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    {{-- <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul> --}}

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto align-items-center">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('create_itinerary'))
                                <li class="nav-item">
                                    <a class="nav-link custom-btn" href="{{ route('create_itinerary') }}">
                                        <span>Create</span>
                                        <span>Itinerary</span>
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('create_review'))
                                <li class="nav-item">
                                    <a class="nav-link custom-btn" href="{{ route('create_review') }}">
                                        <span>Create</span>
                                        <span>Review</span>
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link custom-btn" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else


                        <!-- ログイン後のヘッダー -->
                            <li class="nav-item">
                                <a class="nav-link custom-btn" href="{{ route('create_itinerary') }}">
                                    <span>Create</span>
                                    <span>Itinerary</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-btn" href="{{ route('create_review') }}">
                                    <span>Create</span>
                                    <span>Review</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="modal" data-bs-target="#profileModal" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : asset('images/default-avatar.jpeg') }}" alt="Avatar" class="rounded-circle" width="70" height="70">

                                </a>
                            </li>

                            <!-- Modal -->
                            <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="card mb-3 border-0" style="background-color: #f0f0f0;">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ Auth::user()->avatar ?Storage::url(Auth::user()->avatar) : asset('images/default-avatar.jpeg') }}" alt="Avatar" class="rounded-circle me-3" width="70" height="70">
                                                        <div>
                                                            <h5 class="card-title mb-0">{{ Auth::user()->username }}</h5>
                                                            <p class="card-text text-muted mb-0">{{ Auth::user()->email }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="list-unstyled">
                                                <li><a class="dropdown-item" href="#">My Itineraries</a></li>
                                                <li><a class="dropdown-item" href="#">My Restaurant's Reviews</a></li>
                                                <li><a class="dropdown-item" href="#">My Favorites</a></li>
                                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a></li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                       onclick="event.preventDefault();
                                                                     document.getElementById('logout-form').submit();">
                                                        {{ __('Logout') }}
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>
    @yield('scripts')
</body>
</html>