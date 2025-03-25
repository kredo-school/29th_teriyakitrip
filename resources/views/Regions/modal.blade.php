@foreach ($regions as $regionId => $regionName)

<!-- {{ $regionName }} のモーダル -->
<div class="modal fade" id="regionModal{{ $regionName }}" tabindex="-1" aria-labelledby="regionModalLabel{{ $regionName }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="regionModalLabel{{ $regionName }}">Select a Prefecture in {{ $regionName }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach (App\Models\Prefecture::where('region_id', $regionId)->get() as $prefecture)
                    <a href="{{ route('regions.overview', ['prefecture_id' => $prefecture->id]) }}" 
                        class="btn d-block my-2"
                        style="background-color: {{ $prefecture->color }}; color: white;">
                        {{ $prefecture->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endforeach
