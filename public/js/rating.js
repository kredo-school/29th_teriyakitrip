document.addEventListener("DOMContentLoaded", function () {
  const stars = document.querySelectorAll(".rating-label i");

  // 星の選択状態を更新する関数
  function updateStars(value) {
      stars.forEach(star => {
          const starValue = parseInt(star.getAttribute("data-value"), 10);
          // クリックした星より前の星はオレンジ、それ以降の星はグレーにする
          if (starValue <= value) {
              star.classList.add("selected");
              star.classList.remove("unselected");
          } else {
              star.classList.remove("selected");
              star.classList.add("unselected");
          }
      });
  }

  // 初期状態で選択された評価を反映
  const initialRating = document.querySelector(".rating input:checked");
  if (initialRating) {
      updateStars(parseInt(initialRating.value, 10));
  }

  // クリック時に評価を更新
  stars.forEach(star => {
      star.addEventListener("click", function () {
          const value = parseInt(this.getAttribute("data-value"), 10);
          updateStars(value);
          // ラジオボタンを更新
          document.getElementById("star" + value).checked = true;
      });
  });
});

document.addEventListener('DOMContentLoaded', function () {
    let deletePhotoId = null;
    const deletePreviewButton = document.getElementById('deletePreviewButton');
    const cancelPreviewButton = document.getElementById('cancelPreviewButton');
    const closePreviewModalButton = document.getElementById('closePreviewModalButton');
    const previewImage = document.getElementById('previewImage');
    const photoPreviewModal = new bootstrap.Modal(document.getElementById('photoPreviewModal'));
    
    // すべての削除ボタンにクリックイベントを設定
    document.querySelectorAll('.delete-photo').forEach(button => {
        button.addEventListener('click', function () {
            deletePhotoId = this.getAttribute('data-photo-id'); // 削除する画像IDを取得
            previewImage.src = this.previousElementSibling.src; // モーダルに画像を表示
            photoPreviewModal.show(); // モーダルを表示
        });
    });

    // 「Cancel」ボタンでモーダルを閉じる
    cancelPreviewButton.addEventListener('click', function () {
        deletePhotoId = null;
        photoPreviewModal.hide();
    });

    // 「×」ボタンでモーダルを閉じる
    closePreviewModalButton.addEventListener('click', function () {
        deletePhotoId = null;
        photoPreviewModal.hide();
    });

    // 「Delete」ボタンを押したときの処理
    deletePreviewButton.addEventListener('click', function () {
        if (!deletePhotoId) return;
        
        fetch(`/reviews/photo/delete/${deletePhotoId}`, {
            method: 'POST', // LaravelのDELETEを許可するためにPOSTを使用
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ _method: 'DELETE' }) // LaravelでDELETEリクエストに変換
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`[data-photo-id="${deletePhotoId}"]`).closest('.image-container').remove(); // UIから削除
                photoPreviewModal.hide(); // モーダルを閉じる
            } else {
                alert('Failed to delete the photo. Please try again.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const photoInput = document.getElementById('photo-input');
    const existingPhotosContainer = document.getElementById('existing-photos');

    photoInput.addEventListener('change', function (event) {
        const files = event.target.files;

        // 選択された画像をプレビュー表示
        Array.from(files).forEach(function (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                // 新しい画像のコンテナ作成
                const newImageContainer = document.createElement('div');
                newImageContainer.classList.add('position-relative', 'd-inline-block', 'image-container');

                // 画像タグ作成
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-fluid', 'rounded', 'review-photo', 'me-2');
                img.style.maxWidth = '150px'; // 画像サイズ調整

                // 削除ボタン
                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute', 'top-0', 'end-0');
                deleteButton.innerText = '×';

                // 削除ボタンのイベント
                deleteButton.addEventListener('click', function () {
                    newImageContainer.remove();
                });

                // コンテナに追加
                newImageContainer.appendChild(img);
                newImageContainer.appendChild(deleteButton);

                // 既存の写真リストに追加
                existingPhotosContainer.appendChild(newImageContainer);
            };

            // ファイルを読み込んでプレビューを表示
            reader.readAsDataURL(file);
        });
    });
});

document.getElementById('photo-input').addEventListener('change', function(event) {
    let fileInput = event.target;
    let existingPhotos = document.querySelectorAll('.review-photo').length;
    let newFiles = fileInput.files.length;
    let total = existingPhotos + newFiles;

    if (total > 6) {
        alert("You can only upload up to 6 photos.");
        fileInput.value = ""; // アップロードをキャンセル
    }
});
