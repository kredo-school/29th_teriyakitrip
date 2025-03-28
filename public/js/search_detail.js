function showSpotDetail(place) {
    console.log("🟢 `showSpotDetail()` 実行:", place);
    const detailContainer = document.getElementById("custom-spot-detail-container"); // ✅ 追加
    console.log("Width:", detailContainer.style.width);
console.log("Position:", detailContainer.style.position);
console.log("Display:", detailContainer.style.display);
console.log("Right:", detailContainer.style.right);


    if (!detailContainer) {
        console.error("❌ `custom-spot-detail-container` が見つかりません。");
        return;
    }

    console.log("🟢 詳細情報を表示:", place);

    setTimeout(() => {
    detailContainer.innerHTML = `
        <div class="custom-spot-detail-content">
            <div class="custom-detail-card">
                <img src="${place.photo}" alt="Place Image">
                <h2>${place.name}</h2>
                <p>${place.address}</p>
                <button id="custom-close-detail-btn" class="close-detail">Close</button>
            </div>
        </div>
    `;

    console.log("🟢 `detail-card` を DOM に追加");

    // ✅ `display: block;` を設定する
    detailContainer.style.display = "block";
    detailContainer.style.visibility = "visible";
    detailContainer.style.right = "0";
    detailContainer.style.top = "80px"; 
    detailContainer.style.width = "30%";
    detailContainer.style.height = "auto";
    detailContainer.style.position = "fixed";
    detailContainer.style.zIndex = "9999";
    detailContainer.style.minHeight = "400px"; // 🔥 必要なら高さを確保

    console.log("🟢 `display: block;` & `right: 0;` を適用");
    console.log("🟢 `display: block;` & `visibility: visible;` を適用");


        // ✅ `F12 → Elements` で `detail-card` が追加されているかチェック
        setTimeout(() => {
            const addedCard = document.querySelector(".custom-detail-card");
            if (addedCard) {
                console.log("✅ `custom-detail-card` が追加されたことを確認:", addedCard);
            } else {
                console.error("❌ `custom-detail-card` が追加されていません。");
            }
        }, 100);


    // ✅ 閉じるボタンの処理
    setTimeout(() => {
        const closeButton = document.getElementById("custom-close-detail-btn");
        if (closeButton) {
            closeButton.addEventListener("click", function () {
                detailContainer.style.display = "none";
                detailContainer.style.visibility = "hidden";
                detailContainer.style.right = "-100%"; // 画面外に移動
                console.log("🟢 `custom-close-detail-btn` がクリックされました");
            });
        } else {
            console.error("❌ `custom-close-detail-btn` ボタンが見つかりません。");
        }
    }, 100);
}, 50);
}
