

<div class="container-flude">

    <div class="hero-image" style="background-image: url({{asset('assets/static_image/banner-caput1.jpg')}})">

      @include('component.user.Header',["is_dark"=> 0])


        
        <div id="fallback"></div>
    

        <div class="containt container">


          <h1 class="text-white text-center" id="head-line">Car Rental - Search, Compare & Save</h1>

          <div class="row justify-content-center mt-3">
            <div class="col-12 col-lg-6">

            

              <form class="d-flex search-containt" onsubmit="event.preventDefault()" id="searchForm">

                <select class="form-select form-select-lg rounded-0 border-0" aria-label=".form-select-lg example" name="brand">
                    
                  <option selected value="">Select Brand</option>

                  @foreach ( $brands as $brand)

                  <option value="{{$brand}}">{{$brand}}</option>
                      
                  @endforeach()
                  
                </select>

                <select class="form-select form-select-lg rounded-0 border-0" aria-label=".form-select-lg" name="model">

                  <option selected value="">Select model</option>

                  @foreach ( $models as $model)

                      <option value="{{$model}}">{{$model}}</option>
                      
                  @endforeach()
                </select>


                <input type="number" class="form-control rounded-0 border-0" placeholder="rent price" name="daily_rent_price">

                <button type="submit" class="btn btn-primary rounded-0 border-0" onclick="CartList()">Search</button>
              </form>
            
            </div>
          </div>



        </div>
        

    </div>


    {{-- {{$is_authenticated}} opps

     --}}
    <div class="container mt-5">

        

        <div class="row" id="car-list">


            {{-- <div class="col-6 col-lg-3 my-1">
                <div class="card" >
                <img src="{{asset('assets/static_image/banner-caput1.jpg')}}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
                </div>
            </div> --}}




        </div>
    </div>










</div>

<script>

    
  async function CartList(){

    let params ={};

    let form = document.getElementById('searchForm')

    if(form.brand.value){
      params.brand = form.brand.value
    }

    if(form.model.value){
      params.model = form.model.value
    }


    if(form.daily_rent_price.value){
      params.daily_rent_price = form.daily_rent_price.value
    }


    


    let res=await axios.get(`/browse/carList`, {
      params: params
    });

    let cards = ''


    for(let val of res.data.data){
        let active_rent_lenght = val.active_rent.length
        cards +=`

          <div class="col-6 col-lg-3 my-1">
            <div class="card shadow" >
              <img src="/${val.image}" class="card-img-top" alt="...">
              <div class="card-body">
                  <h5 class="card-title">${val.name}</h5>
                  <p class="card-text">${val.brand}</p>
                  <p class="card-text">${val.daily_rent_price}</p>
                  <a href="/make-a-booking/${val.id}" class="btn btn-primary">Rent</a>
              </div>
            </div>
          </div>

        `
    }


    $('#car-list').empty()

    $('#car-list').append(cards)

      
  }


</script>


