<div>


    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-lg-4">
                
                <div class="shadow">
                    <div class="alert alert-primary border-0 rounded-0" role="alert">
                        User Login
                      </div>

                    <form action="" class="p-2" onsubmit="Login(event)">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
        
                            <input type="email" name="email" class="form-control" required>
                        </div>
    
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
        
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <small>Don't have an account. please <a href="/singup">Singup</a></small>


                        <button type="submit" class="btn btn-primary btn-sm w-100 mt-1">Login</button>

                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- <script src="{{asset('assets/js/checkAuth.js')}}"></script> --}}

    <script>
        async function Login(e){
            e.preventDefault()

            await axios.post(`/user/login`, e.target)
            .then(res=>{
                if(res.data.data.role == 'admin'){
                    window.location.replace("/carList")
                }else{
                    window.location.replace("/")
                }
                
            })

            .catch(err=>{
                if(err.status == 401){
                    alert("User and Password doesn't match")
                }
            })
            
        }

    </script>
</div>
