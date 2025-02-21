<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function show(string $id): View
    {
        $user = User::findOrFail($id);
        $itineraries = $user->itineraries()->latest()->take(3)->get();
        $reviews = $user->reviews()->latest()->take(3)->get();

        return view('mypage.show', [
            'user' => $user,
            'itineraries' => $itineraries,
            'reviews' => $reviews,
        ]);
    }
}
