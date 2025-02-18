<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Regions')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>


@extends('layouts.app')

@section('title', 'Regions')



@section('content')
    <h1>Hokkaido</h1>

    <nav>
        <a href="#" class="active">Overview</a>
        <a href="#">Itinerary</a>
        <a href="#">Restaurant Review</a>
    </nav>

    <section>
        <h2>Itinerary</h2>
        <x-itinerary-card 
            title="2025 Hokkaido Trip" 
            description="[Day 1] Shakadang Trail, Jiufen Township > Xiaoxihu Trail > Chongqing Shrine > Baiyufan Trail > ..." 
            img="img/biei_flower16.jpg"
        />
        <x-itinerary-card 
            title="2023 Hokkaido Trip" 
            description="[Day 1] Shakadang Trail, Jiufen Township > Xiaoxihu Trail > Chongqing Shrine > Baiyufan Trail > ..." 
            img="img/OIP.jpg" 
        />
        <button>MORE</button>
    </section>

    <section>
        <h2>Restaurant’s Review</h2>
        <x-restaurant-card 
            title="ICHIBAN Unagi" 
            rating="4" 
            img="img/what-is-unagi-gettyimages-13043474274x3-7c4d7358c68d48d7ad029159563608d0.jpg" 
            description="Delicious grilled eel with sweet sauce. A must-try in Hokkaido!"
        />
        <x-restaurant-card 
            title="ABC Italian" 
            rating="3" 
            img="img/download (1).jpg" 
            description="Authentic Italian pasta with a Japanese twist. Great ambiance."
        />
        <button>MORE</button>
    </section>
@endsection

@extends('layouts.app')

