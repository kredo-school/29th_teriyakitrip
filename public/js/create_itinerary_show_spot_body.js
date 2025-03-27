create_itinerary_show_body.js from backend part 4

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

    // if (!dayContainer || !headerDaysContainer || !addSpotContainer) {
    //     console.error(
    //         "⚠️ 必須要素が不足しているため、スクリプトを停止します。"
    //     );
    //     return;
    // }

    function updateDates() {
        console.log("✅ updateDates() が実行された");
    
        let startDate = new Date(startDateInput.value);
        let endDate = new Date(endDateInput.value);
    
        if (endDate < startDate) {
            console.warn("❌ 終了日が開始日より前になっています。修正します。");
            endDateInput.value = startDateInput.value;
            endDate = new Date(endDateInput.value);
        }
    
        fetch(`/itineraries/${itineraryId}/update-dates`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({
                start_date: startDateInput.value,
                end_date: endDateInput.value,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log("✅ fetch response:", data);
    
                document.getElementById("trip_days").innerText =
                    data.days + " days";
    
                let daysContainer = document.querySelector(".swiper-wrapper");
                daysContainer.innerHTML = `<div class="swiper-slide active-tab overview-margin">Overview</div>`;
    
                data.daysList.forEach((day, index) => {
                    let newDayElement = document.createElement("div");
                    newDayElement.classList.add("swiper-slide", "day-tab");
                    newDayElement.dataset.day = index + 1;
                    newDayElement.innerHTML = `
                        <i class="fa-solid fa-arrow-right-arrow-left float-start mt-1"></i> 
                        ${day}
                        <i class="fa-solid fa-trash-can float-end mt-1 remove-day"></i>
                    `;
                    daysContainer.appendChild(newDayElement);
                });
    
                let addDayElement = document.createElement("div");
                addDayElement.classList.add("swiper-slide");
                addDayElement.id = "add-day";
                addDayElement.innerHTML = `<i class="fa-solid fa-plus"></i>`;
                daysContainer.appendChild(addDayElement);
    
                console.log("✅ 全 `Days` を追加:", data.daysList);
            })
            .catch((error) => console.error("❌ Error:", error));
    }
    
    function bindAddSpotEvents() {
        // if (!addSpotContainer || !footer) {
        //     console.error(
        //         "⚠️ 必須要素が見つかりません。スクリプトを停止します。"
        //     );
        //     return;
        // }

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

                console.log(
                    "✅ add-spot-container の表示位置を微調整しました！"
                );
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
            console.warn(
                "⚠️ `back-button` が見つかりません。イベントを適用できません。"
            );
        }
    }

    // ✅ MutationObserver の設定
    let observer = new MutationObserver((mutations) => {
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
    
        let itineraryId =
            document.getElementById("itinerary-data").dataset.itineraryId;
        if (!itineraryId) {
            console.error("❌ `itineraryId` が見つかりません！");
            return;
        }
    
        let storedSpots =
            JSON.parse(localStorage.getItem(`itinerary_spots_${itineraryId}`)) || [];
        console.log("🟢 localStorage から取得:", storedSpots);
    
        document.querySelectorAll(".day-body").forEach((container) => {
            container.remove(); // 各 Day のコンテナを削除
        });
    
        // 🔹 すべての Day を取得し、空でも表示する
        let daysList = JSON.parse(localStorage.getItem(`daysList_itinerary_${itineraryId}`)) || [1, 2, 3];
    
        daysList.forEach((day) => {
            let dayContainer = document.createElement("div");
            dayContainer.classList.add("row", "mt-2", "day-body");
            dayContainer.dataset.day = day;
            dayContainer.id = `day-body-${day}`;
            dayContainer.style.display = "flex";
    
            dayContainer.innerHTML = `
                <div class="col-2">
                    <div class="day-box text-center text-light">Day ${day}</div>
                </div>
            `;
    
            document.getElementById("day-container").appendChild(dayContainer);
            console.log(`✅ Day ${day} を追加`);
    
            if (storedSpots.length > 0) {
                storedSpots.forEach((spot) => {
                    if (spot.day == day) {
                        let newSpotElement = document.createElement("div");
                        newSpotElement.classList.add("itinerary-spot");
                        newSpotElement.dataset.placeId = spot.place_id;
    
                        newSpotElement.innerHTML = `
                            <div class="itinerary-spot-header">
                                <span class="spot-name">${spot.name}</span>
                                <p class="spot-address">${spot.address}</p>
                            </div>
                        `;
    
                        dayContainer.appendChild(newSpotElement);
                        console.log(`✅ Day ${day} にスポット追加: ${spot.name}`);
                    }
                });
            }
        });
    
        bindRemoveEvents();
    }
    

    function bindRemoveEvents() {
        document.querySelectorAll(".remove-spot").forEach((button) => {
            button.addEventListener("click", function () {
                let index = this.dataset.index;
                storedSpots.splice(index, 1);
                saveToLocalStorage();
                renderItineraryBody();
            });
        });
    }

    renderItineraryBody();

    document.querySelectorAll(".btn-white-orange").forEach((button) => {
        button.addEventListener("click", function () {
            let spotCard = this.closest(".search-result-card");

            let selectedDay =
                document.querySelector(".day-tab.active").dataset.day; // 🔥 選択中のDay
            let spotData = {
                place_id: spotCard.dataset.placeId,
                name: spotCard.querySelector(".search-result-name").textContent,
                address: spotCard.querySelector(".search-result-address")
                    .textContent,
                day: selectedDay, // 🔥 Day 情報を追加
                order:
                    storedSpots.filter((s) => s.day === selectedDay).length + 1, // 🔥 そのDayの中の順番
            };

            storedSpots.push(spotData);
            saveToLocalStorage();
            renderItineraryBody();
        });
    });

    function getPhotoUrl(placeId, callback) {
        let request = { placeId: placeId, fields: ["photos"] };
        let service = new google.maps.places.PlacesService(
            document.createElement("div")
        );

        service.getDetails(request, function (place, status) {
            if (
                status === google.maps.places.PlacesServiceStatus.OK &&
                place.photos &&
                place.photos.length > 0
            ) {
                let photoUrl = place.photos[0].getUrl({
                    maxWidth: 400,
                    maxHeight: 400,
                });
                callback(photoUrl);
            } else {
                callback("no-image");
            }
        });
    }


    function adjustAddSpotButton() {
        document.querySelectorAll(".add-spot-btn").forEach((btn) => {
            btn.style.display = "block";
            btn.style.width = "100%";
            btn.style.marginTop = "10px";
        });
    }

    function updateSpotImages() {
        document.querySelectorAll(".itinerary-spot img").forEach((img) => {
            if (!img.src || img.src.includes("placeholder")) {
                img.style.display = "none";
            }
        });
    }

    adjustAddSpotButton();
    updateSpotImages();
});
