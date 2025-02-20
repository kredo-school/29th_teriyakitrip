{{-- Search Bar --}}
<div class="container mb-3">
    <form action="#" method="GET" class="form-inline justify-content-center mt-4">
        <div class="input-group mb-3">
            <input type="text" class="form-control rounded-right-0" placeholder="Search attractions" name="query" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary rounded-left-0" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </div>        
    </form>
    {{-- Spot info from Google API --}}
    <div class="border rounded">
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
</div>