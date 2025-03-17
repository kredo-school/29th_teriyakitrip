document.addEventListener("DOMContentLoaded", function () {
  let restaurantIndex = 4; // 最初に表示する数
  const items = document.querySelectorAll('.restaurant-item');
  const moreButton = document.getElementById('load-more-restaurant');

  moreButton.addEventListener('click', function () {
      let displayedCount = 0;
      
      for (let i = restaurantIndex; i < restaurantIndex + 4; i++) {
          if (items[i]) {
              items[i].style.display = 'block';
              displayedCount++;
          }
      }
      
      restaurantIndex += displayedCount;

      // 🔥 すべて表示されたら `MORE` ボタンを非表示
      if (restaurantIndex >= items.length) {
          moreButton.style.display = 'none';
      }
  });

  // 🔥 初回チェック：表示する要素が4個未満なら `MORE` ボタンを非表示
  if (items.length <= 4) {
      moreButton.style.display = 'none';
  }
});