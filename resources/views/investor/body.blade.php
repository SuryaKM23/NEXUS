<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }
  
    .rippon {
        overflow: hidden;
        width: 100%;
        height: auto; /* Adjust height to fit content */
        position: relative;
        background: #ffffff;
        padding: 20px; /* Add padding for spacing */
        box-sizing: border-box;
        margin-bottom: 20px; /* Include padding in width calculation */
    }
  
    .bar {
        font-size: 32px;
        text-align: center; /* Center align text */
        margin-bottom: 20px;
         /* Add space below the bar */
    }
  
    .bar h1 {
        margin-bottom: 10px; /* Add space below the heading */
    }
  
    .bar p {
        font-size: 18px; /* Adjust paragraph font size */
        margin: 0; /* Remove default margin for paragraphs */
    }
  
    @media (max-width: 768px) {
        .bar {
            font-size: 24px; /* Adjust font size for smaller screens */
        }
    }
  
    .custom-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff; /* Blue background color */
      color: #fff; /* White text color */
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      text-align: center;
      transition: background-color 0.3s ease; /* Smooth transition for hover effect */
  }
  
  /* Hover effect */
  .custom-button:hover {
      background-color: #0056b3; /* Darker blue on hover */
  }
  
  </style>
  </head>
  <body>
  <div class="rippon">
    <div class="bar">
        <h1><b>Invest your Money </b></h1>
        <p>Investing in startup ideas can yield high returns, drive innovation, and shape the future. However, it's essential to carefully assess risks, market potential, and the startup team's capabilities before committing funds.</p>
        <button class="custom-button">
          <a href="{{  url('') }}">Invest</a>
      </button>
    </div>
    <br>
  </div>
  </body>