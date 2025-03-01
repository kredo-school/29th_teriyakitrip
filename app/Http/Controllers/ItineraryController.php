<?php

namespace App\Http\Controllers;

use App\Models\Itineraries;
use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeTab = 'overview'; // デフォルトのアクティブタブを設定
        $itineraries = Itineraries::latest()->paginate(10);
        $user = auth()->user(); // ログインユーザーを取得
        return view('.index', compact('activeTab','itineraries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function index()
    // {
    //     return view('itinerary.index');
    // }
}
