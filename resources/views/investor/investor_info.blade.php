<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Global styles */
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      background-color: #2c3e50;
    }

    /* Container styles */
    .container {
      position: relative;
      max-width: 700px;
      width: 100%;
      background: #ffffff;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      margin: 0 auto;
    }

    .container header {
      font-size: 1.5rem;
      color: #333;
      font-weight: 500;
      text-align: center;
    }

    .container .form {
      margin-top: 30px;
    }

    /* Input box styles */
    .input-box {
      width: 100%;
      margin-top: 20px;
    }

    .input-box label {
      color: #333;
    }

    .input-box input {
      height: 50px;
      width: calc(100% - 30px); /* Adjusted width calculation */
      outline: none;
      font-size: 1rem;
      color: #707070;
      margin-top: 8px;
      border: 1px solid #ddd;
      border-radius: 6px;
      padding: 0 15px;
      box-sizing: border-box; /* Added box-sizing property */
    }

    .input-box input:focus {
      box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
    }

    .input-box input::placeholder {
      color: #bbbbbb;
      padding-left: 5px;
    }

    /* Column layout */
    .column {
      display: flex;
      gap: 15px; /* Changed column-gap to gap */
      flex-wrap: wrap;
    }

    /* Gender box styles */
    .gender-box {
      margin-top: 20px;
    }

    .gender-box h3 {
      color: #333;
      font-size: 1rem;
      font-weight: 400;
      margin-bottom: 8px;
    }

    .gender-option {
      display: flex;
      align-items: center;
      gap: 50px; /* Changed column-gap to gap */
      flex-wrap: wrap;
    }

    .gender {
      gap: 5px; /* Changed column-gap to gap */
    }

    /* Select box styles */
    .select-box select {
      height: 50px; /* Adjusted height for consistency */
      width: 100%;
      outline: none;
      border: none;
      color: #707070;
      font-size: 1rem;
      padding: 0 5px; /* Adjusted padding */
      box-sizing: border-box; /* Added box-sizing property */
    }

    /* Button styles */
    button {
      height: 55px;
      width: 100%;
      color: #fff;
      font-size: 1rem;
      font-weight: 400;
      margin-top: 30px;
      border: none;
      cursor: pointer;
      transition: background-color 0.2s ease; /* Simplified transition */
      background-color: #06a3da;
    }

    button:hover {
      background-color: rgb(88, 56, 250);
    }

    /* Message styles */
    #message {
      margin-top: 15px;
      text-align: center;
      font-size: 1rem;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
      .column {
        flex-direction: column;
        gap: 15px;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 15px;
      }

      .container header {
        font-size: 1.2rem;
      }

      .input-box label {
        font-size: 0.9rem;
      }

      .input-box input {
        height: 45px;
        font-size: 0.9rem;
        width: calc(100% - 20px); /* Adjusted width calculation */
      }

      button {
        height: 50px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
  <div class="container-scroller">
    <div class="main-panel">
      <div class="content-wrapper">
        @if(session()->has('message'))
        <div class="alert alert-success">
          {{ session()->get('message') }}
        </div>
        @endif
        <section class="container">
          <header>Add Your Information</header>
          <form action="{{ url('/investor_info') }}" class="form" method="post" id="investor_info">
            @csrf
            <div id="message"></div> <!-- Moved the message div here -->
            <div class="input-box">
              <label>Company Name</label>
              <input type="text" class="input_color" name="company_name" placeholder="Enter Company name" required />
            </div>

            <div class="input-box">
              <label>Email Address</label>
              <input type="email" class="input_color" name="email" placeholder="Enter email address" required />
            </div>
            
            <div class="input-box">
                <label>Founders</label>
                <input type="text" class="input_color" name="founders" placeholder="Enter Founder Name" required />
              </div>
                       
            <div class="input-box">
              <label>Location</label>
              <input type="text" class="input_color" name="location" placeholder="Enter Location" required />
            </div>

            <div class="input-box">
              <label>Website</label>
              <input type="url" class="input_color" name="website" placeholder="Enter Website" required />
            </div>

            <div class="input-box">
              <label>Contact</label>
              <input type="number" class="input_color" name="Phone" placeholder="Enter Phone Number" required />
            </div>
            <button type="submit">Update</button>
          </form>
        </section>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.getElementById('investor_info').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        // Construct the JSON object with form data
        var formData = {
          company_name: document.querySelector('input[name="company_name"]').value,
          email: document.querySelector('input[name="email"]').value,
          founders: document.querySelector('input[name="founders"]').value,
          location: document.querySelector('input[name="location"]').value,
          website: document.querySelector('input[name="website"]').value,
          Phone: document.querySelector('input[name="Phone"]').value,
        };

        // Send a POST request to the server
        fetch('{{ url('/investor_info') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
          },
          body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
          var messageElement = document.getElementById('message');
          if (data.status === 'success') {
            messageElement.innerHTML = 'User added successfully';
            messageElement.style.color = 'green';
          } else {
            messageElement.innerHTML = 'Message: ' + data.message;
            messageElement.style.color = 'red';
          }
        })
        .catch(error => {
          console.error('Error:', error);
          var messageElement = document.getElementById('message');
          messageElement.innerHTML = 'Error: Something went wrong';
          messageElement.style.color = 'red';
        });
      });
    });
  </script>
</body>
</html>
