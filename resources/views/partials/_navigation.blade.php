
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
          <a class="navbar-brand" href="#"><img src="/img/Hilmar300.png" width="81" height="45" alt=""><img src="/img/chemco-logo.png" width="116" height="45" alt=""> Hilmar Cheese Chart Demo</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
              <!--
                <a class="nav-link" href="/">Search
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/about">About Us</a>
              </li>
--> 
@if(Auth::check())
              <li class="nav-item">
                <a class="nav-link" href="/upload">Upload/Add</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/events">Events</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/logout">Logout</a>
              </li>
@else
<!--
              <li class="nav-item">
                <a class="nav-link" href="/login">Login</a>
              </li>
-->
@endif
            </ul>
          </div>
        </div>
      </nav>
