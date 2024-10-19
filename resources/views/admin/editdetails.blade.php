<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <head>
       
        <title>Document</title>
        <!-- Bootstrap CSS -->
        {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css" rel="stylesheet"> --}}
        <!-- Other CSS files -->
        <link href="{{ asset('adminpanal/assets/vendors/mdi/css/materialdesignicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('adminpanal/assets/vendors/css/vendor.bundle.base.css') }}" rel="stylesheet">
        <link href="{{ asset('adminpanal/assets/vendors/jvectormap/jquery-jvectormap.css') }}" rel="stylesheet">
        <link href="{{ asset('adminpanal/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
        <link href="{{ asset('adminpanal/assets/vendors/owl-carousel-2/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('adminpanal/assets/vendors/owl-carousel-2/owl.theme.default.min.css') }}" rel="stylesheet">
        <link href="{{ asset('adminpanal/assets/css/style.css') }}" rel="stylesheet">
    </head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c3e50;
        }

        .container-scroller {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .main-panel {
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin: 20px;
        }

        .content-wrapper {
            width: 100%;
        }

        .addform header {
            font-size: 26px;
            margin-bottom: 20px;
            text-align: center;
        }

        .form {
            display: flex;
            flex-direction: column;
        }

        .input-box {
            margin-bottom: 20px;
        }

        .input-box label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .input_color {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .column {
            display: flex;
            flex-direction: column;
        }

        button[type="submit"] {
            padding: 12px 20px;
            font-size: 16px;
            background-color: #079ffd;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #054f7d;
        }

        .alert {
            text-align: center;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert .close {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px; 
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .alert .close:hover {
            color: black;
        }

        @media (max-width: 768px) {
            .main-panel {
                padding: 10px;
            }

            .input-box {
                margin-bottom: 15px;
            }

            button[type="submit"] {
                width: 100%;
                padding: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        @include('admin.sidebar')
        
       
    </div>

   <!-- Vendor JS -->
<script src="{{ asset('adminpanal/assets/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->

<!-- Plugin js for this page -->
<script src="{{ asset('adminpanal/assets/vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('adminpanal/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
<script src="{{ asset('adminpanal/assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
<script src="{{ asset('adminpanal/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('adminpanal/assets/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
<!-- End plugin js for this page -->

<!-- inject:js -->
<script src="{{ asset('adminpanal/assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('adminpanal/assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('adminpanal/assets/js/misc.js') }}"></script>
<script src="{{ asset('adminpanal/assets/js/settings.js') }}"></script>
<script src="{{ asset('adminpanal/assets/js/todolist.js') }}"></script>
<!-- endinject -->

<!-- Custom js for this page -->
<script src="{{ asset('adminpanal/assets/js/dashboard.js') }}"></script>
<!-- End custom js for this page -->

</body>
</html>
