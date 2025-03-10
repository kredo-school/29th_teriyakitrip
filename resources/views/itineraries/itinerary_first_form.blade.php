
@extends('layouts.app')

@section('title', 'Create Itinerary')

@section('content')
<link rel="stylesheet" href="{{ asset('css/itinerary_first_form.css') }}">
<div class="container border rounded-2 p-4">
    <form action="{{ route('itineraries.showFirstform') }}" method="post" enctype="multipart/form-data">

        @csrf
            {{-- Title --}}
    <div class="col-12">
        <label for="" class="form-label">Title<span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="title" required>
    </div>
    <div class="row">
        <!-- Left Side (Destinations) -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Destination <span class="text-danger">*</span></label>
                <div id="destination-container">
                    <div class="destination-row mt-2">
                        <select class="form-select select-box full-width" name="prefectures[]" multiple onchange="addDestinationSelect(this)">
                            <option value="">Choose your destination</option>
                            @foreach($regions as $region)
                                @foreach($region->prefectures as $prefecture)
                                    <option value="{{ $prefecture->id }}">
                                        {{ $region->name }} - {{ $prefecture->name }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>                    
        </div>
    </div>

            <!-- Right Side (Date & Photo) -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                    </div>
                </div>

        <!-- Photo Upload -->
                <div class="mb-3">
                    <label class="form-label">Photo <span class="text-danger">*</span></label>
                    <div class="photo-upload text-center">
                        <div id="photoPlaceholder" class="photo-placeholder border rounded p-4" onclick="openPhotoModal()">
                            <i id="photoIcon" class="fa-solid fa-image fs-1"></i>
                            <p class="text-muted">Click to select a photo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="button" class="btn-white-orange">Cancel</button>
            <button type="submit" class="btn-orange">Create</button>
        </div>
    </form>
</div>

<!-- Photo Selection Modal -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Upload your photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <input type="file" id="photoInput" class="form-control mb-3">
                <p class="mt-3">If not, please select your itinerary image below</p>
                <div class="container">
                    <div class="row justify-content-center">               
                        <div class="col-md-2 text-center">
                            <img class="photo-option m-2 rounded img-fluid" src="{{ asset('images/Kesennuma-Miyagi.jpg') }}" style="width: 120px; cursor:pointer;" onclick="selectPhoto('/images/Kesennuma-Miyagi.jpg')">
                        </div>
                        <div class="col-md-2 text-center">
                            <img class="photo-option m-2 rounded img-fluid" src="{{ asset('images/Ueno-Tokyo.jpg') }}" style="width: 120px; cursor:pointer;" onclick="selectPhoto('/images/Ueno-Tokyo.jpg')">
                        </div>
                        <div class="col-md-2 text-center">
                            <img class="photo-option m-2 rounded img-fluid" src="{{ asset('images/Saipan.jpg') }}" style="width: 120px; cursor:pointer;" onclick="selectPhoto('/images/Saipan.jpg')">
                        </div>
                    </div>
                
                    <div class="row justify-content-center mt-3">                        
                        <div class="col-md-2 text-center">
                            <img class="photo-option m-2 rounded img-fluid" src="{{ asset('images/Kyoto.jpg') }}" style="width: 120px; cursor:pointer;" onclick="selectPhoto('/images/Kyoto.jpg')">
                        </div>
                        <div class="col-md-2 text-center">
                            <img class="photo-option m-2 rounded img-fluid" src="{{ asset('images/Odaiba-Tokyo.jpg') }}" style="width: 120px; cursor:pointer;" onclick="selectPhoto('/images/Odaiba-Tokyo.jpg')">
                        </div>
                        <div class="col-md-2 text-center">
                            <img class="photo-option m-2 rounded img-fluid" src="{{ asset('images/Jeepny.png') }}" style="width: 120px; cursor:pointer;" onclick="selectPhoto('/images/Jeepny.png')">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-orange" data-bs-dismiss="modal">Enter</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

/**
 * 📌 Photo モーダルを開く関数
 */
 function openPhotoModal() {
    let photoModalElement = document.getElementById('photoModal');
    if (photoModalElement) {
        let photoModal = new bootstrap.Modal(photoModalElement);
        photoModal.show();
    } 
}

/**
 * 📌 モーダル内の写真をクリックしたときに選択する関数
 * - 選択した画像を `photo-placeholder` 内の画像として表示
 */
function selectPhoto(imageSrc) {
    let selectedPhoto = document.getElementById('selectedPhoto');
    if (selectedPhoto) {
        selectedPhoto.src = imageSrc;
    }

    let photoPlaceholder = document.getElementById('photoPlaceholder');
    if (photoPlaceholder) {
        photoPlaceholder.innerHTML = `<img src="${imageSrc}" alt="Selected Photo" class="img-fluid rounded">`;
    }

    // モーダルを閉じる
    let photoModalElement = document.getElementById('photoModal');
    if (photoModalElement) {
        let photoModal = bootstrap.Modal.getInstance(photoModalElement);
        photoModal.hide();
    }
}

/**
 * 📌 ユーザーがアップロードした画像をプレビュー表示
 */
document.getElementById('photoInput').addEventListener('change', function (event) {
    let file = event.target.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let selectedPhoto = document.getElementById('selectedPhoto');
            if (selectedPhoto) {
                selectedPhoto.src = e.target.result;
            }

            let photoPlaceholder = document.getElementById('photoPlaceholder');
            if (photoPlaceholder) {
                photoPlaceholder.innerHTML = `<img src="${e.target.result}" alt="Uploaded Photo" class="img-fluid rounded">`;
            }
        };
        reader.readAsDataURL(file);
    }
});


let destinations = @json($regions);

/**
 * add destination select box
 */
function addDestinationSelect(selectElement) {
    let container = document.getElementById('destination-container');

    if (selectElement.value !== "" && selectElement.parentElement === container.lastElementChild) {
        let newRow = document.createElement("div");
        newRow.classList.add("destination-row", "mt-2");

        let newSelect = document.createElement("select");
        newSelect.classList.add("form-select", "select-box", "with-button");
        newSelect.setAttribute("multiple", "multiple");
        newSelect.setAttribute("name", "prefectures[]");
        
        let selectOptions = `<option value="">Choose your destination</option>`;
        destinations.forEach(region => {
            region.prefectures.forEach(prefecture => {
                selectOptions += `<option value="${prefecture.id}">${region.name} - ${prefecture.name}</option>`;
            });
        });

        newSelect.innerHTML = selectOptions;
        newSelect.setAttribute("onchange", "addDestinationSelect(this)");

        let removeBtn = document.createElement("button");
        removeBtn.type = "button";
        removeBtn.classList.add("btn", "remove-btn");
        removeBtn.innerHTML = "×";

        removeBtn.addEventListener("click", function () {
            removeDestination(this);
        });

        newRow.appendChild(newSelect);
        newRow.appendChild(removeBtn);
        container.appendChild(newRow);

        updateRemoveButtons();
    }
}

/**
 * after click x button remove destination select box
 * */
function removeDestination(button) {
    let row = button.parentElement;
    let container = document.getElementById('destination-container');
    let rows = document.querySelectorAll('.destination-row');

    if (rows.length > 1) {
        row.remove();
        updateRemoveButtons();
    }
}

/**
 *  control remove buttons visibility based on the number of rows
 */
function updateRemoveButtons() {
    let rows = document.querySelectorAll('.destination-row');
    rows.forEach((row, index) => {
        let removeBtn = row.querySelector(".remove-btn");
        let selectBox = row.querySelector(".select-box");

        if (removeBtn && selectBox) {
            if (index === 0 || index === rows.length - 1) {
                removeBtn.style.display = "none";
                selectBox.classList.remove("with-button");
                selectBox.classList.add("full-width");
            } else {
                removeBtn.style.display = "flex";
                selectBox.classList.remove("full-width");
                selectBox.classList.add("with-button");
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", updateRemoveButtons);
</script>

<style>
.destination-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
}

.select-box {
    width: 100%;
    min-width: 250px;
}

.select-box.with-button {
    width: calc(100% - 50px);
}

.select-box.full-width {
    width: 100%;
}

.remove-btn {
    width: 40px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    background-color: transparent;
    color: black;
    cursor: pointer;
}

.remove-btn:hover {
    background-color: #e9ecef;
}
</style>
@endsection
