document.addEventListener("DOMContentLoaded", function() {
  const privacyModal = document.getElementById('privacyModal');
  const privacyForm = privacyModal.querySelector('form');
  const privateRadio = privacyModal.querySelector('#privacyOption');
  const publicRadio = privacyModal.querySelector('#publicOption');

  document.querySelectorAll('.open-privacy-modal').forEach(button => {
      button.addEventListener('click', function() {
          let itineraryId = this.getAttribute('data-itinerary-id');
          let isPublic = this.getAttribute('data-is-public');

          // フォームのアクションを変更
          privacyForm.action = `/my-itineraries/${itineraryId}/privacy`;

          // ラジオボタンの状態を変更
          if (isPublic == 1) {
              publicRadio.checked = true;
          } else {
              privateRadio.checked = true;
          }
      });
  });
});

document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#deleteModal"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const itineraryId = this.getAttribute('data-itinerary-id');
            const form = document.getElementById('confirm-delete-form');
            form.action = '/my-itineraries/' + itineraryId; // フォームのactionをセット
        });
    });
});
