<div class="container">
    {{-- Select tab: Restaurants or Itineraries --}}
    <div class="row p-0 m-0 mb-3">        
        <ul class="nav border border-orange rounded fs-5">   
            <div class="col-6">   
                <li class="nav-item px-auto text-center py-0 border-end border-orange">            
                    <a id="restaurants-tab" class="nav-link" href="javascript:void(0);">
                       <span class="text-orange">Restaurants</span>
                    </a>
                </li>
            </div>
            <div class="col-6">                  
                <li class="nav-item px-auto text-center py-0">
                    <a id="itineraries-tab" class="nav-link" href="javascript:void(0);">
                        <span class="text-orange">Itineraries</span>
                    </a>
                </li> 
            </div>
        </ul> 
    </div>

    {{-- Favorite restaurants --}}
    <div id="restaurants-info" class="border rounded mb-5">
        <!-- Restaurants content here -->
        <div class="row">
            <div class="col-3 p-3 m-2">
                <img class="img-md" src="{{ asset("images/McDonald's.jpeg")}}" alt="McDonald's image">
            </div>
            <div class="col-8 m-3">                
                <h4>McDonald's</h4>
                    <p>McDonald's is a fast food restaurant chain headquartered in Chicago, Illinois. It is known for its iconic hamburger, fries, and soft drinks. The restaurant chain has over 10,000 locations worldwide. </p>
                <div class="d-flex justify-content-end">
                    <a href="#" class="btn-orange" >add to itinerary</a>
                </div>
            </div>            
        </div>

    </div>

    {{-- Favorite itineraries --}}
    <div id="itineraries-info" class="border rounded" style="display:none;">
        <!-- Itineraries content here -->

        <div class="row">
            <div class="col-3 p-3 m-2">
                <img class="img-md" src="{{ asset("images/shuri-jo.jpeg")}}" alt="McDonald's image">
            </div>
            <div class="col-8 m-3">                
                <h4>My trip to Okinawa</h4>
                    <p>I went to Okinawa on a trip and had a great time. The beaches were beautiful and the food was delicious. Espcially, the sushi was the best. I would definitely recommend this trip to Okinawa to anyone who is interested in traveling to Okinawa. </p>
                <div class="d-flex justify-content-end">
                    <a href="#" class="btn-orange" >add to itinerary</a>
                </div>
            </div>            
        </div>

    </div>
</div>

<script>
    document.getElementById('restaurants-tab').addEventListener('click', function() {
        document.getElementById('restaurants-info').style.display = 'block';
        document.getElementById('itineraries-info').style.display = 'none';
    });

    document.getElementById('itineraries-tab').addEventListener('click', function() {
        document.getElementById('restaurants-info').style.display = 'none';
        document.getElementById('itineraries-info').style.display = 'block';
    });
</script>
