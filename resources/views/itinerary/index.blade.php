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
                        <a class="nav-link active" id="my-itinerary-tab" data-bs-toggle="tab" href="#my-itinerary">My
                            Itinerary</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="shared-itinerary-tab" data-bs-toggle="tab" href="#shared-itinerary">Shared
                            Itinerary</a>
                    </li>
                </ul>
                <!-- "+ New Itinerary" ボタン -->
                <button class="btn btn-new-itinerary">+ New Itinerary</button>
            </div>

            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="my-itinerary">
                    <div class="row mt-3">
                        <div class="col-4"> <!-- My Itinerary 1 -->
                            <div class="card shadow-sm border-0 w-100 rounded-4 position-relative"
                                style="overflow: hidden;">
                                <!-- 画像エリア -->
                                <div class="position-relative">
                                    <img src="images/sample8.jpg" alt="Itinerary 1"
                                        class="element-style rounded-top-4 w-100">
                                    <!-- ドロップダウン付きの3点ボタン -->
                                    <div class="dropdown position-absolute" style="top: 8px; right: 8px;">
                                        <button class="btn btn-more-options dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <!-- Privacyをクリックするとプライバシーモーダルを表示 -->
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#privacyModal">Privacy</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#membersModal">Members</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</a>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                                <!-- カードの本文 -->
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;">2025 Okinawa Trip</h6>
                                    <div class="d-flex align-items-center">
                                        <p>本文</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-4"> <!-- My Itinerary 2 -->
                            <div class="card shadow-sm border-0 w-100 rounded-4">
                                <!-- 画像エリア -->
                                <div class="position-relative">
                                    <img src="images/sample3.jpg" alt="Itinerary 1"
                                        class="element-style rounded-top-4 w-100">

                                    <!-- ドロップダウン付きの3点ボタン -->
                                    <div class="dropdown position-absolute top-0 end-0 p-2">
                                        <button class="btn btn-more-options dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <!-- Membersをクリックするとモーダルを表示 -->
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#membersModal">Privacy</a></li>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#membersModal">Members</a></li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal">Delete</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- カードの本文 -->
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> 2019 Hokkaido Trip </h6>
                                    <div class="d-flex align-items-center">
                                        <p>本文</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4"> <!-- My Itinerary 3 -->
                            <div class="card shadow-sm border-0 w-100 rounded-4 position-relative">
                                <!-- 画像エリア -->
                                <div class="position-relative">
                                    <img src="images/sample8.jpg" alt="Itinerary 1" class="element-style rounded-top-4 w-100">
                                  
                                    <!-- ドロップダウン付きの3点ボタン -->
                                    <div class="dropdown position-absolute top-0 end-0 p-2">
                                      <button class="btn btn-more-options dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis"></i>
                                      </button>
                                      <!-- ここにドロップダウンメニューのコードを挿入 -->
                                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                          <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</a>
                                        </li>
                                        <!-- 他のメニュー項目があればここに追加 -->
                                      </ul>
                                    </div>
                                  </div>
                                  
                                <!-- カードの本文 -->
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> 2025 Miyazaki Trip </h6>
                                    <div class="d-flex align-items-center">
                                        <p>本文</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="shared-itinerary">
                <div class="row mt-3">
                    <div class="col-4"> <!-- Shared Itinerary 1 -->
                        <div class="card shadow-sm border-0 w-100 rounded-4 position-relative">
                            <!-- 画像エリア -->
                            <div class="position-relative">
                                <img src="images/sample8.jpg" alt="Itinerary 1"
                                    class="element-style rounded-top-4 w-100">

                                <!-- ドロップダウン付きの3点ボタン -->
                                <div class="dropdown position-absolute top-0 end-0 p-2">
                                    <button class="btn btn-more-options dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <!-- Membersをクリックするとモーダルを表示 -->
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#membersModal">Members</a></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#leaveModal">Leave</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- カードの本文 -->
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> 2025 Okinawa Trip </h6>
                                <div class="d-flex align-items-center">
                                    <p>本文</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-4"> <!-- Shared Itinerary 2 -->
                        <div class="card shadow-sm border-0 w-100 rounded-4 position-relative">
                            <!-- 画像エリア -->
                            <div class="position-relative">
                                <img src="images/sample2.jpg" alt="Itinerary 1"
                                    class="element-style rounded-top-4 w-100">

                                <!-- ユーザーアイコンと3点ボタンを横並びに配置 -->
                                <div class="d-flex align-items-center position-absolute top-0 end-0 p-2"
                                    style="gap: 8px;">
                                    <!-- シェアしたユーザーのアイコン -->
                                    <img src="images/user-icon.jpg" alt="シェアしたユーザー" class="shared-user-icon">

                                    <!-- 3点ボタン -->
                                    <button class="btn btn-more-options">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- カードの本文 -->
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> 2025 Fuji Trip </h6>
                                <div class="d-flex align-items-center">
                                    <p>本文</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-4"> <!-- Shared Itinerary 3 -->
                        <div class="card shadow-sm border-0 w-100 rounded-4 position-relative">
                            <!-- 画像エリア -->
                            <div class="position-relative">
                                <img src="images/sample3.jpg" alt="Itinerary 1"
                                    class="element-style rounded-top-4 w-100">

                                <!-- ユーザーアイコンと3点ボタンを横並びに配置 -->
                                <div class="d-flex align-items-center position-absolute top-0 end-0 p-2"
                                    style="gap: 8px;">
                                    <!-- シェアしたユーザーのアイコン -->
                                    <img src="images/user-icon.jpg" alt="シェアしたユーザー" class="shared-user-icon">

                                    <!-- 3点ボタン -->
                                    <button class="btn btn-more-options">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- カードの本文 -->
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> 2023 Hokkaido Trip </h6>
                                <div class="d-flex align-items-center">
                                    <p>本文</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- ここまでがページの内容 -->

    <!-- Privacy Modal をここに配置 -->
    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> <!-- ここに modal-dialog-centered を追加 -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="privacyModalLabel">Privacy Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please choose the privacy setting for this itinerary:</p>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="privacySetting" id="privacyOption"
                            value="privacy">
                        <label class="form-check-label" for="privacyOption">
                            Privacy
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="privacySetting" id="publicOption"
                            value="public">
                        <label class="form-check-label" for="publicOption">
                            Public
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary custom-close-btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn save-changes-btn" data-bs-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered"> <!-- modal-smで小さめに、中央表示 -->
      <div class="modal-content">
        <div class="modal-body">
          <p>Are you sure you want to delete?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning btn-sm custom-yes-btn">Yes</button>
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



    </body>


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
