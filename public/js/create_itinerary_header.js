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
    document.querySelectorAll('.swiper-slide').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.swiper-slide').forEach(t => t.classList.remove('active-tab'));
            this.classList.add('active-tab');
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

    let modalInstance = new bootstrap.Modal(modalElem);

    // Destinationボタンをクリックでモーダルを表示
    destinationBtn.addEventListener("click", function () {
        console.log("✅ Destinationボタンがクリックされた");
        modalInstance.show();
    });

    function applyOldSelections() {
        let selectedDestinations = localStorage.getItem("selectedDestinations");
    
        if (selectedDestinations) {
            selectedDestinations = JSON.parse(selectedDestinations);
    
            // すべてのチェックボックスを取得
            document.querySelectorAll('input[name="prefectures[]"]').forEach((checkbox) => {
                // チェックをリセット
                checkbox.checked = false;
    
                // 過去に選択された都道府県ならチェックをつける
                selectedDestinations.forEach((destination) => {
                    if (destination.id === checkbox.value) {
                        checkbox.checked = true;
                    }
                });
            });
    
            console.log("✅ 過去の選択肢を適用しました");
        }
    }
    

    // 🔹 Saveボタンが押されたときの処理
saveDestinationBtn.addEventListener("click", function () {
    let selectedPrefectures = [];
    let selectedPrefectureIds = []; // 🔥 ここで空の配列を定義 🔥

    document.querySelectorAll('input[name="prefectures[]"]:checked').forEach((checkbox) => {
        let name = checkbox.parentElement.querySelector("span").textContent.trim();
        let color = checkbox.getAttribute("data-color");

        selectedPrefectures.push({id: parseInt(checkbox.value, 10), name: name, color: color});
        selectedPrefectureIds.push(parseInt(checkbox.value, 10)); // 🔥 修正点: ここを正しい配列に追加
    });

    console.log("Saved to localStorage:", selectedPrefectures);
    console.log("Selected Prefecture IDs (for DB):", selectedPrefectureIds);

    if (selectedPrefectures.length === 0) {
        alert("Please select at least one destination.");
        return;
    }

    localStorage.setItem("selectedDestinations", JSON.stringify(selectedPrefectures));
    document.getElementById("selected-prefectures").value = selectedPrefectureIds.join(',');

    updateDestinationList();

    // モーダルを閉じる処理
    setTimeout(() => {
        modalInstance.hide();
        console.log("✅ モーダルを閉じました！");
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    }, 100);
});


    function updateDestinationList() {
        let selectedDestinations = localStorage.getItem("selectedDestinations");

        if (selectedDestinations) {
            selectedDestinations = JSON.parse(selectedDestinations);
            let destinationContainer = document.getElementById("selected-destination-list");

            if (!destinationContainer) {
                console.error("Error: #selected-destination-list が見つかりません");
                return;
            }

            destinationContainer.innerHTML = "";

            selectedDestinations.forEach((destination) => {
                let badge = document.createElement("span");
                badge.className = "badge rounded-pill px-3 py-2 text-white me-2 fs-6";
                badge.style.backgroundColor = destination.color;
                badge.textContent = destination.name;
                destinationContainer.appendChild(badge);
            });

            console.log("Updated UI with selected destinations");
        }
    }

    function updateDates() {
        console.log("✅ updateDates() が実行された");
        
        let startDateInput = document.getElementById("start_date");
        let endDateInput = document.getElementById("end_date");
        
        let startDate = new Date(startDateInput.value);
        let endDate = new Date(endDateInput.value);
        
        // ✅ **終了日が開始日より前にならないように制御**
        if (endDate < startDate) {
            console.warn("❌ 終了日が開始日より前になっています。修正します。");
            endDateInput.value = startDateInput.value; // 終了日を開始日に自動修正
            endDate = new Date(endDateInput.value);
        }
        
        fetch(`/itineraries/${itineraryId}/update-dates`, {
            method: "POST",
            headers: { 
                "Content-Type": "application/json", 
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content 
            },
            body: JSON.stringify({
                start_date: startDateInput.value,
                end_date: endDateInput.value
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log("✅ fetch response:", data);
            console.log("✅ updated days:", data.days);
            console.log("✅ updated daysList:", data.daysList);
        
            document.getElementById("trip_days").innerText = data.days + " days";
        
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
        .catch(error => console.error("❌ Error:", error));
        }
        
        // ✅ **日付の変更イベント**
        document.getElementById("start_date").addEventListener("change", function() {
        console.log("📅 開始日変更: ", this.value);
        updateDates();
        });
        
        document.getElementById("end_date").addEventListener("change", function() {
        console.log("📅 終了日変更: ", this.value);
        updateDates();
        });

    // ✅ Day の追加処理
        document.addEventListener("click", function (event) {
        if (event.target.id === "add-day" || event.target.closest("#add-day")) {
            console.log("✅ + ボタンが押された");

            let endDateInput = document.getElementById("end_date");
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

            daysContainer.insertBefore(newDayElement, document.getElementById("add-day"));

            let tripDaysElement = document.getElementById("trip_days");
            tripDaysElement.innerText = `${newDayIndex} days`;

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
            let dayIndex = dayElement.dataset.day;
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

            document.getElementById("trip_days").innerText = `${allDaysElements.length} days`;

            let endDateInput = document.getElementById("end_date");
            let newEndDate = new Date(endDateInput.value);
            newEndDate.setDate(newEndDate.getDate() - 1);
            endDateInput.value = newEndDate.toISOString().split("T")[0];

            updateDates();
        }
    });

// ✅ フォーム送信時の処理（修正済み・user_idのnullチェック削除）
document.getElementById("itinerary-form").addEventListener("submit", function (event) {
    event.preventDefault(); // 🔹 デフォルトのフォーム送信を防ぐ

    let formData = new FormData(this); // 🔹 フォームデータを取得

    // ✅ selected_prefectures をセット
    let selectedPrefectures = localStorage.getItem("selectedDestinations");
    let selectedPrefectureIds = selectedPrefectures 
        ? JSON.parse(selectedPrefectures).map(p => parseInt(p.id, 10)) 
        : [];

    console.log("🟢 現在の選択 Prefectures:", selectedPrefectureIds);

    selectedPrefectureIds.forEach(id => {
        formData.append('selected_prefectures[]', id);
    });

    // ✅ start_date, end_date を強制的にセット（バリデーションエラー回避）
    let startDateInput = document.getElementById("start_date");
    let endDateInput = document.getElementById("end_date");

    formData.append("start_date", startDateInput.value);
    formData.append("end_date", endDateInput.value);

    // ✅ itinerary_id の取得
    let itineraryId = document.getElementById("itinerary-id")?.value || null;
    let url = itineraryId ? `/itineraries/save/${itineraryId}` : `/itineraries/save`;

    // ✅ CSRF トークンを `FormData` に追加
    let csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    formData.append('_token', csrfToken);

    console.log("🟢 送信データ:", Object.fromEntries(formData.entries()));

    fetch(url, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrfToken
        },
        body: formData
    })
    .then(response => {
        console.log("🔄 Fetch Response Status:", response.status);
        
        // JSON 形式以外のレスポンスを弾く
        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
            throw new Error("❌ サーバーがJSONを返していません");
        }
    
        return response.json();
    })
    
    .then(data => {
        console.log("✅ サーバーからのレスポンス:", data);
    
        if (data?.success) {
            alert("✅ 保存が完了しました: " + data.message);
            console.log("✅ Redirecting to:", data.redirect);
            window.location.href = data.redirect;  // ✅ LaravelからのリダイレクトURLを使用
        } else {
            alert("⚠️ エラー: " + (data.message || "不明なエラー"));
        }
    })
    .catch(error => console.error("❌ フェッチエラー:", error));
});


    // 🔹 ページロード時に Prefecture 選択を復元
document.addEventListener("DOMContentLoaded", function () {
    let restoredPrefectures = localStorage.getItem("selectedDestinationsBackup");
    if (restoredPrefectures) {
        localStorage.setItem("selectedDestinations", restoredPrefectures);
        localStorage.removeItem("selectedDestinationsBackup");
        console.log("🔄 Prefecture 選択を復元しました:", restoredPrefectures);
    }
});

    // 🔹 `updateDestinationList` 関数を統合
    function updateDestinationList() {
        let selectedDestinations = localStorage.getItem("selectedDestinations");

        if (selectedDestinations) {
            selectedDestinations = JSON.parse(selectedDestinations);
            let destinationContainer = document.getElementById("selected-destination-list");

            if (!destinationContainer) {
                console.error("Error: #selected-destination-list が見つかりません");
                return;
            }

            // 既存のリストをクリア（重複を防ぐ）
            destinationContainer.innerHTML = "";

            selectedDestinations.forEach((destination) => {
                let badge = document.createElement("span");
                badge.className = "badge rounded-pill px-3 py-2 text-white me-2 fs-6";
                badge.style.backgroundColor = destination.color;
                badge.textContent = destination.name;
                destinationContainer.appendChild(badge);
            });

            console.log("Updated UI with selected destinations");
        }
    }

    // 🔹 ページロード時に `localStorage` からデータを取得して UI を更新
    updateDestinationList();
});