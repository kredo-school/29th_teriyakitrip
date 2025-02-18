<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'region')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>


<body>

    <header>
        <div class="logo">LOGO</div>
        <nav>
            <a href="#">Search</a>
            <a href="#">Create Itinerary</a>
            <a href="#">Create Review</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>Copyright Canada 99% All Rights Reserved</p>
    </footer>

</body>
</html>
