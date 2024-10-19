<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        @include('startup.nav')
        <body>
           @include('startup.body')
        </body>
        <!-- partial -->
        
        <!-- partial -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    
</body>
{{-- @include('startup.footer') --}}
</html>
