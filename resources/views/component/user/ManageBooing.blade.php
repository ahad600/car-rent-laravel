

<div class="container my-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div>
                Current and Past bookings
            </div>

        </div>
        <div class="card-body">

            <div  class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Rental ID</th>
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















<script>



    async function RentalList(){
        await axios.get(`/user/rental`)
        .then(res=>{


            let tbl_body = ''

            for(let val of res.data.data){
                let start_date = new Date(val.start_date).toDateString()
                let end_date = new Date(val.end_date).toDateString()
                tbl_body +=`
                    <tr>
                        <td>${val.id}</td>
                        <td>${val.name}, ${val.brand}</th>
                        <td>${start_date}</td>
                        <td>${end_date}</td>
                        <td>${val.total_cost}</td>
                        <td>${val.status}</td>
                        <td class=''>
                            <div class='d-flex'>
                                ${
                                    val.status == 'Booked' ?
                                    
                                    `<button type="button" class="btn btn-danger btn-sm ms-2" onclick="RentalCancel(${val.id})">Cancel</button>`
                                    :
                                    "<b class='text-muted'>N/A</b>"
                                
                                }
                                
                            </div>
                        </td>

                    </tr>
                `
            }


            $('#tbl-body').html(tbl_body)
        })
        .catch(err=>{

            console.log(err)
            
        })
    }


    async function RentalCancel(id){
        await axios.get(`/user/rental/cancel/${id}`)
        .then(res=>{
            RentalList()
        })
        .catch(err=>{

            console.log(err)
            
        })
    }


  






</script>
