<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <img src="{{ asset('logo/startup.jpg') }}" alt="Startup Logo">

  <ul class="nav">
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ url('/Home') }}">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item menu-items" >
        <a class="nav-link" href="{{ url('/accept_page') }}">
            <span class="menu-icon">
                <i class="mdi mdi-account-multiple-plus"></i>
            </span>
            <span class="menu-title">Approval</span>
        </a>
    </li>    

      {{-- <li class="nav-item menu-items">
          <a class="nav-link" href="{{ url('details_manager') }}">
              <span class="menu-icon">
                  <i class="mdi mdi-table-large"></i>
              </span>
              <span class="menu-title">Startup/Investor details</span>
          </a>
      </li> --}}
      
      <li class="nav-item menu-items">
          <a class="nav-link" href="{{ url('startup_details') }}">
              <span class="menu-icon">
                  <i class="mdi mdi-account-card-details"></i>
              </span>
              <span class="menu-title">StartUp Information</span>
          </a>
      </li>
      <li class="nav-item menu-items">
          <a class="nav-link" href="{{ url('investor_details') }}">
              <span class="menu-icon">
                  <i class="mdi mdi-account-card-details"></i>
              </span>
              <span class="menu-title">Investor Information</span>
          </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ url('view_form') }}">
            <span class="menu-icon">
                <i class="mdi mdi-account-multiple-plus"></i>
            </span>
            <span class="menu-title">Add Admin </span>
        </a>
    </li>
  </ul>
</nav>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
