<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itinerary;
use Illuminate\Support\Facades\Auth;

class MyItineraryController extends Controller
{

    public function index() //Toshimi SAKI
    {
        // ログインユーザーの旅程のみ取得
        $itineraries = Itinerary::where('user_id', Auth::id())->get();
        
        // ビューにデータを渡す
        return view('itinerary.index', compact('itineraries'));
    }

    public function updatePrivacy(Request $request, $id)
    {
        $itinerary = Itinerary::where('id', $id)
            ->where('user_id', Auth::id()) // 自分の旅程のみ変更可能
            ->firstOrFail();

        // プライバシー設定を更新
        $itinerary->is_public = $request->input('privacySetting') === 'private' ? 0 : 1;
        $itinerary->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $itinerary = Itinerary::findOrFail($id);

        // ユーザーが自分の旅程を削除していることを確認
        if ($itinerary->user_id == auth()->id()) {
            $itinerary->delete(); // 旅程を削除
            
        }

        return redirect()->back();
    }


    
    






}
