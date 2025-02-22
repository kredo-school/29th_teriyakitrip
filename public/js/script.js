document.addEventListener("DOMContentLoaded", function () {
    let tabs = document.querySelectorAll(".nav-link");
    let sections = document.querySelectorAll(".tab-content");

    tabs.forEach(tab => {
        tab.addEventListener("click", function (event) {
            event.preventDefault();

            // すべてのタブを通常状態にする
            tabs.forEach(t => t.classList.remove("active"));

            // すべてのセクションを非表示
            sections.forEach(sec => sec.classList.remove("active"));

            // 選択されたタブをアクティブにする
            this.classList.add("active");

            // 対応するセクションを表示
            let targetSection = document.getElementById(this.dataset.section);
            if (targetSection) {
                targetSection.classList.add("active");
            }
        });
    });
});
