

<div class="container">

    <div class="row justify-content-center mt-3">
        <div class="col-12 col-lg-8">


            <div class="row">
                <div class="col-12 col-lg-7">
                    <div class="img"></div>


                    <div id="car_details" class="mt-2">
                        {{-- <b>Car details:</b>
                        <p>Car Name:</p>
                        <p>Car Brand:</p>
                        <p>Year of Manufacture:</p>
                        <p>Car Type:</p>
                        <p>Daily Rent Price:</p> --}}
                    </div>

                </div>

                <div class="col-12 col-lg-5">

                    @if($is_authenticated)


                        <h2 class="fw-bold">Booking this car </h2>

                        <form class="row gx-3 gy-2 align-items-cente" onsubmit="AddRent(event)">

                            <input type="hidden" name="car_id" value="{{$id}}">

                            <div class="col-sm-6">
                                <label for="available" class="form-label">Start Date</label>

                                <input type="date" name="start_date" class="form-control">
                            </div>

                            <div class="col-sm-6">
                                <label for="available" class="form-label">End Date</label>

                                <input type="date" name="end_date" class="form-control">
                            </div>


                            <div class="">
                                
                                <button type="submit" class="btn btn-primary btn-sm">Rent</button>
                            </div>
                        </form>
                    @else

                    <p class="fw-bold">Please <a href="/login">login</a> then rent a car</p>

                    @endif

                    <h3 class="text-danger hide" id="available_message"></h3>
                    


                </div>
            </div>

        </div>
    </div>
</div>





<script>

    async function AddRent(e){
        e.preventDefault()

        let form = e.target

        await axios.post(`/user/rental`, form)
        .then(res=>{

            alert("Car successfully rented")

        })
        .catch(err=>{
            if(err.status == 401){
                alert("Car is not available for the chosen period.")
            }

            if(err.status == 404){
                alert("Car is not available")
            }
        })


    }






    async function getCar(){


        await axios.get(`/admin/car/{{$id}}`)
        .then(res=>{
            let data = res.data.data

            $("#car_details").html(`
                <b>Car details:</b>
                <p class="text-secondary">Car Name: ${data.name}</p>
                <p class="text-secondary">Car Model: ${data.model}</p>
                <p class="text-secondary">Car Brand: ${data.brand}</p>
                <p class="text-secondary">Year of Manufacture: ${data.year}</p>
                <p class="text-secondary">Car Type: ${data.car_type}</p>
                <p class="text-secondary">Daily Rent Price: ${data.daily_rent_price}</p>
            `)

            $(".img").html(`<img src="/${data.image}" class="rounded img-fluid" alt="">`)

            if(data.availability == 0){
                $("#available_message").html('Not Available')
            }

            
        })
        .catch(err=>{
            console.log(err)
        })


    }

    

</script>


