document.addEventListener("DOMContentLoaded", function () {
    const searchButton = document.getElementById("searchButton");
    const searchInput = document.getElementById("restaurantSearchInput");
    const resultsContainer = document.getElementById("restaurantResults");
    const moreButton = document.getElementById("moreButton"); 
    
    let currentPage = 1;
    let totalPages = 1;
    let currentQuery = "";

    // **🔹 ページが読み込まれた時に、ローカルストレージから復元**
    if (localStorage.getItem("lastSearchQuery")) {
        currentQuery = localStorage.getItem("lastSearchQuery");
        searchInput.value = currentQuery;
        fetchRestaurants(currentQuery, 1);  // **🔹 再検索して最新の画像を取得**
    }
    
    function fetchRestaurants(query, page = 1) {
        fetch(`/api/places?query=${encodeURIComponent(query)}&page=${page}`)
            .then(response => response.json())
            .then(data => {
                console.log("🔍 API Response:", data);
                if (!data.data || data.data.length === 0) {
                    resultsContainer.innerHTML = "<p class='text-center'>No results found.</p>";
                    moreButton.style.setProperty("display", "none", "important");
                    return;
                }

                currentPage = data.current_page;
                totalPages = data.total_pages;

                if (page === 1) {
                    resultsContainer.innerHTML = ""; // **🔹 初回検索時はリセット**
                }

                displayResults(data.data);

                // **🔹 検索キーワードだけを保存 (画像URLはキャッシュしない)**
                localStorage.setItem("lastSearchQuery", query);

                if (currentPage < totalPages) {
                    console.log("✅ Moreボタンを表示");
                    moreButton.style.setProperty("display", "block", "important"); // !important を適用
                } else {
                    console.log("❌ Moreボタンを非表示");
                    moreButton.style.setProperty("display", "none", "important");
                }
            })
            .catch(error => {
                console.error("❌ Error fetching restaurant data:", error);
                resultsContainer.innerHTML = `<p class='text-center text-danger'>Error: ${error.message}</p>`;
                moreButton.style.setProperty("display", "none", "important");
            });
    }

    searchButton.addEventListener("click", function () {
        handleSearch();
    });

    searchInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            handleSearch();
        }
    });

    function handleSearch() {
        const query = searchInput.value.trim();
        if (query.length > 0) {
            currentQuery = query;
            currentPage = 1;
            resultsContainer.innerHTML = ""; // **検索結果をリセット**
            moreButton.style.setProperty("display", "none", "important");
            fetchRestaurants(query);
        }
    }

    moreButton.addEventListener("click", function () {
        if (currentQuery && currentPage < totalPages) {
            currentPage++;
            fetchRestaurants(currentQuery, currentPage);
        }
    });

    function displayResults(restaurants) {
        const restaurantItems = restaurants.map(restaurant => {
            return `
                <div class="restaurant-item container">
                    <div class="row align-items-center">
                        <div class="col-3 col-md-2">
                            <img src="${restaurant.photo}" alt="${restaurant.name}" class="img-fluid rounded">
                        </div>
                        <div class="col-9 col-md-7">
                            <h5 class="mb-1">${restaurant.name}</h5>
                            <p class="mb-1 text-muted">${restaurant.formatted_address}</p>
                        </div>
                        <div class="col-12 col-md-3 d-flex flex-column flex-md-row justify-content-end mt-2 mt-md-0">
                            <a href="/restaurant-reviews/view?place_id=${restaurant.place_id}&photo=${encodeURIComponent(restaurant.photo)}" id="viewReviewButton" class="btn btn-sm w-100 w-md-auto mb-2 mb-md-0 me-md-2">View Details</a>
                            <a href="/restaurant-reviews/create?place_id=${restaurant.place_id}&photo=${encodeURIComponent(restaurant.photo)}" id="createReviewButton" class="btn btn-sm w-100 w-md-auto">Create Review</a>
                        </div>
                    </div>
                </div>
            `;
        }).join("");

        resultsContainer.innerHTML += restaurantItems;
    }
});

