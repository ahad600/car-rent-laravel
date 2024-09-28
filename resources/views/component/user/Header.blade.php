

<nav class="navbar-expand-lg navbar navbar-dark @if($is_dark) bg-dark @endif" id="nav">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Car Rent</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
      <ul class="navbar-nav">

        @if($role == 'admin')

        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="/dashboard">Amin Panel</a>
        </li>

        @endif

        @if($is_authenticated)


          <li class="nav-item">
            <a class="nav-link " aria-current="page" href="/manage-booking">Manage Booking</a>
          </li>


        @endif

        

        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="/about">About</a>
        </li>

        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="/contact">Contact</a>
        </li>


      </ul>

      @if($is_authenticated)


      <div>

        <b class="me-2 text-white">Well come, {{$name}}</b>

        <button class="btn btn-success" type="button" id="logout_btn">Logout</button>

      </div>


      @else:
        <a class="nav-link btn btn-outline-success text-white" aria-current="page" href="/login">login</a>
      @endif
    </div>

    
  </div>
</nav>