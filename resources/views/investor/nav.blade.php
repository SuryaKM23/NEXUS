<style>
    body {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
      background-color: lightslategray;
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
      color: white;
    }
  
    .menu-icon {
      margin-right: 5px;
    }
  </style>
  
  <div class="header">
    <div class="logo">
        <img src="{{ asset('logo/startup.png') }}" alt="Logo" class="logo-image" width="140px" height="20px">
</div>
    <ul class="nav">
      {{-- <li class="nav-item menu-items">
        <a class="nav-link" href="{{ url('') }}">
          <span class="menu-icon">
            <i class="mdi mdi-table-large"></i>
          </span>
          <span class="menu-title">Investment</span>
        </a>
      </li> --}}
    </ul>
    <x-app-layout>
    </x-app-layout>
          </li>
        </div>
      </nav>