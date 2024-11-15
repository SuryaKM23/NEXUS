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
  }

  .logo {
    font-size: 40px;
    font-weight: bold;
  }

  .logo img {
    width: 150px;
    height: auto;
  }

  .nav {
    display: flex;
    list-style-type: none;
    margin: 0;
    padding: 0;
  }

  .nav-item {
    margin-right: 20px;
  }

  .nav-link {
    text-decoration: none;
    color: rgb(0, 0, 0);
    display: flex;
    align-items: center;
  }

  .menu-icon {
    margin-right: 5px;
  }

  .menu-title {
    font-weight: 500;
  }

  /* Hamburger Menu for Small Screens */
  .menu-toggle {
    display: none;
    cursor: pointer;
    font-size: 30px;
  }

  .nav {
    display: flex;
    gap: 20px;
  }

  /* Responsive Styles */
  @media (max-width: 1024px) {
    .header {
      flex-direction: column;
      align-items: flex-start;
    }

    .nav {
      flex-direction: column;
      width: 100%;
      margin-top: 10px;
      align-items: flex-start;
      display: none; /* Hide nav by default */
    }

    .nav-item {
      margin-bottom: 10px;
    }

    .nav-link {
      width: 100%;
      padding: 8px;
      font-size: 14px;
    }

    .logo img {
      width: 120px;
    }

    .menu-toggle {
      display: block;
    }
  }

  @media (max-width: 768px) {
    .header {
      padding: 15px;
    }

    .logo img {
      width: 100px;
    }

    .nav-item {
      margin-bottom: 10px;
    }

    .nav-link {
      font-size: 16px;
    }

    .menu-icon {
      font-size: 18px;
    }
  }

  @media (max-width: 480px) {
    .header {
      padding: 10px;
    }

    .logo img {
      width: 100px;
    }

    .nav-item {
      margin-bottom: 15px;
    }

    .nav-link {
      font-size: 14px;
      padding: 10px;
    }

    .menu-icon {
      font-size: 16px;
    }
  }
</style>

<div class="header">
  <div class="logo">
    <a href="{{ url('/Home') }}">
      <img src="{{ asset('logo/startup.png') }}" alt="Startup Logo">
    </a>
  </div>
  <!-- Hamburger Icon -->
  <div class="menu-toggle" id="menu-toggle">
    &#9776;
  </div>
  <ul class="nav" id="nav-menu">
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/Home') }}">
        <span class="menu-icon">
          <i class="mdi mdi-table-large"></i>
        </span>
        <span class="menu-title">Home</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('post_ideas') }}">
        <span class="menu-icon">
          <i class="mdi mdi-table-large"></i>
        </span>
        <span class="menu-title">Post Ideas</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('post_job') }}">
        <span class="menu-icon">
          <i class="mdi mdi-table-large"></i>
        </span>
        <span class="menu-title">Post Job Vacancy</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/IdeasDetails') }}">
        <span class="menu-icon">
          <i class="mdi mdi-table-large"></i>
        </span>
        <span class="menu-title">Idea Details</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/viewJobs') }}">
        <span class="menu-icon">
          <i class="mdi mdi-table-large"></i>
        </span>
        <span class="menu-title">Job Details</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/job-applied') }}">
        <span class="menu-icon">
          <i class="mdi mdi-table-large"></i>
        </span>
        <span class="menu-title">Recruite</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/get-crowdfunding-startups') }}">
        <span class="menu-icon">
          <i class="mdi mdi-table-large"></i>
        </span>
        <span class="menu-title">Crowdfund Status</span>
      </a>
    </li>
    <li class="nav-item">
        <s<x-app-layout></x-app-layout>
      </a>
    </li>
  </ul>
 
</div>

<script>
  // Toggle the navigation menu when the hamburger icon is clicked
  document.getElementById('menu-toggle').addEventListener('click', function () {
    const navMenu = document.getElementById('nav-menu');
    navMenu.style.display = navMenu.style.display === 'none' || navMenu.style.display === '' ? 'flex' : 'none';
  });
</script>
