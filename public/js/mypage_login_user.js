console.log("🚀 mypage_login_user.js が読み込まれたよ！");

document.addEventListener("DOMContentLoaded", function () {
    // 🔁 現在のURLのハッシュ（#overview など）に応じてタブを切り替える
    let activeTab = window.location.hash;
    if (activeTab) {
        let tabElement = document.querySelector(`button[data-bs-target="${activeTab}"]`);
        if (tabElement) {
            let tab = new bootstrap.Tab(tabElement);
            tab.show();
        }
    }

    // 🔁 タブが切り替えられた時に、URLのハッシュを更新
    document.querySelectorAll('.nav-link-mypage').forEach(function (tab) {
        tab.addEventListener('shown.bs.tab', function (event) {
            let newTab = event.target.getAttribute('data-bs-target');
            if (newTab) {
                history.pushState(null, null, newTab);
            }
        });
    });

    // 🍽️ レストラン名取得用（もし element が存在する場合だけ）
    function fetchRestaurantNames(start, end) {
        let reviews = document.querySelectorAll(".review-item");
        for (let i = start; i < end && i < reviews.length; i++) {
            let element = reviews[i].querySelector(".restaurant-name");
            if (!element) continue;

            let placeId = element.getAttribute("data-place-id");
            if (!placeId) {
                element.textContent = "Unknown Restaurant";
                continue;
            }

            fetch(`/mypage/get-restaurant-name?place_id=${placeId}`)
                .then(response => response.json())
                .then(data => {
                    element.textContent = data.result?.name || "Unknown Restaurant";
                })
                .catch(() => {
                    element.textContent = "Unknown Restaurant";
                });
        }
    }

    // ⭐ 初期表示：最初の5件だけ表示
    let reviews = document.querySelectorAll(".review-item");
    let loadMoreButton = document.getElementById("loadMore");
    let currentIndex = 5;
    fetchRestaurantNames(0, 5);

    // 🔘 MOREボタン：さらに5件表示
    if (loadMoreButton) {
        loadMoreButton.addEventListener("click", function () {
            let nextIndex = currentIndex + 5;

            for (let i = currentIndex; i < nextIndex && i < reviews.length; i++) {
                reviews[i].style.display = "block";
            }

            fetchRestaurantNames(currentIndex, nextIndex);
            currentIndex = nextIndex;

            if (currentIndex >= reviews.length) {
                loadMoreButton.style.display = "none";
            }
        });
    }

    // 📖 Read More / Read Less 機能
    document.querySelectorAll(".card-body").forEach(function (review) {
        let readMore = review.querySelector(".read-more");
        let readLess = review.querySelector(".read-less");
        let shortText = review.querySelector(".short-text");
        let fullText = review.querySelector(".full-text");

        if (readMore) {
            readMore.addEventListener("click", function (e) {
                e.preventDefault();
                shortText.classList.add("d-none");
                fullText.classList.remove("d-none");
                readMore.classList.add("d-none");
                readLess.classList.remove("d-none");
            });
        }

        if (readLess) {
            readLess.addEventListener("click", function (e) {
                e.preventDefault();
                shortText.classList.remove("d-none");
                fullText.classList.add("d-none");
                readMore.classList.remove("d-none");
                readLess.classList.add("d-none");
            });
        }
    });

    // 📎 MOREボタンでタブ移動（Overview → Restaurant Reviewsなど）
    document.querySelectorAll(".more-tab-button").forEach(function (button) {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            let targetTab = this.getAttribute("data-target");
            if (!targetTab) return;

            let tabElement = document.querySelector(`button[data-bs-target="${targetTab}"]`);
            if (tabElement) {
                let tab = new bootstrap.Tab(tabElement);
                tab.show();
                history.pushState(null, null, targetTab);
            }
        });
    });

    // ✅ ページ読み込み時も再度ハッシュを確認（リロード対策）
    let hash = window.location.hash;
    if (hash) {
        let tabElement = document.querySelector(`button[data-bs-target="${hash}"]`);
        if (tabElement) {
            let tab = new bootstrap.Tab(tabElement);
            tab.show();
        }
    }

    // ⭐ 初期表示：最初の5件だけ表示（Itineraries用）
    let itineraryItems = document.querySelectorAll(".all-itinerary-item");
    let loadMoreItineraryBtn = document.getElementById("loadMoreAllItineraries");
    let itineraryIndex = 5;

    // 初期チェック：5件以下ならボタン非表示
    if (itineraryItems.length <= 5 && loadMoreItineraryBtn) {
        loadMoreItineraryBtn.style.display = "none";
    }

    // 🔘 MOREボタン：さらに5件表示
    if (loadMoreItineraryBtn) {
        loadMoreItineraryBtn.addEventListener("click", function () {
            let nextIndex = itineraryIndex + 5;

            for (let i = itineraryIndex; i < nextIndex && i < itineraryItems.length; i++) {
                itineraryItems[i].style.display = "block";
            }

            itineraryIndex = nextIndex;

            if (itineraryIndex >= itineraryItems.length) {
                loadMoreItineraryBtn.style.display = "none";
            }
        });
    }

    

});
