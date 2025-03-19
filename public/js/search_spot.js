document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ `search_spot.js` 読み込み完了");

    const searchForm = document.getElementById("searchForm");
    const searchBox = document.getElementById("searchBox");
    const searchButton = document.getElementById("searchButton");
    const searchResultsContainer = document.getElementById("searchResults"); // ✅ 追加
    const detailContainer = document.getElementById("spot-detail-container"); // ✅ 追加
    console.log("🔍 詳細エリア取得:", detailContainer);

    if (!searchForm || !searchBox || !searchButton || !searchResultsContainer) {
        console.error("❌ 必須要素が見つかりません。IDを確認してください");
        return;
    }

    // ✅ スクロール処理を追加
    searchResultsContainer.style.overflowY = "auto";
    searchResultsContainer.style.maxHeight = "75vh";

    searchButton.disabled = false;

    // 🔹 Enterキーのリダイレクトを完全に防止し、検索を発火
    searchBox.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // ✅ これでリダイレクトを防ぐ
            console.log("✅ Enterキーで検索を実行");
            performSearch();
        }
    });

    searchForm.addEventListener("submit", function (event) {
        event.preventDefault();
        console.log("✅ 検索フォーム送信");
        performSearch();
    });

    searchButton.addEventListener("click", function () {
        console.log("✅ 検索ボタンがクリックされました");
        performSearch();
    });

    function performSearch() {
        const query = document.getElementById("searchBox").value.trim();
        if (query === "") {
            console.warn("⚠️ 検索クエリが空です"); // ✅ クエリをデバッグ
            return;
        }

        console.log("🚀 APIリクエストURL:", query);

        fetch(`/search-spot?query=${encodeURIComponent(query)}`)
            .then((response) => {
                console.log("✅ HTTPステータスコード:", response.status);
                return response.json();
            })
            .then((data) => {
                console.log("✅ APIレスポンスデータ:", data);

                if (!data.results || data.results.length === 0) {
                    searchResultsContainer.innerHTML = `<p class="text-warning">⚠️ 検索結果なし</p>`;
                    return;
                }

                searchResultsContainer.innerHTML = "";
                data.results.slice(0, 10).forEach((place) => {
                    const placeElement = document.createElement("div");
                    placeElement.className = "search-result-card";
                    placeElement.dataset.placeId = place.place_id;

                    placeElement.innerHTML = `
                        <div class="search-result-img-container">
                                                 <img src="https://via.placeholder.com/100x100?text=Loading" 
                                 alt="Loading Image" 
                                 class="search-result-image" 
                                 data-place-id="${place.place_id}">
                        </div>
                        <div class="search-result-info">
                            <p class="search-result-name">${place.name}</p>
                            <p class="search-result-address">${place.address}</p>
                        </div>
                        <div class="search-result-btn-container">
                            <button class="btn-white-orange add-to-itinerary">Add to Itinerary</button>
                        </div>
                    `;

                    searchResultsContainer.appendChild(placeElement);
                    // 🔹 画像を非同期で取得
                    fetch(`/searchPhoto/${place.place_id}`)
                        .then((response) => response.json())
                        .then((photoData) => {
                            const imageElement = placeElement.querySelector(
                                ".search-result-image"
                            );
                            imageElement.src =
                                photoData.photos.length > 0
                                    ? photoData.photos[0]
                                    : "https://via.placeholder.com/100x100?text=No+Image";
                        })
                        .catch((error) => {
                            console.error("❌ 画像取得エラー:", error);
                        });
                });

                // 重要な処理：詳細エリアを表示
                attachAddToItineraryEvents();

            })
            .catch((error) => {
                console.error("❌ fetch() エラー:", error);
            });
    }

    // ✅ 「Add to Itinerary」ボタンのクリックイベント
    function attachAddToItineraryEvents() {
        document.querySelectorAll(".add-to-itinerary").forEach((button) => {
            button.removeEventListener("click", addToItineraryHandler);
            button.addEventListener("click", addToItineraryHandler);
        });
    }

    function showSpotDetail(place) {
        // ✅ `detailContainer` を関数内で取得
        setTimeout(() => {
            const detailContainer = document.getElementById("spot-detail-container");
            console.log("🔍 detailContainer:", detailContainer);

            if (!detailContainer) {
                console.error(
                    "❌ `spotDetail` が見つかりません。DOM を確認してください"
                );
                return;
            }

            console.log("🟢 詳細情報を表示:", place);

            detailContainer.innerHTML = `
                <div class="detail-card">
                    <img src="${place.photo}" alt="Place Image" class="detail-image">
                    <h2>${place.name}</h2>
                    <p>${place.address}</p>
                    <button class="close-detail">Close</button>
                </div>
            `;

            // ✅ 詳細エリアを表示
            detailContainer.style.display = "block";

            // ✅ 閉じるボタンの動作
            const closeButton = detailContainer.querySelector(".close-detail");
            if (closeButton) {
                closeButton.addEventListener("click", function () {
                    detailContainer.style.display = "none";
                });
            } else {
                console.error("❌ `.close-detail` ボタンが作成されていません！");
            }

        }, 100); // ✅ 100ms 遅延して `spotDetail` を確実に取得
    }

    function addToItineraryHandler(event) {
        event.stopPropagation();
        let spotCard = this.closest(".search-result-card");

        let spotData = {
            place_id: spotCard.dataset.placeId,
            name: spotCard.querySelector(".search-result-name").textContent,
            address: spotCard.querySelector(".search-result-address")
                .textContent,
        };

        console.log("✅ Spot added to itinerary:", spotData);
        addSpotToBody(spotData);

      console.log("✅ Spot added to itinerary:", spotData);
    addSpotToBody(spotData);

    // 🔄 予定画面に切り替える
    switchToItineraryView();
}

    function addSpotToBody(spotData) {
        console.log("✅ `addSpotToBody()` 実行", spotData);

        let selectedDay = sessionStorage.getItem("selectedDay") || "1";
        let itineraryId = document.getElementById("itinerary-data").dataset.itineraryId;
        let storedSpots = JSON.parse(localStorage.getItem(`itinerary_spots_${itineraryId}`)) || [];

        let photoUrl = spotData.photo || "no-image";

        let newOrder = storedSpots.length > 0
            ? Math.max(...storedSpots.map((s) => s.order)) + 1
            : 1;

        let newSpot = {
            place_id: spotData.place_id,
            name: spotData.name,
            address: spotData.address,
            day: parseInt(selectedDay, 10),
            order: newOrder,
            image_url: photoUrl,
        };

        storedSpots.push(newSpot);
        localStorage.setItem(`itinerary_spots_${itineraryId}`, JSON.stringify(storedSpots));

        console.log("✅ スポットが追加されました:", newSpot);

        if (typeof window.renderItineraryBody === "function") {
            console.log("🔄 `renderItineraryBody()` を実行して UI を更新");
            window.renderItineraryBody();
        } else {
            console.error("❌ `renderItineraryBody` が未定義！スクリプトの読み込み順を確認してください");
        }
    }

    // **🔄 MutationObserverで新しいボタンにイベントを適用**
    const observer = new MutationObserver(() => {
        attachAddToItineraryEvents();
    });

    observer.observe(searchResultsContainer, { childList: true, subtree: true });

    console.log("✅ `search_spot.js` 修正適用完了");

    function switchToItineraryView() {
        console.log("🔄 予定表示へ切り替え");
    
        const searchForm = document.getElementById("add-spot-container");
        const itineraryContainer = document.getElementById("add-spot-container");
    
        if (!searchForm || !itineraryContainer) {
            console.error("❌ `add-spot-container` または `day-container` が見つかりません！");
            return;
        }
    
        // 🔹 検索画面を非表示
        searchForm.style.display = "block";
    
        // 🔹 予定画面を表示
        itineraryContainer.style.display = "none";
    
        // ✅ 予定一覧を更新
        if (typeof window.renderItineraryBody === "function") {
            console.log("🔄 `renderItineraryBody()` を実行して UI を更新");
            window.renderItineraryBody();
        } else {
            console.error("❌ `renderItineraryBody` が未定義！");
        }
    }
    
});


