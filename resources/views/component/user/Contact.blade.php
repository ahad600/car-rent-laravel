


<div>


    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-lg-6">
                
                <div class="shadow">
                    <div class="alert alert-primary border-0 rounded-0" role="alert">
                        Contact Us
                      </div>

                    <form action="" class="p-3" onsubmit="sendMessage(event)">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
        
                            <input type="text" name="name" class="form-control" required>
                        </div>



                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
        
                            <input type="email" name="email" class="form-control" required>
                        </div>
    
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
        
                            <textarea class="form-control" rows="7" col="5" name="message">


                            </textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm w-100">SUBMIT</button>

                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- <script src="{{asset('assets/js/checkAuth.js')}}"></script> --}}

    <script>
        async function sendMessage(e){
            e.preventDefault()

            await axios.post(`/user/contact`, e.target)
            .then(res=>{
                console.log(res.data)

            })

            .catch(err=>{
                if(err.status == 401){
                    console.log("Send message fail")
                }
            })
            
        }

    </script>
</div>



