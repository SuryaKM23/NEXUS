<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.css')
    <link rel="icon" href="logo/logo.png" type="image/icon type">
  </head>
  <body>
    <div class="container-scroller">
      
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      @include('admin.partial')
     
        <!-- partial -->
        @include('admin.contentWrapper')
          <!-- content-wrapper ends -->
          
          <!-- partial:partials/_footer.html -->
         {{-- @include('admin.footer') --}}
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
  </body>
</html>