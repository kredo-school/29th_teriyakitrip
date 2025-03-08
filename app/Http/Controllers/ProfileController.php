<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function show(User $user)
    {
        $itineraries = $user->itineraries; // ユーザーの旅程を取得
        $restaurantReviews = $user->restaurantReviews; // ユーザーのレストランレビューを取得

        return view('profile.show', compact('user', 'itineraries', 'restaurantReviews'));
    }
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
           'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'introduction' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        if ($request->hasFile('avatar')) {
            // 古いアバター画像を削除
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }

            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $path = $avatar->storeAs('avatars', $filename, 'public');

            $user->avatar = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function get_user($user_id){

        $user = User::with('following')->with('followed')->findOrFail($user_id);
        return response()->json($user);
    }
}
