<style>
  body {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
    background-color: rgb(255, 255, 255);
  }
  
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #ffffff;
    padding: 10px 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    flex-wrap: wrap; /* Allow items to wrap on smaller screens */
  }
  
  .logo {
    font-size: 40px;
    font-weight: bold;
  }

  .nav {
    display: flex;
    list-style-type: none;
    justify-content: flex-start;
    margin: 0;
    padding: 0;
    flex-wrap: wrap; /* Allow wrapping */
  }

  .nav-item {
    margin-right: 20px;
  }

  .nav-link {
    text-decoration: none;
    color: rgb(0, 0, 0);
  }

  .menu-icon {
    margin-right: 5px;
  }

  /* Responsive Styles */
  @media (max-width: 768px) {
    .header {
      flex-direction: column; /* Stack elements vertically on small screens */
      align-items: flex-start; /* Align items to the start */
    }

    .nav {
      flex-direction: column; /* Stack nav items vertically */
      width: 100%; /* Full width for nav items */
    }

    .nav-item {
      margin-right: 0; /* Remove right margin */
      margin-bottom: 10px; /* Add space between items */
    }
  }
</style>

<div class="header">
  <div class="logo">
    <a href="{{ url('/Home') }}">
      <img src="{{ asset('logo/startup.png') }}" width="150px" height="50px" alt="Startup Logo">
    </a>
  </div>
  <ul class="nav">
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ url('post_ideas') }}">
        <span class="menu-icon">
          <i class="mdi mdi-table-large"></i>
        </span>
        <span class="menu-title">Post Ideas</span>
      </a>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ url('post_job') }}">
        <span class="menu-icon">
          <i class="mdi mdi-table-large"></i>
        </span>
        <span class="menu-title">Post Job Vacancy</span>
      </a>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ url('/IdeasDetails') }}">
        <span class="menu-icon">
          <i class="mdi mdi-table-large"></i>
        </span>
        <span class="menu-title">Idea Details</span>
      </a>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ url('/viewJobs') }}">
        <span class="menu-icon">
          <i class="mdi mdi-table-large"></i>
        </span>
        <span class="menu-title">Job Details</span>
      </a>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ url('/job-applied') }}">
        <span class="menu-icon">
          <i class="mdi mdi-table-large"></i>
        </span>
        <span class="menu-title">Recruit</span>
      </a>
    </li>
  </ul>
  <x-app-layout></x-app-layout>
</div>

