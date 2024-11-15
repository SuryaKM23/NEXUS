<style>
  body {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
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

  .logo img {
    width: 150px;
    height: auto; /* Maintain aspect ratio */
  }

  .nav {
    display: flex;
    list-style-type: none;
    justify-content: flex-start;
    margin: 0;
    padding: 0;
    flex-wrap: wrap; /* Allow wrapping on small screens */
  }

  .nav-item {
    margin-right: 20px;
  }

  .nav-link {
    text-decoration: none;
    color: black;
    font-weight: 500;
  }

  .menu-icon {
    margin-right: 5px;
  }

  /* Add hamburger icon for mobile devices */
  .menu-toggle {
    display: none;
    font-size: 30px;
    cursor: pointer;
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
      display: none; /* Hide nav by default */
    }

    .nav-item {
      margin-right: 0; /* Remove right margin */
      margin-bottom: 10px; /* Add space between items */
    }

    .menu-toggle {
      display: block; /* Show hamburger icon on mobile */
    }
  }

  /* Show navigation when menu is active */
  .nav.active {
    display: flex;
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
    &#9776; <!-- Hamburger icon -->
  </div>

  <ul class="nav" id="nav-menu">
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ url('/Home') }}">
        <span class="menu-icon">
          <i class="mdi mdi-table-large"></i>
        </span>
        <span class="menu-title">Home</span>
      </a>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ url('/get-crowdfunding-vc') }}">
        <span class="menu-icon">
          <i class="mdi mdi-table-large"></i>
        </span>
        <span class="menu-title">Investment</span>
      </a>
    </li>
    <!-- Add more nav items here if needed -->
  </ul>

  <x-app-layout></x-app-layout>
</div>

<script>
  // Toggle the navigation menu when the hamburger icon is clicked
  document.getElementById('menu-toggle').addEventListener('click', function() {
    const navMenu = document.getElementById('nav-menu');
    navMenu.classList.toggle('active'); // Toggle the 'active' class to show/hide the nav
  });
</script>
