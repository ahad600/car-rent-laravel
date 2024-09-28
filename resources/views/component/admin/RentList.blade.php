

<div class="container my-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div>
                Rent List
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rental-add-model">Add </button>
        </div>
        <div class="card-body">

            <div  class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Rental ID</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Car Details (Name, Brand)</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Total Cost</th>
                                <th scope="col">Status</th>
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
<div class="modal fade" id="rental-add-model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="rental-mole-title">Add Rent</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="rental-add-model-body">

                <form class="" onsubmit="AddRent(event)">

                    <div class="mt-3">
                        <label for="user_id" class="form-label">Select Customer</label>
    
                        <select class="form-select form-select-sm" aria-label="" id="user_id" name='user_id'>
                            <option></option>
                            @foreach ($users as $user)
                                <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="mt-3">
                        <label for="CarBrand" class="form-label">Select Car</label>
    
                        <select class="form-select form-select-sm" aria-label="" id="CarBrand" name='car_id'>
                            <option></option>
                            @foreach ($cars as $car)
                                <option value="{{ $car['id'] }}">{{ $car['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="available" class="form-label">Select Status</label>

                        <select class="form-select form-select-sm" aria-label="" id="status" name='status'>
                            <option></option>
                            @foreach ($rent_status as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>

                    </div>
    
                    <div class="mb-3">
                        <label for="available" class="form-label">Start Date</label>
    
                        <input type="date" name="start_date" class="form-control">
                    </div>
    
                    <div class="mb-3">
                        <label for="available" class="form-label">End Date</label>
    
                        <input type="date" name="end_date" class="form-control">
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
<div class="modal fade" id="rental-edit-model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="rental-edit-model-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body" id="rental-edit-model-body">

        <form class="needs-validation" novalidate onsubmit="updateRental(event)">

            <div id="rental-edit-form-input">

            </div>
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
<div class="modal fade" id="rental-del-model" tabindex="-1" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="del-rental-mole-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body" id="del-rental-edit-model-body"></div>
    
    </div>
</div>
</div>




<script>

    async function AddRent(e){
        e.preventDefault()

        let form = e.target

        await axios.post(`/admin/rental`, form)
        .then(res=>{

            console.log(res.data)

            $("#rental-add-model").modal("hide");

            $('#tbl-body').empty()
            e.target.reset()
            RentalList()
        })
        .catch(err=>{
            console.log(err.status)
            if(err.status == 401){
                alert("Car already rented")
            }
        })


    }



    async function RentalList(){
        await axios.get(`/admin/rental`)
        .then(res=>{

            let tbl_body = ''

            for(let val of res.data.data){
                let start_date = new Date(val.start_date).toDateString()
                let end_date = new Date(val.end_date).toDateString()
                tbl_body +=`
                    <tr>
                        <td>${val.id}</td>
                        <td>${val.customer_name}</td>
                        <td>${val.name}, ${val.brand}</th>
                        <td>${start_date}</td>
                        <td>${end_date}</td>
                        <td>${val.total_cost}</td>
                        <td>${val.status}</td>
                        <td class=''>
                            <div class='d-flex'>
                                <button type="button" class="btn btn-primary btn-sm" onclick='editRental(${val.id})'>Edit</button>
                                <button type="button" class="btn btn-danger btn-sm ms-2" onclick="deletRentalPopup(${val.id}, '${val.name}')">delete</button>
                            </div>
                        </td>

                    </tr>
                `
            }

            $('#tbl-body').append(tbl_body)
        })
        .catch(err=>{
            
        })
    }

    async function editRental(id){
        let res=await axios.get(`/admin/rental/${id}`);

        let data = res.data.data

        if(data){

            $('#rental-edit-model-title').html(data.name)

            $("#rental-edit-form-input").html(`

                <input type='hidden' value="${data.id}" name='id'>
                
                <div class="mb-3">
                    <label for="available" class="form-label">Select Status</label>


                    <select class="form-select form-select-sm" aria-label="" id="status" name='status'>
                        <option></option>
                        @foreach ($rent_status as $status)
                            <option ${data.status == '{{ $status }}' ? 'selected': ''} value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>

                </div>

                <div class="mb-3">
                    <label for="available" class="form-label">Start Date</label>

                    <input type="date" name="start_date" class="form-control" value="${data.start_date}">
                </div>

                <div class="mb-3">
                    <label for="available" class="form-label">End Date</label>

                    <input type="date" name="end_date" class="form-control" value="${data.end_date}">
                </div>



            `)

            let myModal = new bootstrap.Modal($('#rental-edit-model'), {
                keyboard: false

            })
            myModal.show()

        }


    }

    async function updateRental(e){
        e.preventDefault()

        let id = e.target.id.value

        await axios.post(`/admin/rental/${id}/update`, e.target)
        .then(res=>{
            console.log(res.data)

            $("#rental-edit-model").modal("hide");

            $('#tbl-body').empty()
            RentalList()
        })
        .catch(err=>{
            console.log(err)
        })


    }

    function deletRentalPopup(id, title){
        

        $('#del-rental-mole-title').html(title)

        $("#del-rental-edit-model-body").html(`

            <h6>Sure are you want to delete?</h6>
            <div class='d-flex justify-content-end'>
                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal" >Cancel</button>
                <button type="button" class="btn btn-danger btn-sm ms-2" onclick="deleteRental(${id})">Yes Delete</button>
            </div>
        
        `)

        $('#rental-del-model').modal('show')
    }

    async function deleteRental(id){
        await axios.delete(`/admin/rental/${id}/delete`)
        .then(res=>{
            console.log(res.data)

            $("#rental-del-model").modal("hide");

            $('#tbl-body').empty()
            RentalList()
        })
        .catch(err=>{
            console.log(err)
        })
    }


</script>
