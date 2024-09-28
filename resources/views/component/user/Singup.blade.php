
<div>


    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-lg-5">
                
                <div class="shadow">
                    <div class="alert alert-primary border-0 rounded-0" role="alert">
                        User Singup
                      </div>

                    <form autocomplete="off" class="p-2" onsubmit="Singup(event)">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
        
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
        
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
        
                            <input type="text" name="address" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="number" class="form-label">Number</label>
        
                            <input type="text" name="number" class="form-control" required>
                        </div>
    
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
        
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm password</label>
        
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>

                        

                        <small>Alredy have an account. please <a href="/login">login</a></small>

                        <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">Singup</button>

                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- <script src="{{asset('assets/js/checkAuth.js')}}"></script> --}}

    <script>
        async function Singup(e){
            e.preventDefault()

            let form_data = new FormData()

            if(e.target.password.value !== e.target.confirm_password.value){
                alert("Confirm password doesn't match")
                return
            }

            form_data.append("name", e.target.name.value)

            form_data.append("email", e.target.email.value)

            form_data.append("password", e.target.password.value)

            form_data.append("address", e.target.address.value)

            form_data.append("number", e.target.number.value)



            await axios.post(`/user/singup`, form_data)
            .then(res=>{
                console.log(res.data)
                // window.location.replace("/carList")
                alert("User singup successfully")
                e.target.reset()
            })

            .catch(err=>{
                if(err.status == 401){
                    console.log("login fail")
                }
                console.log(err)
            })
            
        }

    </script>
</div>
