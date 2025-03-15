document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ JavaScript 読み込み完了");

    let dayContainer = document.getElementById("day-container");
    let headerDaysContainer = document.querySelector(".swiper-wrapper");
    let addSpotContainer = document.getElementById("add-spot-container");
    let closeButton = document.getElementById("close-add-spot");
    let body = document.querySelector("body");
    let footer = document.querySelector("footer"); // フッター取得
    let backButton = document.getElementById("back-button"); // 戻るボタン取得
    window.renderItineraryBody = renderItineraryBody;


    if (!dayContainer || !headerDaysContainer || !addSpotContainer) {
        console.error("⚠️ 必須要素が不足しているため、スクリプトを停止します。");
        return;
    }

    function updateBodyDays() {
        console.log("✅ ヘッダーの変更を検知、Bodyを更新");

        setTimeout(() => {
            let dayTabs = document.querySelectorAll(".swiper-slide.day-tab");
            if (dayTabs.length === 0) {
                console.warn("⚠️ Dayタブが見つかりません！");
                return;
            }

            let currentDays = document.querySelectorAll(".day-body");
            let newDayCount = dayTabs.length;

            console.log(`🔍 現在の Day 数: ${currentDays.length}, ヘッダーの Day 数: ${newDayCount}`);

            // ✅ 既存の Day を削除（add-spot-container を消さない）
            document.querySelectorAll(".day-body").forEach(day => day.remove());

            for (let i = 1; i <= newDayCount; i++) {
                let newDayBody = document.createElement("div");
                newDayBody.classList.add("row", "mt-2", "day-body");
                newDayBody.dataset.day = i;
                newDayBody.id = `day-body-${i}`;
                newDayBody.style.display = "flex";

                newDayBody.innerHTML = `
                    <div class="col-2">
                        <div class="day-box text-center text-light">Day ${i}</div>
                    </div>
                    <div class="plus-icon text-center">
                        <button type="button" class="border-0 bg-transparent plus-btn"  data-day="${i}">
                            <i class="fa-regular fa-square-plus"></i>
                        </button>
                    </div>
                `;

   
                document.getElementById("day-container").appendChild(newDayBody);
                console.log(`✅ Body に Day ${i} を追加`);
            }

            // ✅ 「+」ボタンのクリックイベントを適用
            bindAddSpotEvents();
        }, 50);
    }

    function bindAddSpotEvents() {
        if (!addSpotContainer || !footer) {
            console.error("⚠️ 必須要素が見つかりません。スクリプトを停止します。");
            return;
        }

        console.log("🔄 `+` ボタンにイベントをバインド中...");

        // ✅ 「+」ボタンのクリックイベント
        document.querySelectorAll(".plus-icon button").forEach((btn) => {
            btn.addEventListener("click", function () {
                console.log("🟢 `+` ボタンがクリックされました！");
                
                 // ✅ `selectedDay` を保存
            let selectedDay = this.closest(".day-body").dataset.day;
            sessionStorage.setItem("selectedDay", selectedDay);
            console.log(`✅ 選択された Day を保存: ${selectedDay}`);


                // ✅ add-spot-container の表示
                addSpotContainer.style.display = "block";

                // ✅ フッターを非表示
                footer.style.display = "none"; 
                addSpotContainer.style.position = "fixed"; 
                addSpotContainer.style.top = "105px"; 
                addSpotContainer.style.left = "0vw";  
                addSpotContainer.style.width = "50vw";  
                addSpotContainer.style.height = "calc(100vh - 105px)";  
                addSpotContainer.style.backgroundColor = "white"; 
                addSpotContainer.style.zIndex = "9999"; 
                addSpotContainer.style.borderRadius = "10px"; 
                addSpotContainer.style.padding = "1rem"; 
                addSpotContainer.style.boxShadow = "none"; 

                console.log("✅ add-spot-container の表示位置を微調整しました！");
            });
        });

        // ✅ `back-button` のクリックイベント（nullチェックあり）
        if (backButton) {
            backButton.addEventListener("click", function () {
                console.log("🔙 `戻るボタン` がクリックされました！");

                // ✅ add-spot-container を非表示
                addSpotContainer.style.display = "none";

                // ✅ フッターを復活
                footer.style.display = "block"; 
            });
        } else {
            console.warn("⚠️ `back-button` が見つかりません。イベントを適用できません。");
        }
    }

    // ✅ MutationObserver の設定
    let observer = new MutationObserver(mutations => {
        console.log("🔄 MutationObserver が発火しました！");

        observer.disconnect();
        setTimeout(() => {
            updateBodyDays();
            observer.observe(headerDaysContainer, { childList: true });
            console.log("🔄 MutationObserver の後に Body を再描画");
        }, 200);
    });

    observer.observe(headerDaysContainer, { childList: true });

    // ✅ 100ms 後に `bindAddSpotEvents` を適用
    setTimeout(() => {
        bindAddSpotEvents();
    }, 100);


    function renderItineraryBody() {
        console.log("🔄 `renderItineraryBody()` 実行");
    
        let itineraryId = document.getElementById("itinerary-data").dataset.itineraryId;
        if (!itineraryId) {
            console.error("❌ `itineraryId` が見つかりません！");
            return;
        }
    
        let storedSpots = JSON.parse(localStorage.getItem(`itinerary_spots_${itineraryId}`)) || [];
        console.log("🟢 localStorage から取得:", storedSpots);
    
        document.querySelectorAll(".day-body").forEach(container => {
            container.innerHTML = ""; // 各 Day のコンテナをクリア
        });
    
        let spotsByDay = {};
        storedSpots.forEach(spot => {
            if (!spot.day || spot.day === "undefined") {
                console.error("❌ `day` のデータが `undefined` です！修正してください", spot);
                return;
            }
    
            if (!spotsByDay[spot.day]) spotsByDay[spot.day] = [];
            spotsByDay[spot.day].push(spot);
        });
    
        for (let day in spotsByDay) {
            let dayContainer = document.querySelector(`#day-body-${day}`);
            if (!dayContainer) {
                console.warn(`⚠️ Day ${day} のコンテナが見つかりません。新規作成します`);
                let newDayBody = document.createElement("div");
                newDayBody.classList.add("row", "mt-2", "day-body");
                newDayBody.dataset.day = day;
                newDayBody.id = `day-body-${day}`;
                newDayBody.style.display = "flex";
    
                newDayBody.innerHTML = `
                    <div class="col-2">
                        <div class="day-box text-center text-light">Day ${day}</div>
                    </div>
                `;
    
                document.getElementById("day-container").appendChild(newDayBody);
                dayContainer = newDayBody;
            }
    
            console.log(`✅ スポットを追加する Day ${day} のコンテナを取得`, dayContainer);
    
            spotsByDay[day].forEach((spot, index) => {
                let imageSection = "";
                if (spot.image_url && spot.image_url !== "no-image") {
                    imageSection = `<img src="${spot.image_url}" class="spot-image">`;
                } else {
                    imageSection = `<h3 class="no-image-text">No Image</h3>`;
                }
    
                let newSpotElement = document.createElement("div");
                newSpotElement.classList.add("itinerary-spot");
                newSpotElement.dataset.placeId = spot.place_id;
    
                newSpotElement.innerHTML = `
                    <div class="itinerary-spot-header">
                        ${imageSection}
                        <span class="spot-name">${spot.name}</span>
                        <button class="remove-spot" data-index="${index}">❌</button>
                    </div>
                    <p class="spot-address">${spot.address}</p>
                `;
    
                dayContainer.appendChild(newSpotElement);
                console.log(`✅ Day ${day} にスポット追加: ${spot.name}`);
            });
        }
    
        bindRemoveEvents();
    }
    
    

    function bindRemoveEvents() {
        document.querySelectorAll(".remove-spot").forEach(button => {
            button.addEventListener("click", function () {
                let index = this.dataset.index;
                storedSpots.splice(index, 1);
                saveToLocalStorage();
                renderItineraryBody();
            });
        });
    }

    renderItineraryBody();

    document.querySelectorAll(".btn-white-orange").forEach(button => {
        button.addEventListener("click", function () {
            let spotCard = this.closest(".search-result-card");

            let selectedDay = document.querySelector(".day-tab.active").dataset.day; // 🔥 選択中のDay
            let spotData = {
                place_id: spotCard.dataset.placeId,
                name: spotCard.querySelector(".search-result-name").textContent,
                address: spotCard.querySelector(".search-result-address").textContent,
                day: selectedDay, // 🔥 Day 情報を追加
                order: storedSpots.filter(s => s.day === selectedDay).length + 1 // 🔥 そのDayの中の順番
            };

            storedSpots.push(spotData);
            saveToLocalStorage();
            renderItineraryBody();
        });
    });
    function getPhotoUrl(placeId, callback) {
    let request = { placeId: placeId, fields: ["photos"] };
    let service = new google.maps.places.PlacesService(document.createElement("div"));

    service.getDetails(request, function (place, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK && place.photos && place.photos.length > 0) {
            let photoUrl = place.photos[0].getUrl({ maxWidth: 400, maxHeight: 400 });
            callback(photoUrl);
        } else {
            callback("no-image");
        }
    });
}

});
