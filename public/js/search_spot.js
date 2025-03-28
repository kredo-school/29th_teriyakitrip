document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ `search_spot.js` 読み込み完了");

    // ✅ `selectedDay` を `day-container` から取得
    let selectedDay = document.getElementById("day-container")?.dataset.selectedDay || "1";
    console.log(`✅ 初期の selectedDay: ${selectedDay}`);
    sessionStorage.setItem("selectedDay", selectedDay);

        // `itineraryId` の取得処理
    let itineraryData = document.getElementById("itinerary-data");
    let itineraryId = itineraryData ? itineraryData.dataset.itineraryId : null;

    if (!itineraryId) {
        console.error("❌ `itineraryId` が見つかりません！");
    } else {
        console.log("✅ `itineraryId` 取得成功:", itineraryId);
    }

    // ✅ CSRFトークンを取得
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : null;

    if (!csrfToken) {
        console.error("❌ CSRFトークンが見つかりません！");
        return;
    } else {
        console.log("✅ CSRFトークン取得成功");
    }

    const searchForm = document.getElementById("searchForm");
    const searchBox = document.getElementById("searchBox");
    const searchButton = document.getElementById("searchButton");
    const searchResultsContainer = document.getElementById("searchResults");

    if (!searchForm || !searchBox || !searchButton || !searchResultsContainer) {
        console.error("❌ 必須要素が見つかりません。IDを確認してください");
        return;
    }

    // ✅ スクロール処理を追加
    searchResultsContainer.style.overflowY = "auto";
    searchResultsContainer.style.maxHeight = "75vh";
    searchButton.disabled = false;

    // ✅ 検索フォームの送信を統一（Enterキー & ボタンクリック）
    searchForm.addEventListener("submit", function (event) {
        event.preventDefault();
        console.log("✅ 検索フォーム送信");
        performSearch();
    });

    searchButton.addEventListener("click", function () {
        console.log("✅ 検索ボタンがクリックされました");
        searchForm.requestSubmit(); // 🔥 `submit` イベントを発火させる
    });

    function performSearch() {
        const query = searchBox.value.trim();
        if (query === "") {
            console.warn("⚠️ 検索クエリが空です");
            return;
        }

        if (!itineraryId) {
            console.error("❌ `itineraryId` が未定義のため、フォームの `action` を設定できません！");
            return;
        }        

        console.log("🚀 APIリクエストURL:", query);

        fetch(`/search-spot?query=${encodeURIComponent(query)}`)
            .then((response) => response.json())
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
        <form action="/itineraries/${itineraryId}/day/${selectedDay}/save/spots" method="POST">
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="place_id" value="${place.place_id}">
            <input type="hidden" name="spot_order" value="1">
            <input type="hidden" name="visit_day" value="${selectedDay}">
            <button type="submit" class="btn-white-orange">Add to Itinerary</button>
        </form>
    </div>
`;


                    searchResultsContainer.appendChild(placeElement);
                });
                        // ✅ ボタンのクリックイベントを追加
                        document.querySelectorAll(".add-to-itinerary").forEach(button => {
                            button.addEventListener("click", function (event) {
                                event.preventDefault(); // 🔥 フォーム送信を防ぐ
                                saveSpot(this.dataset.placeId);
                            });
                        });
                    })
                    .catch((error) => {
                        console.error("❌ fetch() エラー:", error);
                    });
            }
        
            function saveSpot(placeId) {
                if (!placeId || !itineraryId || !selectedDay) {
                    console.error("❌ データ不足: 保存できません");
                    return;
                }
            
                console.log(`🚀 スポットを保存: ${placeId}, Day: ${selectedDay}`);
            
                fetch(`/itineraries/${itineraryId}/day/${selectedDay}/save/spots`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({
                        place_id: placeId,
                        spot_order: 1,
                        visit_day: selectedDay
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`❌ サーバーエラー: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("✅ スポット保存成功:", data);
                    console.log("🔄 3秒後にページをリロード");
            
                    setTimeout(() => {
                        window.location.href = `/itineraries/${itineraryId}/addList/create_itinerary`;
                    }, 2000); // 🔥 3秒待ってからページ遷移
                })
                .catch(error => {
                    console.error("❌ スポット保存エラー:", error);
                });
            }            
        
});

