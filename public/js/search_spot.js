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

        console.log("🚀 APIリクエストURL:", url);

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
                            <img src="${
                                place.photo ||
                                "https://via.placeholder.com/100x100?text=No+Image"
                            }" 
                                 alt="Place Image" 
                                 class="search-result-image">
                        </div>
                        <div class="search-result-info">
                            <p class="search-result-name">${place.name}</p>
                            <p class="search-result-address">${
                                place.address
                            }</p>
                        </div>
                        <div class="search-result-btn-container">
                            <button class="btn-white-orange add-to-itinerary">Add to Itinerary</button>
                        </div>
                    `;

                    searchResultsContainer.appendChild(placeElement);
                });

                // ✅ `Add to Itinerary` ボタンのイベントを適用
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
            const detailContainer = document.getElementById("spotDetail");
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
            document
                .querySelector(".close-detail")
                .addEventListener("click", function () {
                    detailContainer.style.display = "none";
                });
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
    }

    console.log("✅ `search_spot.js` 読み込み完了");

    function addSpotToBody(spotData) {
        console.log("✅ `addSpotToBody()` 実行", spotData);

        let selectedDay = sessionStorage.getItem("selectedDay");
        if (!selectedDay) {
            console.warn(
                "⚠️ `selectedDay` が取得できません！デフォルト `1` を使用"
            );
            selectedDay = "1";
        }

        console.log(`✅ 選択された Day: ${selectedDay}`);

        let itineraryId =
            document.getElementById("itinerary-data").dataset.itineraryId;
        let storedSpots =
            JSON.parse(
                localStorage.getItem(`itinerary_spots_${itineraryId}`)
            ) || [];

        // 🔹 `photo` データを取得
        let photoUrl = null;
        if (spotData.photos && spotData.photos.length > 0) {
            try {
                photoUrl = spotData.photos[0].getUrl({
                    maxWidth: 400,
                    maxHeight: 400,
                });
            } catch (error) {
                console.error("❌ `photoUrl` の取得に失敗:", error);
            }
        }

        if (!photoUrl || photoUrl === "undefined") {
            console.warn(
                "⚠️ `photoUrl` が取得できなかったため、`No Image` を設定"
            );
            photoUrl = "no-image";
        }

        let newOrder =
            storedSpots.length > 0
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
        localStorage.setItem(
            `itinerary_spots_${itineraryId}`,
            JSON.stringify(storedSpots)
        );

        console.log("✅ スポットが追加されました:", newSpot);

        if (typeof window.renderItineraryBody === "function") {
            console.log("🔄 `renderItineraryBody()` を実行して UI を更新");
            window.renderItineraryBody();
        } else {
            console.error(
                "❌ `renderItineraryBody` が未定義！スクリプトの読み込み順を確認してください"
            );
        }
    }
});
