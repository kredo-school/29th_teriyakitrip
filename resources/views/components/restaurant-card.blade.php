<div class="restaurant-card">
    <img src="{{ asset($img) }}" alt="{{ $title }}">
    <div>
        <h3>{{ $title }}</h3>
        <p>{{ $description }}</p>
        <p>
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $rating)
                    ⭐
                @else
                    ☆
                @endif
            @endfor
        </p>
    </div>
</div>