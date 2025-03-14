<form action="{{ route('restaurant-reviews.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="place_id" value="{{ $restaurant['place_id'] }}">
    
    <label class="mt-4 mb-2 fw-bold">Rate this restaurant <span class="text-danger">*</span></label>
    <div class="rating mb-4">
      @for ($i = 1; $i <= 5; $i++)
          <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="d-none" required>
          <label for="star{{ $i }}" class="rating-label">
              <i class="fa-regular fa-circle" data-value="{{ $i }}"></i>
          </label>
      @endfor
    </div>
  
    <div class="mb-4">
        <label for="title" class="form-label fw-bold">Title your review <span class="text-danger">*</span></label>
        <input type="text" name="title" id="title" class="form-control" required>
    </div>
  
    <div class="mb-4">
        <label for="body" class="form-label fw-bold">Your review <span class="text-danger">*</span></label>
        <textarea name="body" id="body" class="form-control" rows="5" required></textarea>
    </div>
  
    <div class="mb-4">
        <label for="photoUpload" class="form-label fw-bold">Upload your photos</label>
        
        <!-- file -->
        <input type="file" name="photos[]" id="photoUpload" multiple accept="image/*" class="form-control">
    
        <p class="text-muted">Acceptable format: jpeg, png, jpg, gif only. Max file is 1048kb</p>
    
        <!-- preview container-->
        <div class="preview-container d-flex flex-wrap gap-2"></div>
    </div>
  
    <button type="submit" class="btn btn-submit px-5 me-3">Submit</button>
    <button type="submit" class="btn btn-cancel px-5">Cancel</button>
  </form>
  
