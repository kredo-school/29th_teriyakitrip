<!DOCTYPE html>

<html lang="ja">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- CSRF Token -->

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name')) | 29th_Teriyaki</title>

    <!-- Fonts -->

    <link rel="dns-prefetch" href="//fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://fonts.googleapis.com/f2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">



    <!-- FontAwesome -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>



    {{-- CSS --}}

    <link rel="stylesheet" href="{{ asset('css/nozomi.css') }}">





    <!-- font awasome -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Google Fonts -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">



    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



    <!-- Scripts -->

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


</head>



<body>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <div class="d-flex align-items-center">
                    <header>
                        @if (!isset($hideLogo))
                            <div class="logo">
                                <a class="logo-link" href="{{ url('/home') }}">
                                    <img src="{{ asset('images/Teriyaki_logo.png') }}" alt="ロゴ" width="96"
                                        height="80">
                                </a>
                            </div>
                        @endif
                    </header>

                    <!-- Search Bar -->
                    <div class="search-bar ms-3">
                        <div class="input-group">
                            <select class="form-select rounded-start"
                                style="width: 100px!important; background-color: #ffe59d;">
                                <option value="all">Select</option>
                                <option value="itinerary">Itinerary</option>
                                <option value="review">Restaurant's Review</option>
                            </select>

                            <input type="text" class="form-control" style="width: 180px!important;"
                                placeholder="Search here...">

                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">

                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

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

                                <a class="nav-link custom-btn" href="#">

                                    <span>Create</span>

                                    <span>Itinerary</span>

                                </a>

                            </li>

                            <li class="nav-item">
                                <a class="nav-link custom-btn" href="{{ route('restaurants.search') }}">
                                    <span>Create</span>

                                    <span>Review</span>

                                </a>

                            </li>



                            <!-- プロフィールモーダル -->

                            <li class="nav-item dropdown">

                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="modal" data-bs-target="#profileModal" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" v-pre>

                                    <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : asset('images/default-avatar.jpeg') }}"
                                        alt="Avatar" class="rounded-circle avatar-image" width="70" height="70">

                                </a>

                            </li>



                            <!-- Modal -->

                            <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="card border-0" style="background-color: #f0f0f0;">
                                                <div class="card-body">
                                                    <a href="{{ route('profile.show', Auth::user()) }}"
                                                        class="text-reset text-decoration-none">
                                                        <div class="user-info-container d-flex align-items-center">
                                                            <div class="me-3">
                                                                <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : asset('images/default-avatar.jpeg') }}"
                                                                    alt="Avatar" class="rounded-circle" width="70"
                                                                    height="70">
                                                            </div>

                                                            <div>
                                                                <h5
                                                                    class="card-title user-info-container d-flex align-items-center">
                                                                    {{ Auth::user()->user_name }}</h5>
                                                                <p class="text-decoration-none">{{ Auth::user()->email }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>

                                            <ul class="list-unstyled slightly-right-aligned">
                                                <li><a class="dropdown-item" href="{{ route('my-itineraries.list') }}">My Itineraries</a></li>
                                                <li><a class="dropdown-item" href="{{ route('my-reviews.list') }}">My Restaurant's Reviews</a>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ route('favorites.list') }}">My Favorites</a></li>
                                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit
                                                        Profile</a></li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();

document.getElementById('logout-form').submit();">
                                                        {{ __('Logout') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                        class="d-none">
                                                        @csrf
                                                    </form>

                                                </li><br>

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



        <main>

            @yield('content')

        </main>

        @include('layouts.footer')

    </div>

    @yield('scripts')







    <!-- ここにBootstrapのJavaScriptを追加 -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>



{{-- Jquery --}}

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


{{-- Google Maps API --}}

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}" async defer></script>




<script src="{{ asset('js/gmaps.js') }}"></script>



</html>
