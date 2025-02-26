<!-- 画像プレビューモーダル -->
<div class="modal fade" id="photoPreviewModal" tabindex="-1" aria-labelledby="photoPreviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="photoPreviewModalLabel">Photo Preview</h5>
        <button type="button" class="btn-close" id="closePreviewModalButton" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="previewImage" src="" class="img-fluid">
        <div class="d-flex justify-content-center gap-3 mt-3">
          <button type="button" class="btn btn-cancel" id="cancelPreviewButton">Cancel</button>
          <button type="button" class="btn btn-delete" id="deletePreviewButton">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>
