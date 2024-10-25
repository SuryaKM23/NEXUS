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
      background-color: #34495e;
      color: white;
      padding: 10px 20px;
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
      <h3 class="text">Investor</h3>
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