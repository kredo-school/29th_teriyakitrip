// ✅ ページの読み込みが完了したら実行
document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ Body スクリプトが正常に読み込まれました！");

    let dayContainer = document.getElementById("day-container");
    let headerDaysContainer = document.querySelector(".swiper-wrapper");

    if (!dayContainer || !headerDaysContainer) {
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
    
            let dayContainer = document.getElementById("day-container");
            let currentDays = document.querySelectorAll(".day-body");
            let newDayCount = dayTabs.length;
    
            console.log(`🔍 現在の Day 数: ${currentDays.length}, ヘッダーの Day 数: ${newDayCount}`);
    
            // ✅ 既存の Day を削除し、新しく追加
            while (dayContainer.firstChild) {
                dayContainer.removeChild(dayContainer.firstChild);
            }
    
            // ✅ ヘッダーの Day 数に合わせてボディを再構築
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
                        <button type="button" class="border-0 bg-transparent">
                            <i class="fa-regular fa-square-plus"></i>
                        </button>
                    </div>
                `;
    
                dayContainer.appendChild(newDayBody);
                console.log(`✅ Body に Day ${i} を追加`);
            }
    
            console.log("✅ Body 更新完了");
    
            // ✅ 「+」ボタンのクリックイベントを再適用
            bindAddSpotEvents();
        }, 50);
    }    

    // ✅ 「+」ボタンのクリックイベントをバインドする関数
    function bindAddSpotEvents() {
        document.querySelectorAll(".plus-icon button").forEach((btn) => {
            btn.addEventListener("click", function () {
                let addSpotContainer = document.getElementById("add-spot-container");
        
                console.log(`🔍 add-spot-container の現在の display: ${getComputedStyle(addSpotContainer).display}`);
        
                addSpotContainer.style.display = "block";
        
                console.log(`✅ add-spot-container の変更後の display: ${getComputedStyle(addSpotContainer).display}`);
            });
        });
        
    }

    // ✅ MutationObserver の修正
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

    // ✅ 初回バインド
    bindAddSpotEvents();

    // ✅ 閉じるボタンで `create_add.blade.php` を非表示にする
    document.getElementById("close-add-spot").addEventListener("click", function () {
        document.getElementById("add-spot-container").style.display = "none";
    });
});
