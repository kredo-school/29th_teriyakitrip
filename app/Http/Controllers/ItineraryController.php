<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Region;

use App\Models\Itinerary;
use Illuminate\Http\Request;
use App\Models\ItinerarySpot;
use App\Models\ItineraryPrefecture;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;//Sunao
use Illuminate\Support\Facades\Log;//Sunao
use Carbon\Carbon; // Carbon ライブラリをインポート //Sunao
use Illuminate\Support\Facades\Auth; // Authファサードをインポート



class ItineraryController extends Controller
{
    private $itinerary;

    public function __construct(Itinerary $itinerary) {
        $this->itinerary = $itinerary;
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
        Log::info('Store メソッド開始', $request->all());
    
        // 1️⃣ **ログインユーザーの取得**
        $user_id = Auth::id();    
        if (!$user_id) {
            Log::error('ユーザーIDが送信されていません');
            return redirect()->back()->withErrors(['error' => 'ユーザーIDが必要です']);
        }
    
        // dd($request);
        // 2️⃣ **バリデーション**
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_public' => 'nullable|boolean',
            'photo_base64' => 'required',
            'prefectures' => 'required|array|min:1',
            'prefectures.*' => 'exists:prefectures,id',
        ]);
    
       Log::info('バリデーション成功', $validatedData);
    
        // 3️⃣ **画像処理**
        $photoPath = null;
        if (!empty($request->input('photo_base64'))) {
            $image = preg_replace('/^data:image\/\w+;base64,/', '', $request->input('photo_base64'));
            $imageData = base64_decode($image);
            $fileName = 'itinerary_' . time() . '.jpg';
            Storage::disk('public')->put('itineraries/' . $fileName, $imageData);
            $photoPath = 'itineraries/' . $fileName;
        } else {
            Log::error('photo_base64 が送信されていません');
            return back()->withErrors(['photo_base64' => '画像が送信されていません'])->withInput();
        }
    
        // 4️⃣ **Itinerary の作成**
        $itinerary = Itinerary::create([
            'user_id' => $user_id, // ✅ `Auth::id()` ではなく、リクエストの `user_id` を使う
            'title' => $validatedData['title'],
            'start_date' => $validatedData['start_date'] ?? null,
            'end_date' => $validatedData['end_date'] ?? null,
            'is_public' => $validatedData['is_public'] ?? false,
            'photo' => $photoPath,
        ]);
    
       Log::info('Itinerary 作成成功', ['itinerary_id' => $itinerary->id]);
    
        // 5️⃣ **Many-to-Many 関係を保存（都道府県データを関連付ける）**
        if (!empty($request->prefectures) && is_array($request->prefectures)) {
           Log::info('受け取ったデータ:', ['prefectures' => $request->prefectures]);
        
            // `sync()` を使うことで、現在のデータを置き換え & 重複登録を防ぐ
            $itinerary->prefectures()->sync($request->prefectures);
        
            Log::info('都道府県を保存しました:', ['itinerary_id' => $itinerary->id, 'saved_prefectures' => $request->prefectures]);
        } else {
           Log::warning('都道府県データが空、または無効な形式です');
        }
        

    
        // 6️⃣ **リダイレクト**
        return redirect()->route('itineraries.addList', ['id' => $itinerary->id])
                         ->with('success', 'Itinerary created successfully!');
    }
    
    
    
    
    /**
     * 旅程の追加画面を表示
     */
    public function addList($id, Request $request)
    {
       Log::info("addList 実行", ['itinerary_id' => $id]);
    
        // **旅程データを取得**
        $itinerary = Itinerary::with('prefectures')->findOrFail($id);
    
        // **開始日・終了日がNULLでもエラーにならないように処理**
        $startDate = $itinerary->start_date ? Carbon::parse($itinerary->start_date) : null;
        $endDate = $itinerary->end_date ? Carbon::parse($itinerary->end_date) : null;
    
        // **日数計算（NULL時はデフォルト1日）**
        $days = ($startDate && $endDate) ? $startDate->diffInDays($endDate) + 1 : 1;

            // **Day 1 ～ Day n のリストを作成**
            $daysList = [];
            for ($i = 1; $i <= $days; $i++) {
                $daysList[] = "Day " . $i;
           }
            Log::info("生成された daysList", ['daysList' => $daysList]); // ← 追加

            $regions = Region::with('prefectures')->get();
            $selectedPrefectures = $itinerary->prefectures()->pluck('prefectures.id')->toArray();

            // **AJAXリクエストなら JSON を返す**
            if ($request->ajax()) {
                return response()->json([
                    'days' => $days,
                    'daysList' => $daysList
                ]);
            }

    
        // **ビューにデータを渡して表示**
        return view('itineraries.create_itinerary', compact('itinerary', 'days', 'daysList','regions', 'selectedPrefectures'));

    }


    public function updateDates(Request $request, $id)
{
    try {
        Log::info("✅ updateDates() called", [
            'itinerary_id' => $id, 
            'request_data' => $request->all()
        ]);

        $itinerary = Itinerary::findOrFail($id);
        Log::info("ℹ️ Itinerary found", ['itinerary' => $itinerary]);

        $itinerary->start_date = $request->start_date;
        $itinerary->end_date = $request->end_date;
        $itinerary->save();

        // **開始日だけ変更された場合は現状の日数を維持！**
        if (!$request->end_date) {
            return response()->json([
                'days' => $itinerary->start_date ? 1 : $itinerary->days, // 変更なし
                'daysList' => $itinerary->start_date ? ["Day 1"] : $itinerary->daysList // 変更なし
            ]);
        }

        // **日数計算**
        $days = Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date)) + 1;
        $daysList = [];
        for ($i = 1; $i <= $days; $i++) {
            $daysList[] = "Day " . $i;
        }

        Log::info("✅ Days calculated", [
            'days' => $days, 
            'daysList' => $daysList
        ]);

        return response()->json([
            'days' => $days,
            'daysList' => $daysList
        ]);
    } catch (\Exception $e) {
        Log::error("❌ updateDates() failed", ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Server error'], 500);
    }
}



    public function togglePublic($id)
    {
        $itinerary = Itinerary::findOrFail($id);
        $itinerary->is_public = !$itinerary->is_public;
        $itinerary->save();

        return response()->json(['is_public' => $itinerary->is_public]);
    }

    public function editItinerary($id)
{
    $itinerary = Itinerary::findOrFail($id);
    $spots = ItinerarySpot::where('itinerary_id', $id)
        ->orderBy('visit_day')
        ->orderBy('spot_order')
        ->get();

    return view('create_itinerary', [
        'itinerary' => $itinerary,
        'spots' => $spots,
    ]);
}    
    public function saveItineraryData(Request $request, $id)
    {
        Log::info("🚀 saveItineraryData() called with ID: " . $id);
        Log::info("📝 受信データ:", $request->all());
    
        DB::beginTransaction();
        try {
            // **バリデーション**
            $validated = $request->validate([
                'user_id' => 'required|integer',
                'title' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'is_public' => 'boolean',
                'selected_prefectures' => 'nullable|string', // 🔥 文字列で受け取る（後で JSON をデコード）
            ]);
    
            Log::info("✅ バリデーション成功:", $validated);
    
            // ✅ `selected_prefectures` を JSON デコードし、整数配列に変換
            $selectedPrefectureIds = json_decode($validated['selected_prefectures'], true);
    
            if (!is_array($selectedPrefectureIds)) {
                $selectedPrefectureIds = null; // 🔥 null の場合は更新しない
            } else {
                $selectedPrefectureIds = array_map('intval', $selectedPrefectureIds);
            }
    
            Log::info("✅ 変換後の selected_prefectures:", is_array($selectedPrefectureIds) ? $selectedPrefectureIds : []);
    
            // ✅ **旅程データの更新**
            $itinerary = Itinerary::findOrFail($id);
            $itinerary->update([
                'user_id' => $validated['user_id'], 
                'title' => $validated['title'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'is_public' => $validated['is_public'] ?? false,
            ]);
    
            // ✅ **destination の処理**
            if (!is_null($selectedPrefectureIds)) { 
                if (empty($selectedPrefectureIds)) {
                    // 🔥 空配列の場合は `destination` を削除
                    Log::info("🛑 都道府県データを削除");
                    $itinerary->prefectures()->detach();
                } else {
                    // 🔥 変更がある場合のみ更新
                    Log::info("✅ 都道府県データを更新:", $selectedPrefectureIds);
                    $itinerary->prefectures()->sync($selectedPrefectureIds);
                }
            } else {
                Log::info("🚫 都道府県データは変更なし");
            }
    
            DB::commit();
            Log::info("✅ 旅程保存成功！", ['itinerary_id' => $itinerary->id]);
    
            return response()->json(['message' => 'Itinerary saved successfully'], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("❌ DB 更新エラー:", ['error' => $e->getMessage()]);
        
            return response()->json(['error' => 'Error updating itinerary: ' . $e->getMessage()], 500);
        }
    }
    
    
    
                    // ✅ **スポット情報を保存**
        // ItinerarySpot::where('itinerary_id', $itinerary->id)->delete(); // 既存のスポットを削除
        // foreach ($validated['spots'] as $spot) {
        //     ItinerarySpot::create([
        //         'itinerary_id' => $itinerary->id,
        //         'place_id' => $spot['place_id'],
        //         'spot_order' => $spot['spot_order'],
        //         'visit_time' => $spot['visit_time'] ?? null,
        //         'visit_day' => $spot['visit_day'],
        //     ]);
        // }
        

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
        Log::info("🚀 editDestination 実行: ", ['itinerary_id' => $id]);
    
        $itinerary = Itinerary::find($id);
        if (!$itinerary) {
            Log::error("❌ Itinerary が見つかりませんでした: ID = " . $id);
            return response()->json(['error' => 'Itinerary not found'], 404);
        }
    
        $regions = Region::with('prefectures')->get();
        $selectedPrefectures = $itinerary->prefectures()->pluck('prefectures.id')->toArray();
    
        Log::info("✅ editDestination: Itinerary ID = $id, Prefecture count = " . count($selectedPrefectures));
    
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
    // public function addList(){
    //     return view('itineraries.create_itinerary_header');
    // }

    // show_itinerary - SAKI
    public function showItinerary(){
        return view('itineraries.show_itinerary');
    }
    
}


