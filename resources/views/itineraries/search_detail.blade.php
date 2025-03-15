@push('styles')
<link rel="stylesheet" href="{{ asset('css/search_detail.css') }}?v={{ time() }}">
@endpush
 
 <!-- ✅ 詳細表示エリア -->
 <div id="custom-spot-detail-container" class="custom-spot-details-container" style="display: none;">
    <p>ここに詳細情報が表示されます</p>
</div>

@push('scripts')
<script src="{{ asset('js/search_detail.js') }}" defer></script>
@endpush