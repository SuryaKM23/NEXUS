<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        @include('investor.nav')
        <body>
           @include('investor.body')
        </body>
        <!-- partial -->
        
        <!-- partial -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    
</body>
@include('investor.footer')
</html>
