@extends('layouts.app')

@section('content')

<!-- CSS -->
<link rel="stylesheet" href="{{ asset('css/my_itinerary.css') }}">

<!-- BootstrapのJavaScriptを読み込む（CDN） -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<div class="container mt-4">
    <!-- タイトルを左寄せ -->
    <h3 class="text-start display-6 fw-bold">My Itinerary</h3>

    <div class="container">
        <!-- タブメニュー -->
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
            <ul class="nav nav-tabs custom-tabs">
                <li class="nav-item">
                    <a class="nav-link active" id="my-itinerary-tab" data-bs-toggle="tab" href="#my-itinerary">My Itinerary</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="shared-itinerary-tab" data-bs-toggle="tab" href="#shared-itinerary">Shared Itinerary</a>
                </li>
            </ul>
            <!-- "+ New Itinerary" ボタン -->
            <button class="btn btn-new-itinerary">+ New Itinerary</button>
        </div>
    
        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="my-itinerary">
                <div class="row mt-3">
                    <div class="col-4"> <!-- My Itinerary 1 -->
                        <div class="card shadow-sm border-0 w-100 rounded-4">
                            <img src="images/sample2.jpg" alt="Itinerary 1" class="element-style rounded-top-4">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> 2025 Okinawa Trip </h6>
                                <div class="d-flex align-items-center">
                                    <img src="images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle" style="width: 40px; height: 40px;">
                                    <span class="ms-2 fw-bold">Toshimi's Japan'</span>
                                    <button class="btn btn-outline-warning btn-sm ms-auto">Follow</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4"> <!-- My Itinerary 2 -->
                        <div class="card shadow-sm border-0 w-100 rounded-4">
                            <img src="images/sample3.jpg" alt="Itinerary 1" class="element-style rounded-top-4">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> 2019 Hokkaido Trip </h6>
                                <div class="d-flex align-items-center">
                                    <img src="images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle" style="width: 40px; height: 40px;">
                                    <span class="ms-2 fw-bold">Toshimi's Japan'</span>
                                    <button class="btn btn-outline-warning btn-sm ms-auto">Follow</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4"> <!-- My Itinerary 3 -->
                        <div class="card shadow-sm border-0 w-100 rounded-4">
                            <img src="images/sample4.jpg" alt="Itinerary 1" class="element-style rounded-top-4">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> 2025 Miyazaki Trip </h6>
                                <div class="d-flex align-items-center">
                                    <img src="images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle" style="width: 40px; height: 40px;">
                                    <span class="ms-2 fw-bold">Toshimi's Japan'</span>
                                    <button class="btn btn-outline-warning btn-sm ms-auto">Follow</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="shared-itinerary">
                <div class="row mt-3">
                    <div class="col-4"> <!-- Shared Itinerary 1 -->
                        <div class="card shadow-sm border-0 w-100 rounded-4">
                            <img src="images/sample2.jpg" alt="Itinerary 1" class="element-style rounded-top-4">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> 2025 Okinawa Trip </h6>
                                <div class="d-flex align-items-center">
                                    <img src="images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle" style="width: 40px; height: 40px;">
                                    <span class="ms-2 fw-bold">Toshimi's Japan'</span>
                                    <button class="btn btn-outline-warning btn-sm ms-auto">Follow</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4"> <!-- Shared Itinerary 2 -->
                        <div class="card shadow-sm border-0 w-100 rounded-4">
                            <img src="images/sample3.jpg" alt="Itinerary 1" class="element-style rounded-top-4">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> 2019 Hokkaido Trip </h6>
                                <div class="d-flex align-items-center">
                                    <img src="images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle" style="width: 40px; height: 40px;">
                                    <span class="ms-2 fw-bold">Toshimi's Japan'</span>
                                    <button class="btn btn-outline-warning btn-sm ms-auto">Follow</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4"> <!-- Shared Itinerary 3 -->
                        <div class="card shadow-sm border-0 w-100 rounded-4">
                            <img src="images/sample4.jpg" alt="Itinerary 1" class="element-style rounded-top-4">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> 2025 Miyazaki Trip </h6>
                                <div class="d-flex align-items-center">
                                    <img src="images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle" style="width: 40px; height: 40px;">
                                    <span class="ms-2 fw-bold">Toshimi's Japan'</span>
                                    <button class="btn btn-outline-warning btn-sm ms-auto">Follow</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="container mt-4">
    <h3 class="text-start">My Itinerary</h3>

    <div class="row">
        @foreach ($itineraries as $itinerary)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <!-- しおりの画像 -->
                    <img src="{{ asset('storage/images/' . $itinerary->image) }}" class="card-img-top" alt="Itinerary Image">

                    <div class="card-body">
                        <!-- しおりのタイトル -->
                        <h5 class="card-title">{{ $itinerary->title }}</h5>
                        
                        <!-- ユーザー情報 -->
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/avatars/' . $itinerary->user->avatar) }}" class="rounded-circle me-2" width="40" height="40" alt="User Avatar">
                            <span class="fw-bold">{{ $itinerary->user->name }}</span>
                        </div>

                        <!-- 詳細ボタン -->
                        <a href="{{ route('itinerary.show', $itinerary->id) }}" class="btn btn-outline-primary mt-2">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div> --}}



@endsection
