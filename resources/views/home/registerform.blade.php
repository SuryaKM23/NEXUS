<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Startup / Investors</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

     /* .main-panel {
      background-color: white;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 900px;
      width: 100%; 
    } */

    header {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 30px;
      text-align: center;
    }

    .input-box {
      margin-bottom: 20px;
    }

    .input_color {
      width: 90%;
      padding: 7px;
      border: 1px solid #ced4da;
      border-radius: 5px;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .col-spacing {
      padding-right: 15px;
      padding-left: 15px;
    }

    button[type="submit"] {
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      width: 25%;
      font-size: 16px;
    }

    button[type="submit"]:hover {
      background-color: #0056b3;
    }

    select.input_color {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      background-color: white;
    }
  </style>
</head>

<body>
  <div class="main-panel">
    <div class="row">
      <!-- Image Section -->
      <div class="col-md-6 d-flex align-items-center justify-content-center">
        <img src="images/reg.jpg" alt="Registration Image" class="img-fluid"style="max-width: 700px; height: auto;">
      </div>

      <!-- Form Section -->
      <div class="col-md-6">
        <div class="text-center mb-4">
          <img src="logo/startup.jpg" alt="Your Logo" style="max-width: 200px; height: auto;">
        </div>

        <header>Startup / Investors Registration Form</header>
        <form id="registrationForm" class="form" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-6 col-spacing">
              <label>Name</label>
              <input type="text" class="form-control input_color" name="name" placeholder="Name" required />
            </div>
            <div class="form-group col-md-6 col-spacing">
              <label>Company Name</label>
              <input type="text" class="form-control input_color" name="company_name" placeholder="Company Name" required />
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6 col-spacing">
              <label>Email Address</label>
              <input type="email" class="form-control input_color" name="email" placeholder="Email address" required />
            </div>
            <div class="form-group col-md-6 col-spacing">
              <label>Phone</label>
              <input type="tel" class="form-control input_color" name="phone" placeholder="Phone" required />
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6 col-spacing">
              <label>Address</label>
              <input type="text" class="form-control input_color" name="address" placeholder="Address" required />
            </div>
            <div class="form-group col-md-6 col-spacing">
              <label>Country</label>
              <input type="text" class="form-control input_color" name="country" placeholder="Country" required />
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6 col-spacing">
              <label>License no</label>
              <input type="text" class="form-control input_color" name="license_no" placeholder="License No" required />
            </div>
            <div class="form-group col-md-6 col-spacing">
              <label>Startup / Investor</label>
              <select class="form-control input_color" name="usertype" required>
                <option value="">Select</option>
                <option value="startup">Startup</option>
                <option value="investor">Investor</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6 col-spacing">
              <label>Password</label>
              <input type="password" class="form-control input_color" name="password" placeholder="Enter Password" required />
            </div>
            <div class="form-group col-md-6 col-spacing">
              <label>Website</label>
              <input type="text" class="form-control input_color" name="website" placeholder="Website Link" required />
          </div>
          <div class="form-row">
            <div class="form-group col-md-14 col-spacing">
            <label>Profile Picture</label>
            <input type="file" class="form-control-file" name="profile_picture" required />
          </div>
          </div>
          </div>

          <div class="text-center">
            <button type="submit">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function () {
      $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
      $('#registrationForm').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
          type: 'POST',
          url: '{{ route("createregister") }}',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            alert('Registered successfully');
            console.log(response);
            location.reload();
          },
          error: function (error) {
            console.log(error);
            alert('There was an error. Please try again.');
          }
        });
      });
    });
  </script>
</body>
</html>
