

<div class="container my-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div>
                Car List
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#car-add-model">Add </button>
        </div>
        <div class="card-body">


            <div  class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Car image</th>
                                <th scope="col">Car Name</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Model</th>
                                <th scope="col">Year of Manufacture</th>
                                <th scope="col">Car Type</th>
                                <th scope="col">Daily Rent Price</th>
                                <th scope="col">Availability</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbl-body">
        
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>






<!-- Add Modal -->
<div class="modal fade" id="car-add-model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="car-mole-title">Create</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="car-add-model-body">

                <form class="row g-3" onsubmit="AddCar(event)" enctype="multipart/form-data">

                    <div class="col-12 col-lg-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name">
                    </div>

                    <div class="col-12 col-lg-6">
                        <label for="file" class="form-label">Image</label>
                        <input type="file" class="form-control form-control-sm" id="file" name="file">
                    </div>

                    <div class="col-12 col-lg-6">
                        <label for="daily_rent_price" class="form-label">Daily Rent Price</label>
                        <input type="number" class="form-control form-control-sm" id="daily_rent_price" name="daily_rent_price">
                    </div>
    
                    <div class="col-12 col-lg-6">
                        <label for="year" class="form-label">Year of Manufacture</label>
                        <input type="number" class="form-control form-control-sm" id="year" name="year">
                    </div>
    
    
                    <div class="col-12 col-lg-6">
                        <label for="CarBrand" class="form-label">Select Brand</label>
    
                        <select class="form-select form-select-sm" aria-label="" id="CarBrand" name='brand'>
                            <option selected>Select Brand</option>

                            @foreach ( $brands as $brand)

                            <option value="{{$brand}}">{{$brand}}</option>
                                
                            @endforeach()
                        </select>
                    </div>
    
                    <div class="col-12 col-lg-6">
                        <label for="CarModel" class="form-label">Select Model</label>
    
                        <select class="form-select form-select-sm" aria-label="" id="CarModel" name='model'>
                            <option selected>Select Model</option>

                            @foreach ( $models as $model)

                            <option value="{{$model}}">{{$model}}</option>
                                
                            @endforeach()
                        </select>
                    </div>
    
                    <div class="col-12 col-lg-6">
                        <label for="CarType" class="form-label">Select Car Type</label>
    
                        <select class="form-select form-select-sm" aria-label="" id="CarType" name='car_type'>
                            <option selected>Select Brand</option>

                            @foreach ( $car_types as $car_type)

                                <option value="{{$car_type}}">{{$car_type}}</option>
                                
                            @endforeach()
    
                        </select>
                    </div>
    
                    <div class="col-12 col-lg-6">
                        <label for="available" class="form-label">Select Availability</label>
    
                        <select class="form-select form-select-sm" aria-label="" id="available" name='availability'>
    
                            <option></option>
                            <option value="1">Available</option>
                            <option value="0">Not Available</option>
                        </select>
                    </div>

                    <div class="modal-footer col-12">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </form>




            </div>
            
        </div>
    </div>
</div>








<!-- Edit Modal -->
<div class="modal fade" id="car-edit-model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="car-edit-model-title">Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body" id="car-edit-model-body">

        <form class="needs-validation" novalidate onsubmit="updateCar(event)">

            <div id="car-edit-form-input"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
            </div>
        </form>



    </div>
    
    </div>
</div>
</div>

<!-- delete Modal -->
<div class="modal fade" id="car-del-model" tabindex="-1" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="del-car-mole-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body" id="del-car-edit-model-body"></div>
    
    </div>
</div>
</div>




<script src="{{asset('assets/js/checkAuth.js')}}"></script>


<script>

    async function AddCar(e){
        e.preventDefault()

        let form = e.target

        // Create a new FormData object
        let formData = new FormData();
        let name = form.name.value;
        let file = form.file.files[0];
        let dailyRentPrice = form.daily_rent_price.value;
        let year = form.year.value;

        let model = form.model.value;
        let brand = form.brand.value;


        let car_type = form.car_type.value;
        let daily_rent_price = form.daily_rent_price.value;
        let availability = form.availability.value;

        // Append form data to FormData object
        formData.append('name', name);
        formData.append('file', file);
        formData.append('daily_rent_price', dailyRentPrice);
        formData.append('year', year);

        formData.append('car_type', car_type);

        formData.append('model', model);
        formData.append('brand', brand);


        formData.append('daily_rent_price', daily_rent_price);
        formData.append('availability', availability);



        await axios.post(`/admin/car/`, formData)
        .then(res=>{

            $("#car-add-model").modal("hide");

            $('#tbl-body').empty()
            CartList()
        })
        .catch(err=>{
            console.log(err)
        })


    }



    async function CartList(){
        let res=await axios.get(`/admin/car`);

        let tbl_body = ''


        for(let val of res.data.data){
            let active_rent_lenght = val.active_rent.length
            tbl_body +=`
                <tr>
                    <td><img height='48px' src='${val.image}'/></td>
                    <td>${val.name}</td>
                    <td>${val.brand}</td>
                    <td>${val.model}</th>
                    <td>${val.year}</td>
                    <td>${val.car_type}</td>
                    <td>${val.daily_rent_price}</td>
                    <td>${val.availability == 1 ? 'Available' : 'Not Available'}</td>
                    <td class=''>
                        <div class='d-flex'>
                            <button type="button" class="btn btn-primary btn-sm" onclick='editcar(${val.id})'>Edit</button>
                            <button type="button" class="btn btn-danger btn-sm ms-2" onclick="deletCarPopup(${val.id}, '${val.name}')">delete</button>
                        </div>
                    </td>

                </tr>
            `
        }

        $('#tbl-body').append(tbl_body)
    }

    async function editcar(id){
        let res=await axios.get(`/admin/car/${id}`);

        let data = res.data.data

        if(data){
            let form = document.getElementById('car-edit-form')

            $('#car-edit-model-title').html(data.name)

            $("#car-edit-form-input").html(`
            <input type='hidden' value="${data.id}" name='id'>
                <div class="mb-3">
                    <label for="daily_rent_price" class="form-label">Daily Rent Price</label>
                    <input type="number" class="form-control form-control-sm" id="daily_rent_price" name="daily_rent_price" value="${data.daily_rent_price}">
                </div>

                <div class="mb-3">
                    <label for="year" class="form-label">Year of Manufacture</label>
                    <input type="number" class="form-control form-control-sm" id="year" value="${data.year}" name="year">
                </div>


                <div class="mb-3">
                    <label for="CarBrand" class="form-label">Select Brand</label>

                    <select class="form-select form-select-sm" aria-label="" id="CarBrand" name='brand'>
                        <option selected>Select Brand</option>

                        @foreach ( $brands as $brand)

                            <option value="{{$brand}}" ${data.brand == '{{$brand}}' ? 'selected': ''}>{{$brand}}</option>
                            
                        @endforeach()
                    </select>

                </div>

                <div class="mb-3">
                    <label for="CarModel" class="form-label">Select Model</label>

                    <select class="form-select form-select-sm" aria-label="" id="CarModel" name='model'>
                        <option selected>Select Model</option>

                        @foreach ( $models as $model)

                            <option value="{{$model}}" ${data.model == '{{$model}}' ? 'selected': ''}>{{$model}}</option>
                            
                        @endforeach()
                    </select>


                </div>


                <div class="mb-3">
                    <label for="file" class="form-label">Image</label>
                    <input type="file" class="form-control form-control-sm" id="file" name="file">
                </div>

                <div class="mb-3">
                    <label for="CarType" class="form-label">Select Car Type</label>


                    <select class="form-select form-select-sm" aria-label="" id="CarType" name='car_type'>
                        <option selected>Select Brand</option>

                        @foreach ( $car_types as $car_type)

                            <option value="{{$car_type}}" ${data.car_type == '{{$car_type}}' ? 'selected': ''}>{{$car_type}}</option>
                            
                        @endforeach()
                    </select>


                </div>

                <div class="mb-3">
                    <label for="available" class="form-label">Select Availability</label>

                    <select class="form-select form-select-sm" aria-label="" id="available" name='availability'>

                        <option></option>
                        <option ${data.availability == '1' ? 'selected': ''} value="1">Available</option>
                        <option ${data.availability == '0' ? 'selected': ''} value="0">Not Available</option>
                    </select>
                </div>

            `)

            let myModal = new bootstrap.Modal($('#car-edit-model'), {
                keyboard: false

            })
            myModal.show()

        }


    }

    async function updateCar(e){
        e.preventDefault()

        let id = e.target.id.value

        await axios.post(`/admin/car/${id}/update`, e.target)
        .then(res=>{

            $("#car-edit-model").modal("hide");

            $('#tbl-body').empty()
            CartList()
        })
        .catch(err=>{
            console.log(err)
        })


    }

    function deletCarPopup(id, title){
        

        $('#del-car-mole-title').html(title)

        $("#del-car-edit-model-body").html(`

            <h6>Sure are you want to delete?</h6>
            <div class='d-flex justify-content-end'>
                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal" >Cancel</button>
                <button type="button" class="btn btn-danger btn-sm ms-2" onclick="deleteCar(${id})">Yes Delete</button>
            </div>
        
        `)

        $('#car-del-model').modal('show')
    }

    async function deleteCar(id){
        await axios.delete(`/admin/car/${id}/delete`)
        .then(res=>{
            console.log(res.data)

            $("#car-del-model").modal("hide");

            $('#tbl-body').empty()
            CartList()
        })
        .catch(err=>{
            console.log(err)
        })
    }

    


</script>
