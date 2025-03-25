document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ JavaScript が読み込まれました");

    var swiper = new Swiper(".swiper-container", {
        slidesPerView: "auto",
        spaceBetween: 10,
        freeMode: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    // タブのアクティブ表示を切り替える
    document.querySelectorAll(".swiper-slide").forEach((tab) => {
        tab.addEventListener("click", function () {
            document
                .querySelectorAll(".swiper-slide")
                .forEach((t) => t.classList.remove("active-tab"));
            this.classList.add("active-tab");
        });
    });

    // Laravelの変数を取得
    let itineraryIdElem = document.getElementById("itinerary-data");
    if (!itineraryIdElem) {
        console.error("❌ itinerary-data が見つかりません");
        return;
    }
    let itineraryId = itineraryIdElem.dataset.itineraryId;
    console.log("🟢 確認: itineraryId =", itineraryId);

    let destinationBtn = document.getElementById("destination-btn");
    let saveDestinationBtn = document.getElementById("save-destination");
    let modalElem = document.getElementById("itineraryModal");

    if (!destinationBtn || !saveDestinationBtn || !modalElem) {
        console.error("❌ 必須要素が不足しています");
        return;
    }

    console.log("🟢 Saveボタン要素:", saveDestinationBtn);

    let modalInstance = new bootstrap.Modal(modalElem);

    // Destinationボタンをクリックでモーダルを表示
    destinationBtn.addEventListener("click", function () {
        console.log("✅ Destinationボタンがクリックされた");
        modalInstance.show();
    });

    // 🔹 Saveボタンが押されたときの処理
    saveDestinationBtn.addEventListener("click", function () {
        console.log("✅ Save ボタンがクリックされました！");

        let selectedPrefectures = [];
        let selectedPrefectureIds = [];

        document
            .querySelectorAll('input[name="selected_prefectures[]"]:checked')
            .forEach((checkbox) => {
                let name = checkbox
                    .closest("label")
                    .querySelector("span")
                    .textContent.trim();
                let color = checkbox.getAttribute("data-color");

                selectedPrefectures.push({
                    id: parseInt(checkbox.value, 10), // ✅ integer に変換
                    name: name,
                    color: color,
                });
                selectedPrefectureIds.push(parseInt(checkbox.value, 10)); // 🔥 IDのみ格納
            });

        console.log("🟢 保存するデータ:", selectedPrefectures);
        console.log("🟢 送信する都道府県IDリスト:", selectedPrefectureIds);

        if (selectedPrefectureIds.length === 0) {
            alert("⚠️ 少なくとも1つの都道府県を選択してください！");
            return;
        }

        // ✅ `localStorage` に選択した都道府県を保存（🔥 これが即時表示に必要）
        localStorage.setItem(
            `selectedDestinations_itinerary_${itineraryId}`,
            JSON.stringify(selectedPrefectures)
        );

        // ✅ hidden input に値をセットする（空にならないように対策）
        let hiddenInput = document.getElementById("selected-prefectures");
        if (hiddenInput) {
            hiddenInput.value = JSON.stringify(selectedPrefectureIds);
            console.log("🟢 hidden input の値:", hiddenInput.value);
        } else {
            console.error("❌ hidden input が見つかりません！");
        }

        // ✅ 選択リストを即時更新
        updateDestinationList();

        console.log("✅ 選択リストを即時更新しました！");

        // ✅ モーダルを閉じる（変更なし）
        setTimeout(() => {
            modalElem.classList.remove("show");
            document.body.classList.remove("modal-open");
            document
                .querySelectorAll(".modal-backdrop")
                .forEach((el) => el.remove());
            modalInstance.hide();
            console.log("✅ モーダルを閉じました！");
        }, 200);
    });

    //  Doneボタン押下後の保存処理
    doneButton.addEventListener("click", function () {
        console.log("✅ Doneボタンがクリックされました");
    
        let itineraryId = document.getElementById("itinerary-data").dataset.itineraryId;
        let itineraryTitle = document.getElementById("itinerary-title").value.trim();
        let startDate = document.getElementById("start_date").value;
        let endDate = document.getElementById("end_date").value;
    
        // ✅ `selected_prefectures` の値を取得し、`integer` 配列に変換
        let selectedPrefectureElements = document.querySelectorAll(".prefecture-checkbox:checked");
        let selectedPrefectures = Array.from(selectedPrefectureElements).map(el => parseInt(el.value, 10));
    
        // ✅ `hidden input` の値を更新する
        let hiddenInput = document.getElementById("selected-prefectures");
        if (hiddenInput) {
            hiddenInput.value = selectedPrefectures.length > 0 ? JSON.stringify(selectedPrefectures) : JSON.stringify([]);
            console.log("🟢 hiddenInput の値:", hiddenInput.value);
        } else {
            console.error("❌ hidden input が見つかりません！");
        }
    
        console.log("📤 送信前の旅行情報:", {
            itinerary_id: itineraryId,
            title: itineraryTitle,
            start_date: startDate,
            end_date: endDate,
            selected_prefectures: selectedPrefectures,
        });
    
        if (!itineraryTitle || !startDate || !endDate) {
            alert("⚠️ 旅行タイトルと日程を入力してください！");
            return;
        }
    
        fetch(`/itineraries/save/${itineraryId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                itinerary_id: itineraryId,
                title: itineraryTitle,
                start_date: startDate,
                end_date: endDate,
                selected_prefectures: JSON.parse(hiddenInput.value) || [] // 🔥 `null` を防ぐ
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log("✅ 旅行情報保存のレスポンス:", data);
            if (data.error) {
                console.error("❌ 旅行情報保存エラー:", data.error);
                alert("❌ 旅行情報の保存に失敗しました。");
                return;
            }
                // ✅ `localStorage` をクリア
    console.log("🗑️ localStorage をクリア");
    localStorage.removeItem(`selectedDestinations_itinerary_${itineraryId}`);
    localStorage.removeItem(`itinerary_spots_${itineraryId}`);
    localStorage.removeItem(`itinerary_data_${itineraryId}`);

    alert("✅ 旅行情報が保存されました！");

        })
        .catch(error => {
            console.error("❌ 旅行情報の保存エラー:", error);
            alert("❌ 旅行情報の保存に失敗しました。");
        });
    });
    
    

    // doneButton.addEventListener("click", function () {
    //     console.log("✅ Doneボタンがクリックされました");
    
    //     let itineraryId = document.getElementById("itinerary-data").dataset.itineraryId;
    //     let storedSpotsRaw = localStorage.getItem(`itinerary_spots_${itineraryId}`);
    
    //     let itineraryTitle = document.getElementById("itinerary-title").value.trim();
    //     let startDate = document.getElementById("start_date").value;
    //     let endDate = document.getElementById("end_date").value;
    //     let selectedPrefecturesRaw = document.getElementById("selected-prefectures").value;
        
    //     let selectedPrefectures = selectedPrefecturesRaw ? JSON.parse(selectedPrefecturesRaw) : [];
    
    //     console.log("📤 送信前の旅行情報:", {
    //         itinerary_id: itineraryId,
    //         title: itineraryTitle,
    //         start_date: startDate,
    //         end_date: endDate,
    //         selected_prefectures: selectedPrefectures,
    //         spots: storedSpots
    //     });
    
    //     if (!itineraryTitle || !startDate || !endDate) {
    //         alert("⚠️ 旅行タイトルと日程を入力してください！");
    //         return;
    //     }

    //         // 🔹 型を DB に揃える
    // storedSpots = storedSpots.map(spot => ({
    //     place_id: String(spot.place_id),
    //     spot_order: parseInt(spot.order, 10) || 1,
    //     visit_time: spot.visit_time ? String(spot.visit_time) : null,
    //     visit_day: parseInt(spot.visit_day, 10) || 1
    // }));

    
    //     console.log("📤 修正後のスポットデータ:", JSON.stringify({
    //         itinerary_id: itineraryId,
    //         title: itineraryTitle,
    //         start_date: startDate,
    //         end_date: endDate,
    //         selected_prefectures: selectedPrefectures,
    //         spots: storedSpots
    //     }, null, 2));
    //     // ✅ **1. 旅行の基本情報を `ItineraryController` に送る**
    //     fetch(`/itineraries/save/${itineraryId}`, {
    //         method: "POST",
    //         headers: {
    //             "Content-Type": "application/json",
    //             "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
    //         },
    //         body: JSON.stringify({
    //             itinerary_id: itineraryId,
    //             title: itineraryTitle,
    //             start_date: startDate,
    //             end_date: endDate,
    //             selected_prefectures: selectedPrefectures,
    //             spots: storedSpots
    //         })
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         console.log("✅ 旅行情報保存のレスポンス:", data);
    //         if (data.error) {
    //             console.error("❌ 旅行情報保存エラー:", data.error);
    //             alert("❌ 旅行情報の保存に失敗しました。");
    //             return;
    //         }
    //     })
    //     .catch(error => {
    //         console.error("❌ 旅行情報の保存エラー:", error);
    //         alert("❌ 旅行情報の保存に失敗しました。");
    //     });
    
    //     // ✅ **2. スポット情報を `ItinerarySpotController` に送る**
    //     // if (!storedSpotsRaw) {
    //     //     console.warn("⚠️ スポットデータがありません。");
    //     //     return;
    //     // }
    
    //     // let storedSpots = JSON.parse(storedSpotsRaw);
        
    //     // if (!Array.isArray(storedSpots) || storedSpots.length === 0) {
    //     //     console.warn("⚠️ 送信するスポットがありません！");
    //     //     return;
    //     // }
    
    //     // // 🔹 型を DB に揃える
    //     // storedSpots = storedSpots.map(spot => ({
    //     //     place_id: String(spot.place_id),
    //     //     name: String(spot.name),
    //     //     address: String(spot.address),
    //     //     spot_order: parseInt(spot.order, 10) || 1,
    //     //     visit_time: spot.visit_time ? String(spot.visit_time) : null,
    //     //     visit_day: parseInt(spot.visit_day, 10) || 1
    //     // }));
    
    //     // console.log("📤 修正後のスポットデータ:", JSON.stringify({
    //     //     itinerary_id: itineraryId,
    //     //     spots: storedSpots
    //     // }, null, 2));
    
    //     // fetch(`/itinerary/save/${itineraryId}`, {
    //     //     method: "POST",
    //     //     headers: {
    //     //         "Content-Type": "application/json",
    //     //         "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
    //     //     },
    //     //     body: JSON.stringify({
    //     //         itinerary_id: itineraryId,
    //     //         spots: storedSpots
    //     //     })
    //     // })
    //     // .then(response => response.json())
    //     // .then(data => {
    //     //     console.log("✅ スポット保存のレスポンス:", data);
    //     //     if (data.message === "Spots saved successfully") {
    //     //         localStorage.removeItem        // ✅ localStorage をクリア
    //     //         localStorage.removeItem(`itinerary_spots_${itineraryId}`);
    //     //         localStorage.removeItem(`selectedDestinations_itinerary_${itineraryId}`);
        
    //     //         alert("✅ 旅程が保存されました！");
        
    //     //         // ✅ Home にリダイレクト
    //     //         if (data.redirect_url) {
    //     //             window.location.href = data.redirect_url;
    //     //         }

    //     //     } else {
    //     //         console.error("❌ スポット保存エラー:", data.error);
    //     //         alert("❌ 旅程の保存に失敗しました。");
    //     //     }
    //     // })
    //     // .catch(error => {
    //     //     console.error("❌ スポット保存エラー:", error);
    //     //     alert("❌ 旅程の保存に失敗しました。");
    //     // });
    // });
    

    function updateDestinationList() {
        console.log("🔄 updateDestinationList() を実行");

        let selectedDestinations = localStorage.getItem(
            `selectedDestinations_itinerary_${itineraryId}`
        );

        if (!selectedDestinations || selectedDestinations === "[]") {
            console.warn(
                "⚠️ localStorage に保存された選択情報が見つかりません"
            );
            return;
        }

        selectedDestinations = JSON.parse(selectedDestinations);
        console.log(
            "🟢 localStorage から読み取ったデータ:",
            selectedDestinations
        );

        let destinationContainer = document.getElementById(
            "selected-destination-list"
        );

        if (!destinationContainer) {
            console.error("Error: #selected-destination-list が見つかりません");
            return;
        }

        destinationContainer.innerHTML = "";

        selectedDestinations.forEach((destination) => {
            console.log("🟢 UI に追加するデータ:", destination);

            let badge = document.createElement("span");
            badge.className =
                "badge rounded-pill px-3 py-2 text-white me-2 fs-6";
            badge.style.backgroundColor = destination.color;
            badge.textContent = destination.name;
            destinationContainer.appendChild(badge);
        });

        console.log("✅ Updated UI with selected destinations");
    }

    // 🔹 ページロード時に Prefecture 選択を復元
    console.log(
        "🔄 Prefecture 選択の適用開始（itineraryId: " + itineraryId + "）"
    );
    let restoredPrefectures = localStorage.getItem(
        `selectedDestinations_itinerary_${itineraryId}`
    );
    if (restoredPrefectures) {
        localStorage.setItem("selectedDestinations", restoredPrefectures);
        console.log("🔄 Prefecture 選択を復元しました:", restoredPrefectures);
    }

    // 🔹 UI更新
    updateDestinationList();
});

document.addEventListener("DOMContentLoaded", function () {
    let itineraryIdElem = document.getElementById("itinerary-data");
    if (!itineraryIdElem) {
        console.error("❌ itinerary-data が見つかりません");
        return;
    }
    let itineraryId = itineraryIdElem.dataset.itineraryId;
    console.log("🟢 確認: itineraryId =", itineraryId);

    let startDateInput = document.getElementById("start_date");
    let endDateInput = document.getElementById("end_date");

    // ✅ **カレンダーの日程変更イベント**
    startDateInput.addEventListener("change", updateDates);
    endDateInput.addEventListener("change", updateDates);

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
            })
            .catch((error) => console.error("❌ Error:", error));
    }

    // ✅ Day の追加処理
    document.addEventListener("click", function (event) {
        if (event.target.id === "add-day" || event.target.closest("#add-day")) {
            console.log("✅ + ボタンが押された");

            let newEndDate = new Date(endDateInput.value);
            newEndDate.setDate(newEndDate.getDate() + 1);
            endDateInput.value = newEndDate.toISOString().split("T")[0];

            let daysContainer = document.querySelector(".swiper-wrapper");
            let newDayIndex = document.querySelectorAll(".day-tab").length + 1;
            let newDayElement = document.createElement("div");
            newDayElement.classList.add("swiper-slide", "day-tab");
            newDayElement.dataset.day = newDayIndex;
            newDayElement.innerHTML = `
                <i class="fa-solid fa-arrow-right-arrow-left float-start mt-1"></i> 
                Day ${newDayIndex}
                <i class="fa-solid fa-trash-can float-end mt-1 remove-day"></i>
            `;

            daysContainer.insertBefore(
                newDayElement,
                document.getElementById("add-day")
            );

            document.getElementById(
                "trip_days"
            ).innerText = `${newDayIndex} days`;
            console.log("✅ 新しいDay追加:", newDayIndex);
            updateDates();
        }
    });

    // ✅ Day の削除処理
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-day")) {
            console.log("✅ Day削除ボタンがクリックされた");

            let allDays = document.querySelectorAll(".day-tab");
            if (allDays.length === 1) {
                console.warn("❌ 最後の Day は削除できません");
                return;
            }

            let dayElement = event.target.closest(".swiper-slide");
            dayElement.remove();
            console.log("✅ 削除成功:", dayElement);

            let allDaysElements = document.querySelectorAll(".day-tab");
            allDaysElements.forEach((day, index) => {
                day.dataset.day = index + 1;
                day.innerHTML = `
                    <i class="fa-solid fa-arrow-right-arrow-left float-start mt-1"></i> 
                    Day ${index + 1}
                    <i class="fa-solid fa-trash-can float-end mt-1 remove-day"></i>
                `;
            });

            document.getElementById(
                "trip_days"
            ).innerText = `${allDaysElements.length} days`;

            let newEndDate = new Date(endDateInput.value);
            newEndDate.setDate(newEndDate.getDate() - 1);
            endDateInput.value = newEndDate.toISOString().split("T")[0];

            updateDates();
        }
    });

    // ✅ ページロード時のデータ適用
    updateDates();

    let daysList = JSON.parse(localStorage.getItem(`daysList_itinerary_${itineraryId}`)) || [1];

    function renderDays() {
        let daysContainer = document.querySelector(".swiper-wrapper");
        if (!daysContainer) return;
        daysContainer.innerHTML = `<div class="swiper-slide active-tab overview-margin">Overview</div>`;

        daysList.forEach((day, index) => {
            let newDayElement = document.createElement("div");
            newDayElement.classList.add("swiper-slide", "day-tab");
            newDayElement.dataset.day = index + 1;
            newDayElement.innerHTML = `
                <i class="fa-solid fa-arrow-right-arrow-left float-start mt-1"></i> 
                Day ${index + 1}
                <i class="fa-solid fa-trash-can float-end mt-1 remove-day" data-day="${index + 1}"></i>
            `;
            daysContainer.appendChild(newDayElement);
        });

        let addDayElement = document.createElement("div");
        addDayElement.classList.add("swiper-slide");
        addDayElement.id = "add-day";
        addDayElement.innerHTML = `<i class="fa-solid fa-plus"></i>`;
        daysContainer.appendChild(addDayElement);
    }

    // 🔹 `🗑️ 削除ボタン` をクリックしたら、その `visit_day` のスポットを削除
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-day")) {
            let dayToRemove = parseInt(event.target.dataset.day);
            console.log(`🗑️ Day ${dayToRemove} を削除`);

            // 🔥 `daysList` を更新
            daysList = daysList.filter(day => day !== dayToRemove);
            localStorage.setItem(`daysList_itinerary_${itineraryId}`, JSON.stringify(daysList));

            // 🔥 サーバーに削除リクエストを送信
            fetch(`/itineraries/${itineraryId}/day/${dayToRemove}/delete-spots-by-day`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log("✅ スポット削除結果:", data);
                renderDays();
                updateSpotsDisplay(); // ボディのスポットも更新
            })
            .catch(error => console.error("❌ スポット削除エラー:", error));            
        }
    });

    renderDays();

});
