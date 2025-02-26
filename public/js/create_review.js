document.addEventListener("DOMContentLoaded", function () {
  // 🔹 1. レビュー評価（〇ボタン）のクリック処理
  const stars = document.querySelectorAll(".rating-label i");
  const inputs = document.querySelectorAll(".rating input");
  let currentRating = 0; // 現在の評価値を保存

  stars.forEach((star) => {
      star.addEventListener("click", function () {
          let value = parseInt(star.getAttribute("data-value"), 10);

          // もし同じ値がクリックされたら、選択を解除（0に戻す）
          if (currentRating === value) {
              inputs.forEach(input => input.checked = false); // チェックを外す
              stars.forEach(s => {
                  s.classList.remove("fa-solid");
                  s.classList.add("fa-regular");
              }); // 〇を元に戻す
              currentRating = 0; // リセット
          } else {
              // ラジオボタンの選択状態を変更
              inputs.forEach(input => {
                  if (parseInt(input.value, 10) === value) {
                      input.checked = true;
                  }
              });

              // すべての〇のスタイルをリセット
              stars.forEach(s => {
                  s.classList.remove("fa-solid");
                  s.classList.add("fa-regular");
              });

              // 選択した〇までのものを `fa-solid` に変更
              for (let i = 0; i < value; i++) {
                  stars[i].classList.remove("fa-regular");
                  stars[i].classList.add("fa-solid");
              }

              currentRating = value; // 現在の評価値を更新
          }
      });
  });

});


document.addEventListener("DOMContentLoaded", function () {
  const fileInput = document.getElementById("photoUpload");
  const previewContainer = document.querySelector(".preview-container");


   // 画像プレビュー用のモーダル関連
   const photoPreviewModalElement = document.getElementById("photoPreviewModal");
   const previewImage = document.getElementById("previewImage");
   const cancelPreviewModalButton = document.getElementById("cancelPreviewButton");
   const closePreviewModalButton = document.getElementById("closePreviewModalButton");
   const deletePreviewButton = document.getElementById("deletePreviewButton");

   const photoPreviewModal = new bootstrap.Modal(photoPreviewModalElement);
  let selectedFiles = [];
  let currentDeleteIndex = null; // **現在表示中の画像のインデックス**


  fileInput.addEventListener("change", function (event) {
      handleFileSelection(event);
  });

  function handleFileSelection(event) {
      const files = Array.from(event.target.files);

      // 🔹 すでにアップロードされているファイルの数を確認
      if (selectedFiles.length + files.length > 6) {
        alert("You can only upload up to 6 images.");
        return;
    }

      files.forEach(file => {
          if (selectedFiles.length < 6) {
              selectedFiles.push(file);
          }
      });

      if (selectedFiles.length > 6) {
          alert("You can only upload up to 6 images.");
          selectedFiles = selectedFiles.slice(0, 6);
      }

      displayPreviews();
  }

  function displayPreviews() {
      previewContainer.innerHTML = "";

      let readers = []; // `FileReader` を保存する配列
      let imagesData = []; // 読み込んだデータURLを保存する配列

      selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        readers[index] = reader;

        reader.onload = function (e) {
            imagesData[index] = e.target.result; // 正しい順番でデータを保存

            // すべてのファイルの読み込みが完了したら表示を更新
            if (imagesData.length === selectedFiles.length) {
                updatePreview(imagesData);
            }
        };
          reader.readAsDataURL(file);
      });
    }

    // 🔹 すべての画像が読み込まれた後にプレビューを更新
  function updatePreview(imagesData) {
    previewContainer.innerHTML = "";

    imagesData.forEach((src, index) => {
        const imgWrapper = document.createElement("div");
        imgWrapper.classList.add("position-relative", "d-inline-block");

        const img = document.createElement("img");
        img.src = src;
        img.classList.add("rounded", "me-2", "preview-thumbnail");
        img.style.width = "100px";
        img.style.height = "100px";
        img.style.objectFit = "cover";
        img.style.cursor = "pointer";

        // 画像クリックでモーダル表示
        img.onclick = function () {
            previewImage.src = img.src;
            currentDeleteIndex = index;
            photoPreviewModal.show();
        };

        imgWrapper.appendChild(img);
        previewContainer.appendChild(imgWrapper);
    });
  }


    // **delete image**
    deletePreviewButton.addEventListener("click", function () {
      if (currentDeleteIndex !== null) {
          console.log("Deleted index:", currentDeleteIndex);
          selectedFiles.splice(currentDeleteIndex, 1);  // **配列から削除**
          displayPreviews();  // **プレビューを更新**
          photoPreviewModal.hide(); // **モーダルを閉じる**
          currentDeleteIndex = null; // **削除インデックスをリセット**
      }
  });

    // **close modal**
    closePreviewModalButton.addEventListener("click", function () {
      photoPreviewModal.hide();
  });
    cancelPreviewModalButton.addEventListener("click", function () {
      photoPreviewModal.hide();
  });
});

document.addEventListener("DOMContentLoaded", function () {
  // 仮のデータ（Google API のデータ取得前）
  const restaurantName = document.getElementById("restaurantName");
  const restaurantPhoto = document.getElementById("restaurantPhoto");

  if (restaurantName) {
      restaurantName.innerText = "ABC Cafe"; // 仮の店名
  }

  if (restaurantPhoto) {
      restaurantPhoto.src = "/images/restaurants/default-restaurant.jpg"; // 仮の画像
  }
});

document.addEventListener("DOMContentLoaded", function () {
  if (!itineraries || itineraries.length === 0) return;

  let currentIndex = 0;

  const itineraryPhoto = document.getElementById("itineraryPhoto");
  const itineraryTitle = document.getElementById("itineraryTitle");
  const prevButton = document.querySelector(".prev-itinerary");
  const nextButton = document.querySelector(".next-itinerary");

  function updateItinerary(index) {
      itineraryPhoto.src = itineraries[index].photo;
      itineraryTitle.innerText = itineraries[index].title;
  }

  // 右矢印クリックで次の Itinerary
  nextButton.addEventListener("click", function () {
      currentIndex = (currentIndex + 1) % itineraries.length; // 最後の次は最初に戻る
      updateItinerary(currentIndex);
  });

  // 左矢印クリックで前の Itinerary
  prevButton.addEventListener("click", function () {
      currentIndex = (currentIndex - 1 + itineraries.length) % itineraries.length; // 最初の前は最後に戻る
      updateItinerary(currentIndex);
  });
});




