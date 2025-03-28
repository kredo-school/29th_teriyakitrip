<div>
    <button wire:click="toggleFavorite" class="btn btn-outline-warning ms-md-3">
        @if($isFavorite)
            <i class="fa-solid fa-star"></i> Unfavorite
        @else
            <i class="fa-regular fa-star"></i> Favorite
        @endif
    </button>
</div>
