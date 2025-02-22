<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'regions')</title>
     <!-- Google Fonts（Poppins） -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">

     <link rel="stylesheet" href="{{ asset('css/regions-style.css') }}">
</head>


<body>

    <!-- 共通ナビゲーション -->
    <header>
        <h1 class="page-title">Hokkaido</h1>
        <ul class="nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="{{ url('/regions/overview') }}">Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('itinerary') ? 'active' : '' }}" href="{{ url('/regions/itinerary') }}">Itinerary</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('restaurant-review') ? 'active' : '' }}" href="{{ url('/regions/restaurant-review') }}">Restaurant Review</a>
            </li>
        </ul>
    </header>

    <main>
        @yield('content')
    </main>
    <br>
    <!-- 📌 フッター部分を追加 -->
    <footer class="footer">
        <div class="footer-content">
            <p class="footer-item">▶ Introduce members</p>
            <p class="footer-item">▶ Contact Us</p>
        </div>
        <p class="copyright">Copyright ©Kredo 29th All Rights Reserved</p>
    </footer>
</body>
</html>
