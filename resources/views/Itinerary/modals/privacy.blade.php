
<!-- Privacy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="privacyModalLabel">Privacy Settings</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <p>Please choose the privacy setting for this itinerary:</p>

              <!-- フォーム -->
              <form action="{{ route('my-itineraries.updatePrivacy', ['id' => $itinerary->id]) }}" method="POST">
                  @csrf
                  @method('PUT')

                  <!-- Privateラジオボタン -->
                  <div class="form-check">
                      <input class="form-check-input" type="radio" name="privacySetting" id="privateOption" value="private"
                          {{ $itinerary->is_public == 0 ? 'checked' : '' }}>
                      <label class="form-check-label" for="privateOption">Private</label>
                  </div>

                  <!-- Publicラジオボタン -->
                  <div class="form-check">
                      <input class="form-check-input" type="radio" name="privacySetting" id="publicOption" value="public"
                          {{ $itinerary->is_public == 1 ? 'checked' : '' }}>
                      <label class="form-check-label" for="publicOption">Public</label>
                  </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>
