@extends('layouts.app')

@section('content')
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/my_itinerary.css') }}">

    <!-- Bootstrap 5 の JavaScript (必須) -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}


    <!-- BootstrapのJavaScriptを読み込む（CDN） -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

    <div class="container mt-4">
        <h3 class="text-start display-6 fw-bold">My Itinerary</h3>

        <div class="container">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
                <ul class="nav nav-tabs custom-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="my-itinerary-tab" data-bs-toggle="tab" href="#my-itinerary">
                            My Itinerary
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="shared-itinerary-tab" data-bs-toggle="tab" href="#shared-itinerary">
                            Shared Itinerary
                        </a>
                    </li>
                </ul>
                <button class="btn btn-new-itinerary">+ New Itinerary</button>
            </div>

            <div class="tab-content mt-3 mb-3">
                <div class="tab-pane fade show active" id="my-itinerary">
                    <div class="row mt-3">
                        @forelse($itineraries as $itinerary)
                        <div class="col-4 mb-3"> 
                            <div class="card shadow-sm border-0 w-100 rounded-4 position-relative" style="overflow: hidden;">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/itineraries/images/' . $itinerary->photo) }}" alt="Itinerary Image" class="element-style rounded-top-4 w-100">
                        
                                    <div class="dropdown position-absolute" style="top: 8px; right: 8px;">
                                        <button class="btn btn-more-options dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-itinerary-id="{{ $itinerary->id }}" data-is-public="{{ $itinerary->is_public }}">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </button>
                                        
                                        
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button class="dropdown-item open-privacy-modal" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#privacyModal" 
                                                    data-itinerary-id="{{ $itinerary->id }}"
                                                    data-is-public="{{ $itinerary->is_public }}">
                                                    Privacy
                                                </button>

                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#membersModal">Members</a>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-itinerary-id="{{ $itinerary->id }}">
                                                    Delete
                                                </button>
                                                
                                            </li>
                                        </ul>
                                    </div>
                        
                                    <!-- 非公開の場合に鍵アイコンを表示 -->
                                    @if($itinerary->is_public == 0)
                                        <div class="icon-private" style="top: 8px; left: 8px;">
                                            <i class="fa-solid fa-lock text-white" style="font-size: 20px;"></i>
                                        </div>
                                    @endif

                                </div>
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;">
                                        {{ $itinerary->title }}
                                    </h6>
                                    <p class="text-muted small">
                                        {{ $itinerary->start_date ? \Carbon\Carbon::parse($itinerary->start_date)->format('Y-m-d') : '' }} 
                                        ~ 
                                        {{ $itinerary->end_date ? \Carbon\Carbon::parse($itinerary->end_date)->format('Y-m-d') : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- モーダルを読み込む -->
                        @include('itinerary.modals.privacy') 
                        

                        @empty
                            <p>まだ旅程がありません。</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ここまでがページの内容 -->
    
    <!-- Members Modal -->
    <div class="modal fade" id="membersModal" tabindex="-1" aria-labelledby="membersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="membersModalLabel">Share Itinerary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- タイトルをアイコンの上に表示 -->
                    <h6 class="text-start mb-2" style="font-size: 16px;">Members</h6>

                    <!-- ユーザーアイコンをグリッド状に表示 -->
                    <div class="d-flex flex-wrap gap-2">
                        <img src="images/user-icon.jpg" alt="User 1" class="rounded-circle"
                            style="width: 40px; height: 40px;">
                        <!-- 必要に応じてさらにアイコンを追加 -->
                    </div>

                    <!-- 招待フォーム -->
                    <div class="mt-3">
                        <label for="inviteEmail" class="form-label">Invite to trip</label>
                        <input type="email" class="form-control" id="inviteEmail" placeholder="Enter email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary custom-cancel-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary custom-sendinvite-btn">Send Invite</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 削除モーダル -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Are you sure you want to delete?</p>
                </div>
                <div class="modal-footer">
                    <!-- Yesボタンでフォーム送信 -->
                    <form action="{{ route('myitinerary.destroy', $itinerary->id) }}" method="POST" id="confirm-delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning btn-sm custom-yes-btn">Yes</button>
                    </form>
                    <button type="button" class="btn btn-secondary btn-sm custom-cancel-btn" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
  
    <!-- Leave Confirmation Modal -->
    <div class="modal fade" id="leaveModal" tabindex="-1" aria-labelledby="leaveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered"> <!-- modal-smで小さめに、中央表示 -->
        <div class="modal-content">
            <div class="modal-body">
            <p>Are you sure you want to leave?</p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-warning btn-sm custom-yes-btn">Yes</button>
            <button type="button" class="btn btn-secondary btn-sm custom-cancel-btn" data-bs-dismiss="modal">Cancel</button>
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

<!-- JavaScripts -->
<script src="{{ asset('js/myitinerary.js') }}"></script>

@endsection
