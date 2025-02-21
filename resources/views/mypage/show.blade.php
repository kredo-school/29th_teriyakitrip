<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>My Page</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <!-- ヘッダー -->
        <header class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="TERIYAKI TRIP" class="h-10 mr-4">
                <div class="relative">
                    <select class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <option>Select</option>
                        <!-- Options here -->
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
                <input type="text" placeholder="Search here" class="ml-4 px-4 py-2 border rounded">
            </div>
            <div class="flex items-center">
                <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded mr-2">Create Itinerary</button>
                <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded mr-2">Create Review</button>
                <img src="{{ asset($user->avatar) }}" alt="Profile" class="rounded-full h-10 w-10">
            </div>
        </header>

        <!-- ユーザー情報 -->
        <div class="flex mb-4">
            <div class="w-1/4">
                <img src="{{ asset($user->avatar) }}" alt="Profile" class="rounded-full w-32 h-32">
                <h2 class="text-2xl font-bold mt-2">{{ $user->username }}</h2>
                <p>{{ $user->bio }}</p>
            </div>
            <div class="w-3/4">
                <img src="{{ asset('images/japan_map.png') }}" alt="Japan Map">
            </div>
        </div>

        <!-- ナビゲーション -->
        <nav class="mb-4">
            <ul class="flex">
                <li class="mr-4"><a href="#" class="text-blue-500 hover:text-blue-800">Overview</a></li>
                <li class="mr-4"><a href="#" class="text-blue-500 hover:text-blue-800">Itineraries</a></li>
                <li class="mr-4"><a href="#" class="text-blue-500 hover:text-blue-800">Restaurant Reviews</a></li>
                <li class="mr-4"><a href="#" class="text-blue-500 hover:text-blue-800">10 Followers</a></li>
                <li><a href="#" class="text-blue-500 hover:text-blue-800">56 Following</a></li>
            </ul>
        </nav>

        <!-- 旅程 -->
        <section class="mb-4">
            <h3 class="text-xl font-bold mb-2">Itinerary</h3>
            <div class="flex">
                @foreach($itineraries as $itinerary)
                    <div class="w-1/3 mr-4">
                        <img src="{{ asset($itinerary->image) }}" alt="{{ $itinerary->title }}" class="rounded">
                        <h4 class="text-lg font-bold">{{ $itinerary->title }}</h4>
                        <p>{{ $itinerary->date }}</p>
                    </div>
                @endforeach
            </div>
            <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">MORE</button>
        </section>

        <!-- レストランレビュー -->
        <section class="mb-4">
            <h3 class="text-xl font-bold mb-2">Restaurant's Review</h3>
            <div class="flex">
                @foreach($reviews as $review)
                    <div class="w-1/3 mr-4">
                        <img src="{{ asset($review->image) }}" alt="{{ $review->restaurant_name }}" class="rounded">
                        <h4 class="text-lg font-bold">{{ $review->restaurant_name }}</h4>
                        <p>{{ $review->comment }}</p>
                        <div class="flex">
                            @for ($i = 0; $i < $review->rating; $i++)
                                <span class="text-yellow-500">★</span>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">MORE</button>
        </section>

        <!-- フッター -->
        <footer class="text-center">
            <nav>
                <ul>
                    <li><a href="#">Introduce members</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </nav>
            <p>&copy; Kredo 29th All Rights Reserved</p>
        </footer>
    </div>
</body>
</html>
