<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

    body {
      font-family: Arial, sans-serif;
      color: white;
      background-color: #2c3e50;
    }

    .main-panel {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      
    }

    .addform {
      position: relative;
      max-width: 700px;
      width: 100%;
      background: #ffffff;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      margin: 20px auto;
      margin-top: 50px;
    }

    .addform header {
      font-size: 1.5rem;
      margin-bottom: 0px;
      color: #333;
    }

    .form {
      margin-top: 5px;
    }

    .form .input-box {
      width: 100%;
      margin-bottom: 0px;
      margin-left: auto;
      margin-right: auto;
    }

    .input-box label {
      color: #333;
      display: block;
      text-align: left;
      margin-top: 15px;
    }

    .form :where(.input-box input, .select-box) {
      position: relative;
      height: 50px;
      width: 100%;
      outline: none;
      font-size: 1rem;
      color: #707070;
      margin-top: 8px;
      border: 1px solid #ddd;
      border-radius: 6px;
      padding: 3 15px;
    }

    .input-box input:focus {
      box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
    }

    .form :where(.input-box input, .select-box)::placeholder {
      color: #bbbbbb;
      padding-left: 5px;
    }

    .form .column {
      display: flex;
      column-gap: 15px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .form button {
      height: 55px;
      width: 75%;
      color: #fff;
      font-size: 1rem;
      font-weight: 400;
      margin-top: 30px;
      border: none;
      cursor: pointer;
      transition: all 0.2s ease;
      background: #06A3DA;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }

    .form button:hover {
      background: rgb(56, 127, 250);
    }

    .input_color {
      color: black;
    }

    .footer {
      margin-top: 50px;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    @media (max-width: 768px) {
      .form .column {
        flex-direction: column;
        row-gap: 15px;
      }
    }

    @media (max-width: 480px) {
      .addform {
        width: 100%;
        padding: 15px;
      }

      .form .input-box label {
        font-size: 0.9rem;
      }

      .form :where(.input-box input, .select-box) {
        height: 45px;
        font-size: 0.9rem;
      }

      .form button {
        height: 50px;
        font-size: 0.9rem;
      }
    }

    .message {
      display: none;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      text-align: center;
      font-size: 1rem;
    }

    .message.success {
      background-color: #d4edda;
      color: #155724;
    }

    .message.error {
      background-color: #f8d7da;
      color: #721c24;
    }
  </style>

  @include('admin.css')
</head>

<body>
  <div class="container-scroller">
    @include('admin.sidebar')
    @include('admin.partial')

    <div class="main-panel">
      <div class="content-wrapper">
        @if(session()->has('message'))
          <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session()->get('message') }}
          </div>
        @endif
        <section class="addform">
          <div id="message" class="message"></div>
          <form action="{{ url('/add_form') }}" class="form" method="post" id="add_form">
            @csrf
            <header>Admin</header>
            <div class="input-box">
              <label>Name</label>
              <input type="text" class="input_color" name="name" placeholder="name" required />
            </div>

            <div class="input-box">
              <label>Email Address</label>
              <input type="email" class="input_color" name="email" placeholder="Enter email address" required />
            </div>

            <div class="column">
              <div class="input-box">
                <label>Password</label>
                <input type="password" class="input_color" name="password" placeholder="Enter Password" required />
              </div>
            </div>
            <button type="submit">Submit</button>
          </form>
        </section>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var form = document.getElementById('add_form');
      form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        var formData = {
          name: document.querySelector('input[name="name"]').value,
          email: document.querySelector('input[name="email"]').value,
          password: document.querySelector('input[name="password"]').value
        };

        fetch('{{ url('/add_form') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify(formData)
        })
        .then(response => {
          if (!response.ok) {
            return response.text().then(text => { throw new Error(text) });
          }
          return response.json();
        })
        .then(data => {
          var messageElement = document.getElementById('message');
          messageElement.style.display = 'block';
          if (data.success) {
            messageElement.innerHTML = 'User added successfully';
            messageElement.classList.add('success');
            messageElement.classList.remove('error');
          } else {
            messageElement.innerHTML = 'Message: ' + data.message;
            messageElement.classList.add('error');
            messageElement.classList.remove('success');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          var messageElement = document.getElementById('message');
          messageElement.style.display = 'block';
          messageElement.innerHTML = 'Error: ' + error.message;
          messageElement.classList.add('error');
          messageElement.classList.remove('success');
        });
      });
    });
  </script>
  
</body>
</html>
