@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Itinerary</h1>
        <form method="POST" action="{{ route('store_itinerary') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date">
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date">
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is_public" name="is_public" value="1">
                    <label class="form-check-label" for="is_public">Public</label>
                </div>
            </div>
            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" class="form-control-file" id="photo" name="photo">
            </div>
            <!-- 固定Descriptionフィールド -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" readonly>[Day 1] Shakadang Trail, Xiulin Township > Xiaozhuilu Trail > Changchun Shrine > Buluowan > Yan zi kou > Jiu qu dong > Baiyang Trail > 環翠行旅民宿></textarea>
            </div>
            <button type="submit" class="btn custom-btn">Create</button>
        </form>
    </div>
@endsection