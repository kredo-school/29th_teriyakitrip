/**
 *Function to open a Photo modal
 */
 function openPhotoModal() {
    let photoModalElement = document.getElementById('photoModal');
    if (photoModalElement) {
        let photoModal = bootstrap.Modal.getOrCreateInstance(photoModalElement);
        photoModal.show();
    } else {
        console.error("photoModal が見つかりません");
    }
}


/**
 *Function to select a photo in the modal when clicked.
 */
 function selectPhoto(imageSrc) {
    console.log("選択した画像の URL:", imageSrc); // ✅ デバッグ用

    fetch(imageSrc)
        .then(res => res.blob())
        .then(blob => {
            let reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                let base64Data = reader.result;
                console.log("Base64 エンコード後:", base64Data); // ✅ ここで `null` になっていないか確認

                document.getElementById('photoBase64Input').value = base64Data;

                // 画像をプレビュー表示
                let photoPlaceholder = document.getElementById('photoPlaceholder');
                if (photoPlaceholder) {
                    photoPlaceholder.innerHTML = `<img src="${imageSrc}" alt="Selected Photo" class="img-fluid rounded">`;
                }

                // モーダルを閉じる
                let photoModalElement = document.getElementById('photoModal');
                if (photoModalElement) {
                    let photoModal = bootstrap.Modal.getInstance(photoModalElement);
                    photoModal.hide();
                }
            };
        });
}


/**
 *  Preview display of user-uploaded images
 */
document.getElementById('photoInput').addEventListener('change', function (event) {
    let file = event.target.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let selectedPhoto = document.getElementById('selectedPhoto');
            if (selectedPhoto) {
                selectedPhoto.src = e.target.result;
            }

            let photoPlaceholder = document.getElementById('photoPlaceholder');
            if (photoPlaceholder) {
                photoPlaceholder.innerHTML = `<img src="${e.target.result}" alt="Uploaded Photo" class="img-fluid rounded">`;
            }
        };
        reader.readAsDataURL(file);
    }
});


let destinations = window.destinations;


/**
 * add destination select box
 */
function addDestinationSelect(selectElement) {
    let container = document.getElementById('destination-container');

    if (selectElement.value !== "" && selectElement.parentElement === container.lastElementChild) {
        let newRow = document.createElement("div");
        newRow.classList.add("destination-row", "mt-2");

        let newSelect = document.createElement("select");
        newSelect.classList.add("form-select", "select-box", "with-button");
        newSelect.setAttribute("multiple", "multiple");
        newSelect.setAttribute("name", "prefectures[]");
        newSelect.setAttribute("id", "prefectures-select");
        let selectOptions = `<option value="">Choose your destination</option>`;
        destinations.forEach(region => {
            region.prefectures.forEach(prefecture => {
                selectOptions += `<option value="${prefecture.id}">${region.name} - ${prefecture.name}</option>`;
            });
        });

        newSelect.innerHTML = selectOptions;
        newSelect.setAttribute("onchange", "addDestinationSelect(this)");

        let removeBtn = document.createElement("button");
        removeBtn.type = "button";
        removeBtn.classList.add("btn", "remove-btn");
        removeBtn.innerHTML = "×";

        removeBtn.addEventListener("click", function () {
            removeDestination(this);
        });

        newRow.appendChild(newSelect);
        newRow.appendChild(removeBtn);
        container.appendChild(newRow);

        updateRemoveButtons();
    }
}

/**
 * after click x button remove destination select box
 * */
function removeDestination(button) {
    let row = button.parentElement;
    let container = document.getElementById('destination-container');
    let rows = document.querySelectorAll('.destination-row');

    if (rows.length > 1) {
        row.remove();
        updateRemoveButtons();
    }
}

/**
 *  control remove buttons visibility based on the number of rows
 */
function updateRemoveButtons() {
    let rows = document.querySelectorAll('.destination-row');
    rows.forEach((row, index) => {
        let removeBtn = row.querySelector(".remove-btn");
        let selectBox = row.querySelector(".select-box");

        if (removeBtn && selectBox) {
            if (index === 0 || index === rows.length - 1) {
                removeBtn.style.display = "none";
                selectBox.classList.remove("with-button");
                selectBox.classList.add("full-width");
            } else {
                removeBtn.style.display = "flex";
                selectBox.classList.remove("full-width");
                selectBox.classList.add("with-button");
            }
        }
    });
}