let itineraryIndex = 4;
    document.getElementById('load-more-itinerary').addEventListener('click', function() {
        let items = document.querySelectorAll('.itinerary-item');
        for (let i = itineraryIndex; i < itineraryIndex + 4; i++) {
            if (items[i]) {
                items[i].style.display = 'block';
            }
        }
        itineraryIndex += 4;
        if (itineraryIndex >= items.length) {
            this.style.display = 'none';
        }
    });