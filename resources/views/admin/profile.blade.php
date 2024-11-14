<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* General and layout styling */
        body { font-family: 'Arial', sans-serif; background-color: #000000; }
        .container { background-color: #fff; border-radius: 10px; padding: 30px; margin-top: 40px; }
        h2 { font-size: 2.2rem; color: #0077b5; margin-bottom: 30px; font-weight: bold; text-align: center; }

        /* Profile Header Styling */
        #profile-header { display: flex;  margin-bottom: 30px; background: #1d1d1d; padding: 35px 0;}
        #profile-pic { border-radius: 100%; width:120px; height: 120px; object-fit:scale-down; border: 3px solid #f0f2f5; background: #fff; text-align: center; }
        .profile-info { text-align: left; padding-left: 20px; }
        .profile-info p { margin: 0; font-size: 1.1rem; color: #ffffff; }
        .btn-edit-profile { background-color: #fff !important; color: #0077b5; padding: 7px 10px !important; border-radius: 5px; }
        .btn-view-resume { background-color: #fff !important; color: #0077b5; padding: 7px 10px !important; border-radius: 5px; margin-top: 10px !important; display: block; width: 120px;}
        .btn-edit-profile:hover, .btn-view-resume:hover { background-color: #005f8f !important; color: #fff;}
        #website, #linkedin { margin-right: 0.5px; }

        /* Bottom Container Styling */
        .section-title { font-size: 1.5rem; color: #0077b5; font-weight: bold; }
        .section-content p { font-size: 1.1rem; color: #555; line-height: 1.6; }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            #profile-header { flex-direction: column; text-align: center; }
            #profile-pic { width: 120px; height: 120px; }
            .profile-info { text-align: center; padding-left: 0; }
        }
    </style>
</head>
<body>
@include("admin.profilenav")

<div class="container-fluid">
    <div id="profile-header">
        <div class="container mt-0 py-0" style="background: transparent;">
            <!-- First Column: Profile Picture -->
            <div class="row">
                <div class="col-md-9 d-flex">
                    <img src="{{ asset('images/images.jpg') }}" alt="Profile Picture" class="img-fluid" id="profile-pic">
                    <div class="profile-info mt-1">
                        <p><strong><span id="username"></span> {{Auth::user()->name }}</strong></p>
                        <p><span id="email"></span>{{Auth::user()->email}}</p>
                        <p><span id="headline"></span>Admin</p>
                        
                    </div>
                </div>

                <!-- Second Column: Profile Details -->

<script>

</script>

</body>
</html>
