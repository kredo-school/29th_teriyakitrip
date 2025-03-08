@extends('layouts.app')

@section('title', 'Create Itinerary')

@section('content')
<link rel="stylesheet" href="{{ asset('css/itinerary_first_form.css') }}">
<div class="container border rounded-2 p-4">
    <form action="{{ route('itineraries.store') }}" method="POST">
        @csrf

            <!-- Stores the path of the selected `photo`. -->
        <input type="hidden" name="photo_base64" id="photoBase64Input">


            {{-- Title --}}
    <div class="col-12">
        <label for="" class="form-label">Title<span class="text-danger">*</span></label>
        <input type="text" class="form-control mb-3" name="title" required>
    </div>
        <div class="row">
            <!-- Left Side (Destinations) -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label mb-0">Destination <span class="text-danger">*</span></label>
                    <div id="destination-container">
                        <div class="destination-row mt-2">
                            <select class="form-select select-box full-width" name="prefectures[]" onchange="addDestinationSelect(this)">
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
                            <input type="date" class="form-control"  name="start_date">
                        </div>
                        <div class="col-md-6">
                            <input type="date" class="form-control" name="end_date">
                        </div>
                    </div>
                </div>

        <!-- Photo Upload -->
                <div class="mb-3">
                    <label class="form-label">Photo <span class="text-danger">*</span></label>
                    <div class="photo-upload text-center">
                        <div id="photoPlaceholder" class="photo-placeholder border rounded p-4" onclick="openPhotoModal()" >
                            <i id="photoIcon" class="fa-solid fa-image fs-1"></i>
                            <p class="text-muted">Click to select a photo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="button" class="btn-white-orange">Cancel</button>
            <button type="submit" class="btn-white-orange">Create</button>
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
                <button type="button" class="btn-white-orange" data-bs-dismiss="modal">Enter</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/create_itinerary_first_form.js')}}" defer></script>
<script>
    window.destinations = @json($regions);
</script>

@endpush
