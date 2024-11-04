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
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Adding shadow */
  }
  
  .logo {
    font-size: 40px;
    font-weight: bold;
  }

  .nav {
    display: flex;
    list-style-type: none;
    justify-content: flex-start; /* Updated to flex-start */
    margin: 0;
    padding: 0;
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
        <span class="menu-title">Post Job Vacency</span>
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
<x-app-layout>
        </x-app-layout>
        </li>
      </div>
    </nav>