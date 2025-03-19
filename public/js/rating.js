document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".rating-label i");

    // 星の選択状態を更新する関数
    function updateStars(value) {
        stars.forEach(star => {
            const starValue = parseInt(star.getAttribute("data-value"), 10);
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
            method: 'POST',
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
    const additionalPhotoInput = document.getElementById('additional-photo-input');
    const existingPhotosContainer = document.getElementById('existing-photos');

    // ファイル選択時に実行する共通の関数
    function handleFileInputChange(event) {
        const files = event.target.files;
        const existingPhotosCount = existingPhotosContainer.querySelectorAll('.review-photo').length;
        const newFilesCount = files.length;
        const totalFiles = existingPhotosCount + newFilesCount;

        // 最大6枚制限
        if (totalFiles > 6) {
            alert("You can only upload up to 6 photos.");
            event.target.value = ''; // アップロードをキャンセル
            return;
        }

        // 選択された画像をプレビュー表示
        Array.from(files).forEach(function (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const newImageContainer = document.createElement('div');
                newImageContainer.classList.add('position-relative', 'd-inline-block', 'image-container');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-fluid', 'rounded', 'review-photo', 'me-2');
                img.style.maxWidth = '150px'; // 画像サイズ調整

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

            reader.readAsDataURL(file);
        });
    }

    // 画像入力の変更イベントに共通の処理を追加
    photoInput.addEventListener('change', handleFileInputChange);
    additionalPhotoInput.addEventListener('change', handleFileInputChange);
});

document.querySelector('form').addEventListener('submit', function (e) {
    e.preventDefault(); // フォームの送信を防止

    const formData = new FormData(this); // フォームのデータを取得
    const files = document.getElementById('photo-input').files; // 選択されたファイルを取得

    // 複数のファイルを追加
    for (let i = 0; i < files.length; i++) {
        formData.append('photos[]', files[i]);
    }

    fetch('/reviews/update', { // 適切なURLに変更
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => console.error('Error:', error));
});
