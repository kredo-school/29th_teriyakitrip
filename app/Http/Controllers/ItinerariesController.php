<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Region;
use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Authファサードをインポート


class ItinerariesController extends Controller
{
    private $itinerary;

    public function __construct(Itinerary $itinerary) {
        $this->itinerary = $itinerary;
    }

    public function showFirstform(Request $request)
    {
       
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'prefectures' => 'required|array',
            'prefectures.*' => 'string',
        ]);
    
        // ユーザーがログインしていない場合はリダイレクトする
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'ログインが必要です。');
        }
    
        // 新しい旅行プランの作成
        $itinerary = Itinerary::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        $itinerary->prefectures()->attach($request["prefectures"]);
        // 都道府県情報の保存
        // if ($request->has('prefectures') && count($request->prefectures) > 0) {
        //     foreach ($request->prefectures as $prefecture_id) {
        //         ItineraryPrefecture::create([
        //             'itinerary_id' => $itinerary->id,
        //             'prefecture_id' => $prefecture_id, // ここで正しいprefecture_idを渡す
        //         ]);
        //     }
        // } else {
        //     return redirect()->route('itineraries.create_itinerary', ['id' => $itinerary->id])
        //         ->with('error', '少なくとも1つの都道府県を選択してください');
        // }
        return redirect()->route('itineraries.itineraries.create_itinerary', ['id' => $itinerary->id]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::with('prefectures')->get();

        return view('itineraries.itinerary_first_form', compact('regions'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id = null)
    {
        // プロフィール表示の場合
        if ($request->route()->named('profile.show')) {
            $profileUser = User::findOrFail($id);
            $itineraries = $profileUser->itineraries()->latest()->take(3)->get();
            $restaurantReviews = $profileUser->restaurantReviews()->latest()->take(3)->get();
    
            return view('profile.show', compact('profileUser', 'itineraries', 'restaurantReviews'));
        }
        
        // 個別の旅程表示の場合
        if ($request->route()->named('itineraries.show')) {
            $itinerary = Itinerary::findOrFail($id);
            return view('itineraries.show', compact('itinerary'));
        }
    
        // それ以外の場合（エラーハンドリングなど）
        abort(404);
    }    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Itinerary $itinerary)
    {
        //
        return view('itineraries.edit_itinerary');
    }

    public function editDestination($id){
        $itinerary = Itinerary::find($id);
        $regions = Region::with('prefectures')->get();
        
        // Get selected prefectures from itinerary
        $selectedPrefectures = $itinerary ? $itinerary->prefectures()->pluck('prefectures.id')->toArray() : [];
    
        return view('itineraries.edit_itinerary_destination', compact('itinerary', 'regions', 'selectedPrefectures'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Itinerary $itinerary)
    {
        //
    }

    public function updateDestination(Request $request, $id) {
        $itinerary = Itinerary::findOrFail($id);
        
        // Update itinerary's destinations
        $itinerary->prefectures()->sync($request->input('prefectures', []));
    
        return redirect()->route('itinerary.create_itinerary_header')->with('success', 'Destination updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itinerary $itinerary)
    {
        //
    }
    public function index()
    {
        //
        $itineraries = $this->itinerary->where('is_public', true)
                                   ->latest()
                                   ->take(3)
                                   ->get();
    return view('home', compact('itineraries'));
    }

    // create_itinerary_header, create_itinerary_body - SAKI
    public function addList($id)
    {
        $itinerary = Itinerary::with('prefectures')->findOrFail($id);

        return view('itineraries.create_itinerary', compact('itinerary'));
    }

    // show_itinerary - SAKI
    public function showItinerary(){
        return view('itineraries.show_itinerary');
    }
    
}


