



<div class="container my-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div>
                Customer List
            </div>
        

        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cutomer-add-model">Add </button>
        </div>
        <div class="card-body">

            <div  class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Rental History</th>
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
<div class="modal fade" id="cutomer-add-model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="cutomer-mole-title">Create</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="cutomer-add-model-body">

                <form class="" onsubmit="AddCustomer(event)">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
    
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
    
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Passowrd</label>
    
                        <input type="password" name="password" class="form-control" required>
                    </div>
    
                    <div class="mb-3">
                        <label for="number" class="form-label">Number</label>
    
                        <input type="text" name="number" class="form-control">
                    </div>
    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
    
                        <textarea type="text" name="address" class="form-control"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </form>




            </div>
            
        </div>
    </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="cutomer-edit-model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="cutomer-edit-model-title">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="cutomer-edit-model-body">

            <form class="needs-validation" novalidate onsubmit="updateCustomer(event)">

                <div id="cutomer-edit-form-input">

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
<div class="modal fade" id="cutomer-del-model" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="del-cutomer-mole-title">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="del-cutomer-edit-model-body"></div>
        
        </div>
    </div>
</div>


<!-- View rent history Modal -->
<div class="modal fade" id="history-model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-body" id="history-model-body">
            <ul class="list-group">
            </ul>
        </div>
        
        </div>
    </div>
</div>








<script src="{{asset('assets/js/checkAuth.js')}}"></script>

<script>

    async function AddCustomer(e){
        e.preventDefault()

        let form = e.target

        await axios.post(`/admin/customer`, form)
        .then(res=>{

            console.log(res.data)

            $("#cutomer-add-model").modal("hide");

            $('#tbl-body').empty()
            CustomerList()
        })
        .catch(err=>{
            console.log(err)
        })


    }



    async function CustomerList(){
        await axios.get(`/admin/customer`)
        .then(res=>{


            let tbl_body = ''

            for(let val of res.data.data){
                let start_date = new Date(val.start_date).toDateString()
                let end_date = new Date(val.end_date).toDateString()
                tbl_body +=`
                    <tr>
                        <td>${val.name}</td>
                        <td>${val.email}</td>
                        <td>${val.number}</td>
                        <td>${val.address}</td>
                        <td><button type="button" class="btn btn-primary btn-sm" onclick='ViewHistory(${val.id})'>View</button></td>
                        <td class=''>
                            <div class='d-flex'>
                                <button type="button" class="btn btn-primary btn-sm" onclick='editCustomer(${val.id})'>Edit</button>
                                <button type="button" class="btn btn-danger btn-sm ms-2" onclick="deletCustomerPopup(${val.id}, '${val.name}')">delete</button>
                            </div>
                        </td>

                    </tr>
                `
            }

            $('#tbl-body').append(tbl_body)
        })
        .catch(err=>{
            console.log(err)
        })
    }

    async function editCustomer(id){
        let res=await axios.get(`/admin/customer/${id}`);

        let data = res.data.data

        if(data){

            $('#cutomer-edit-model-title').html(data.email)

            $("#cutomer-edit-form-input").html(`

                <input type='hidden' value="${data.id}" name='id'>
                
                <div class="mb-3">
                    <label for="available" class="form-label">Name</label>

                    <input type="text" name="name" class="form-control" value="${data.name}">
                </div>

                <div class="mb-3">
                    <label for="available" class="form-label">Number</label>

                    <input type="text" name="number" class="form-control" value="${data.number}">
                </div>

                <div class="mb-3">
                    <label for="available" class="form-label">Address</label>

                    <textarea type="text" name="address" class="form-control" value="${data.address}"></textarea>
                </div>

            `)

            let myModal = new bootstrap.Modal($('#cutomer-edit-model'), {
                keyboard: false

            })
            myModal.show()

        }


    }

    async function updateCustomer(e){
        e.preventDefault()

        let id = e.target.id.value

        await axios.post(`/admin/customer/${id}/update`, e.target)
        .then(res=>{
            console.log(res.data)

            $("#cutomer-edit-model").modal("hide");

            $('#tbl-body').empty()
            CustomerList()
        })
        .catch(err=>{
            console.log(err)
        })

    }

    function deletCustomerPopup(id, title){
        

        $('#del-cutomer-mole-title').html(title)

        $("#del-cutomer-edit-model-body").html(`

            <h6>Sure are you want to delete?</h6>
            <div class='d-flex justify-content-end'>
                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal" >Cancel</button>
                <button type="button" class="btn btn-danger btn-sm ms-2" onclick="deleteCustomer(${id})">Yes Delete</button>
            </div>
        
        `)

        $('#cutomer-del-model').modal('show')
    }

    async function deleteCustomer(id){
        await axios.delete(`/admin/customer/${id}/delete`)
        .then(res=>{
            $("#cutomer-del-model").modal("hide");

            $('#tbl-body').empty()
            CustomerList()
        })
        .catch(err=>{
            console.log(err)
        })
    }




    async function ViewHistory(id){

        $('#history-model').modal('show')

        $(".list-group").html('Loading...')

        await axios.get(`admin/rental/${id}/history`)
        .then(res=>{

            console.log(res.data)

            if(res.data.data.length !== 0){

                $(".list-group").empty()

                for(let elem of res.data.data){

                    let bage = ''


                    if(elem.status == 'Completed'){
                        bage = 'badge bg-success'

                    }
                    else if(elem.status == 'Canceled'){
                        bage = 'badge bg-danger'
                    }
                    else{
                        bage = 'badge bg-primary'
                    }


                    $(".list-group").append(`<li class="list-group-item d-flex justify-content-between"><div>${elem.name}</div> 
                        <div class="${bage}">${elem.status}</div></li>
                        
                    `)
                }
            }
            else{
                    $(".list-group").html('Empty data')
                }

        })
        .catch(err=>{
            console.log(err)
            $(".list-group").html(err)
        })

        



    }


</script>
