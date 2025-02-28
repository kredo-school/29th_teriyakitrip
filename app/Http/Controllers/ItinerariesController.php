<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Regions;
use App\Models\Itineraries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Authファサードをインポート


class ItinerariesController extends Controller
{
    private $itinerary;

    public function __construct(Itineraries $itinerary) {
        $this->itinerary = $itinerary;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Regions::with('prefectures')->get();

        return view('itineraries.itinerary_first_form', compact('regions'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_public' => 'nullable|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('itineraries', 'public');
        }
    
        // 認証済みのユーザーIDを使用
        $userId = Auth::id();
    
        Itineraries::create([
            'user_id' => $userId, // ログインしているユーザーのIDを設定
            'title' => $validatedData['title'],
            'start_date' => $validatedData['start_date'] ?? null,
            'end_date' => $validatedData['end_date'] ?? null,
            'is_public' => $validatedData['is_public'] ?? false,
            'photo' => $photoPath,
        ]);
    
        return redirect()->route('itineraries.index')->with('success', '旅程が作成されました。');
    
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
            $itinerary = Itineraries::findOrFail($id);
            return view('itineraries.show', compact('itinerary'));
        }
    
        // それ以外の場合（エラーハンドリングなど）
        abort(404);
    }    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Itineraries $itineraries)
    {
        //
        return view('itineraries.edit_itinerary');
    }

    public function editDestination($id){
        $itinerary = Itineraries::find($id);
        $regions = Regions::with('prefectures')->get();
        
        // Get selected prefectures from itinerary
        $selectedPrefectures = $itinerary ? $itinerary->prefectures()->pluck('prefectures.id')->toArray() : [];
    
        return view('itineraries.edit_itinerary_destination', compact('itinerary', 'regions', 'selectedPrefectures'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Itineraries $itineraries)
    {
        //
    }

    public function updateDestination(Request $request, $id) {
        $itinerary = Itineraries::findOrFail($id);
        
        // Update itinerary's destinations
        $itinerary->prefectures()->sync($request->input('prefectures', []));
    
        return redirect()->route('itinerary.create_itinerary_header')->with('success', 'Destination updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itineraries $itineraries)
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

    public function addList(){
        return view('itineraries.create_itinerary_header');
    }

    
}


