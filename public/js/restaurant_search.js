document.addEventListener("DOMContentLoaded", function () {
  const searchButton = document.getElementById("searchButton");
  const searchInput = document.getElementById("restaurantSearchInput");
  const resultsContainer = document.getElementById("restaurantResults");

  // dummy data
  const dummyRestaurants = [
      { id: 1, name: "ABC cafe", address: "44 Bishamoncho, Higashiyama-Ku, Kyoto 605-0812 Tokyo Prefecture", photo: "/images/restaurants/cafe.jpg" },
      { id: 2, name: "Sushi Yoko", address: "1-2-1, Namba, Chuo, Osaka Osaka Prefecture", photo: "/images/restaurants/sushiya.jpg" },
      { id: 3, name: "Ramen Street", address: "44 Bishamoncho, Higashiyama-Ku, Kyoto 605-0812 Kyoto Prefecture", photo: "/images/restaurants/ramen.jpg" },
  ];

  function handleSearch() {
      const query = searchInput.value.trim().toLowerCase();
      const filteredRestaurants = dummyRestaurants.filter(r => r.name.toLowerCase().includes(query));
      displayResults(filteredRestaurants);
  }

  searchButton.addEventListener("click", handleSearch);
  searchInput.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
          handleSearch();
      }
  });

  function displayResults(restaurants) {
      resultsContainer.innerHTML = ""; // 初期化

      if (restaurants.length === 0) {
          resultsContainer.innerHTML = "<p class='text-center'>No results found.</p>";
          return;
      }
    
      restaurants.forEach(restaurant => {
        const restaurantItem = `
            <div class="restaurant-item container">
                <div class="row align-items-center">
                    <!-- 📷 レストラン画像 -->
                    <div class="col-3 col-md-2">
                        <img src="${restaurant.photo}" alt="${restaurant.name}" class="img-fluid rounded">
                    </div>
    
                    <!-- ℹ️ レストラン情報 -->
                    <div class="col-9 col-md-7">
                        <h5 class="mb-1">${restaurant.name}</h5>
                        <p class="mb-1 text-muted">${restaurant.address}</p>
                    </div>
    
                    <!-- 🆎 ボタンエリア（小さい画面では下に回る） -->
                    <div class="col-12 col-md-3 d-flex flex-column flex-md-row justify-content-end mt-2 mt-md-0">
                        <a href="/restaurants/${restaurant.id}" class="btn btn-outline-secondary btn-sm w-100 w-md-auto mb-2 mb-md-0 me-md-2">View Details</a>
                        <a href="/restaurants/${restaurant.id}/review" class="btn btn-primary btn-sm w-100 w-md-auto">Create Review</a>
                    </div>
                </div>
            </div>
        `;
        resultsContainer.innerHTML += restaurantItem;
    });
    
      
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const suggestionContainer = document.querySelector(".suggestion-list");

  // ✅ しおりに入っているがレビューがないrestaurant dummy data
  const suggestedRestaurants = [
      { id: 1, name: "ABC Cafe", address: "Kyoto, Japan", photo: "/images/restaurants/cafe.jpg", reviews: 0 },
      { id: 2, name: "ICHIBAN Unagi", address: "Osaka, Japan", photo: "/images/restaurants/unagi.jpg", reviews: 0 },
      { id: 3, name: "Udon Oishi", address: "Tokyo, Japan", photo: "/images/misonikomiudon.jpg", reviews: 0 },
      { id: 4, name: "ICHIBAN Unagi", address: "Osaka, Japan", photo: "/images/restaurants/unagi.jpg", reviews: 0 },
      { id: 5, name: "ABC Cafe", address: "Kyoto, Japan", photo: "/images/restaurants/cafe.jpg", reviews: 0 },
      { id: 6, name: "Udon Oishi", address: "Tokyo, Japan", photo: "/images/misonikomiudon.jpg", reviews: 0 },
      { id: 7, name: "ICHIBAN Unagi", address: "Osaka, Japan", photo: "/images/restaurants/unagi.jpg", reviews: 0 },
      { id: 8, name: "Udon Oishi", address: "Tokyo, Japan", photo: "/images/misonikomiudon.jpg", reviews: 0 }
  ];

  function displaySuggestions() {
      suggestionContainer.innerHTML = ""; // 初期化

      suggestedRestaurants.forEach(restaurant => {
          const restaurantCard = `
              <div class="suggestion-card">
                  <img src="${restaurant.photo}" alt="${restaurant.name}" class="suggestion-img">
                  <h6 class="mt-2">${restaurant.name}</h6>
                  <p class="text-muted">${restaurant.address}</p>
                  <button class="btn btn-warning btn-sm" onclick="location.href='/restaurants/${restaurant.id}/review'">
                      Create a review
                  </button>
              </div>
          `;
          suggestionContainer.innerHTML += restaurantCard;
      });
  }

  displaySuggestions();
});

document.addEventListener("DOMContentLoaded", function () {
  const suggestionContainer = document.querySelector(".suggestion-list");
  const prevButton = document.querySelector(".carousel-prev");
  const nextButton = document.querySelector(".carousel-next");

  prevButton.addEventListener("click", function () {
      suggestionContainer.scrollBy({ left: -200, behavior: "smooth" });
  });

  nextButton.addEventListener("click", function () {
      suggestionContainer.scrollBy({ left: 200, behavior: "smooth" });
  });
});

