document.addEventListener("DOMContentLoaded", function () {

  let reviews = document.querySelectorAll(".review-item-show.d-none");
  let loadMoreButton = document.getElementById("loadMore");
  let itemsPerClick = 5; // クリックごとに表示する件数
  let currentIndex = 0;

  loadMoreButton.addEventListener("click", function () {
      let remainingItems = Array.from(reviews).slice(currentIndex, currentIndex + itemsPerClick);

      remainingItems.forEach(item => {
          item.classList.remove("d-none"); // 非表示を解除
      });

      currentIndex += itemsPerClick;

      // すべて表示されたらボタンを非表示
      if (currentIndex >= reviews.length) {
          loadMoreButton.style.display = "none";
      }
  });
});

document.addEventListener("DOMContentLoaded", function () {
    let readMoreButtons = document.querySelectorAll(".read-more");
    let readLessButtons = document.querySelectorAll(".read-less");

    readMoreButtons.forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            let reviewBody = this.closest(".review-body");
            reviewBody.querySelector(".short-text").classList.add("d-none");
            reviewBody.querySelector(".full-text").classList.remove("d-none");
            this.classList.add("d-none"); // Read more を隠す
            reviewBody.querySelector(".read-less").classList.remove("d-none"); // Read less を表示
        });
    });

    readLessButtons.forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            let reviewBody = this.closest(".review-body");
            reviewBody.querySelector(".short-text").classList.remove("d-none");
            reviewBody.querySelector(".full-text").classList.add("d-none");
            this.classList.add("d-none"); // Read less を隠す
            reviewBody.querySelector(".read-more").classList.remove("d-none"); // Read more を再表示
        });
    });

    // ⭐ モーダル（画像プレビュー）処理 ⭐
    let previewModalElement = document.getElementById("photoPreviewModal");
    if (!previewModalElement) {
        console.error("photoPreviewModal が見つかりません！");
        return;
    }

    let previewModal = new bootstrap.Modal(previewModalElement);
    let previewImage = document.getElementById("previewImage");

    // 画像クリックでモーダルを開く
    document.querySelectorAll(".review-photo").forEach(photo => {
        photo.addEventListener("click", function () {
            console.log("Image clicked:", this.src); // イベントが発火するか確認
            previewImage.src = this.src; // クリックした画像のURLをセット
            previewModal.show();
        });
    });
});
