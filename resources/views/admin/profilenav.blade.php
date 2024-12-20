<style>
    body {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
      background-color: #000000;
      
    }
  
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 60px;
      background-color: #191c24;
      padding: 10px 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      flex-wrap: wrap; /* Allow items to wrap on smaller screens */
    }
  
    .logo {
      font-size: 40px;
      font-weight: bold;
    }
  
    .logo-image {
      width: 180px;
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
      color: white;
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
        <img src="{{ asset('logo/logo.png') }}" width="150px" height="50px" alt="Startup Logo">
      </a>
    </div>
    <ul class="nav">
      {{-- Uncomment and add additional nav items as needed --}}
      {{-- <li class="nav-item menu-items">
        <a class="nav-link" href="{{ url('') }}">
          <span class="menu-icon">
            <i class="mdi mdi-table-large"></i>
          </span>
          <span class="menu-title">Investment</span>
        </a>
      </li> --}}
    </ul>
    <x-app-layout></x-app-layout>
  
  </div>
  