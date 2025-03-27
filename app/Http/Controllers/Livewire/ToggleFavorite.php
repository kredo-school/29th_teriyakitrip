<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FavoriteRestaurant; // お気に入り用レストランモデル
use App\Models\FavoriteItinerary; // お気に入り用旅程モデル
use Illuminate\Support\Facades\Auth;

class ToggleFavorite extends Component
{
    public $itemId; // レストランIDまたは旅程ID
    public $isFavorite = false;
    public $type; // 'restaurant' または 'itinerary'

    public function mount($itemId, $type)
    {
        $this->itemId = $itemId;
        $this->type = $type;
        $this->checkIfFavorite();
    }

    // お気に入りの状態をチェック
    public function checkIfFavorite()
    {
        if ($this->type == 'restaurant') {
            $this->isFavorite = FavoriteRestaurant::where('user_id', Auth::id())
                ->where('place_id', $this->itemId) // place_idを使用
                ->exists();
        } elseif ($this->type == 'itinerary') {
            $this->isFavorite = FavoriteItinerary::where('user_id', Auth::id())
                ->where('itinerary_id', $this->itemId)
                ->exists();
        }
    }

    // お気に入りをトグル
    public function toggleFavorite()
    {
        if ($this->type == 'restaurant') {
            if ($this->isFavorite) {
                FavoriteRestaurant::where('user_id', Auth::id())
                    ->where('place_id', $this->itemId) // place_idを使用
                    ->delete();
            } else {
                FavoriteRestaurant::create([
                    'user_id' => Auth::id(),
                    'place_id' => $this->itemId, // place_idを使用
                ]);
            }
        } elseif ($this->type == 'itinerary') {
            if ($this->isFavorite) {
                FavoriteItinerary::where('user_id', Auth::id())
                    ->where('itinerary_id', $this->itemId)
                    ->delete();
            } else {
                FavoriteItinerary::create([
                    'user_id' => Auth::id(),
                    'itinerary_id' => $this->itemId,
                ]);
            }
        }

        // 状態を更新
        $this->isFavorite = !$this->isFavorite;
        $this->emit('favoriteUpdated');
    }

    public function render()
    {
        return view('livewire.toggle-favorite');
    }
}
