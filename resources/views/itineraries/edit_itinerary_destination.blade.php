@extends('layouts.app')

@section('title', 'Edit Destination')

@section('content')
<link rel="stylesheet" href="{{ asset('css/edit_itinerary_destination.css') }}">

<div class="container border rounded-2">
    <!-- Page title with × button for cancel -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="flex-grow-1 text-center fw-bold fs-4">
            Choose your Destination
        </div>
        <button class="btn btn-outline-none fs-2" onclick="history.back()">×</button>
    </div>
    <div class="m-0 p-0 d-flex justify-content-end">
        <span class="small text-danger">*Up to 5 prefectures can be selected</span>
    </div>
    
    <!-- Form -->
    <form action="#" method="POST"> {{-- {{ route('itinerary.updateDestination') }} --}}
        @csrf
        @method('PUT')
 {{-- text-white --}}
        <div class="regions-container">
            @foreach($regions as $region)
                <div class="row mb-4">
                    <!-- Display Regions Name -->
                    <div class="col-2 region-title px-3 py-2 text-white me-3 rounded"
                        style="background-color: {{ $region->color }};">
                        {{ $region->name }}
                    </div>                    

                    <!-- Display Prefecture name by Region group -->
                    <div class="col-9  mx-2 d-flex flex-wrap ">
                        @foreach($region->prefectures as $prefecture)
                            <div class="region-options"> 
                                <label class="form-check-label d-flex align-items-center pe-3">
                                    <input type="checkbox" name="prefectures[]" value="{{ $prefecture->id }}" 
                                        class="form-check-input me-1"
                                        {{ in_array($prefecture->id, old('prefectures', $selectedPrefectures) ?? []) ? 'checked' : '' }}>
                                    <span class="flex-grow-1">{{ $prefecture->name }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Save button -->
        <div class="text-center mt-3">
            <button class="btn-white-orange px-4">Save</button>
        </div>
    </form>
</div>
@endsection