document.addEventListener("DOMContentLoaded", function () {
      // 現在のURLのハッシュ部分（例: #itineraries）
      var activeTab = window.location.hash;
  
      if (activeTab) {
          // ハッシュがある場合、そのタブをアクティブにする
          var tabElement = document.querySelector('button[data-bs-target="' + activeTab + '"]');
          if (tabElement) {
              var tab = new bootstrap.Tab(tabElement);
              tab.show();
          }
      }
  
      // タブがクリックされたときにURLのハッシュを変更
      document.querySelectorAll('.nav-link-mypage').forEach(function (tab) {
          tab.addEventListener('shown.bs.tab', function (event) {
              var newTab = event.target.getAttribute('data-bs-target'); // 新しくアクティブになったタブ
              history.pushState(null, null, newTab); // URLの `#` を更新
          });
      });


      let apiKey = "{{ config('services.google.maps_api_key') }}"; // Google APIキー
    let reviews = document.querySelectorAll(".review-item");
    let topReviews = document.querySelectorAll(".top-review-item");
    let loadMoreButton = document.getElementById("loadMore");
    let currentIndex = 5; // 最初に表示する件数

    function fetchRestaurantNames(start, end) {
        for (let i = start; i < end && i < reviews.length; i++) {
            let element = reviews[i].querySelector(".restaurant-name");
            let placeId = element.getAttribute("data-place-id");

            if (placeId) {
                fetch(`/mypage/get-restaurant-name?place_id=${placeId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("API Response:", data); // 確認用ログ

                        if (data.result && data.result.name) { 
                            element.textContent = data.result.name;
                        } else {
                            element.textContent = "Unknown Restaurant";
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching restaurant name:", error);
                        element.textContent = "Unknown Restaurant";
                    });
            } else {
                element.textContent = "Unknown Restaurant";
            }
        }
    }


    // 最初の5件をAPIで取得
    fetchRestaurantNames(0, 5);

    // 「More」ボタンを押したときに次の5件を取得
    loadMoreButton.addEventListener("click", function () {
        let nextIndex = currentIndex + 5;
        
        for (let i = currentIndex; i < nextIndex && i < reviews.length; i++) {
            reviews[i].style.display = "block";
        }

        // 新しく表示された5つのレビューだけAPIを呼び出す
        fetchRestaurantNames(currentIndex, nextIndex);

        currentIndex = nextIndex;

        if (currentIndex >= reviews.length) {
            loadMoreButton.style.display = "none"; // すべて表示したらボタンを消す
        }
    });

    document.querySelectorAll(".card-body").forEach(function (review) {
      let readMore = review.querySelector(".read-more");
      let readLess = review.querySelector(".read-less");
      let shortText = review.querySelector(".short-text");
      let fullText = review.querySelector(".full-text");

      if (readMore) {
          readMore.addEventListener("click", function (event) {
              event.preventDefault(); // URLが変わるのを防ぐ
              shortText.classList.add("d-none");
              fullText.classList.remove("d-none");
              readMore.classList.add("d-none");
              readLess.classList.remove("d-none");
          });
      }

      if (readLess) {
          readLess.addEventListener("click", function (event) {
              event.preventDefault(); // URLが変わるのを防ぐ
              shortText.classList.remove("d-none");
              fullText.classList.add("d-none");
              readMore.classList.remove("d-none");
              readLess.classList.add("d-none");
          });
      }
  });

  let moreButtons = document.querySelectorAll(".more-tab-button");

    moreButtons.forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            let targetTab = this.getAttribute("data-target");
            if (!targetTab) return;

            // 🔥 Bootstrapのタブを切り替える
            let tabElement = document.querySelector(`button[data-bs-target="${targetTab}"]`);
            if (tabElement) {
                let tab = new bootstrap.Tab(tabElement);
                tab.show();

                // 🔥 URLのハッシュを変更（リロードしてもこのタブが開いたままになる）
                history.pushState(null, null, `/mypage${targetTab}`);
            }
        });
    });

    // 🔥 URLのハッシュを確認して、適切なタブを開く
    let hash = window.location.hash;
    if (hash) {
        let tabElement = document.querySelector(`button[data-bs-target="${hash}"]`);
        if (tabElement) {
            let tab = new bootstrap.Tab(tabElement);
            tab.show();
        }
    }
});