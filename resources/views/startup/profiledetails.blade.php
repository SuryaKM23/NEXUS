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
        body { font-family: 'Arial', sans-serif; background-color: #f4f7f6; }
        .container { background-color: #fff; border-radius: 10px; padding: 30px; margin-top: 40px; }
        h2 { font-size: 2.2rem; color: #0077b5; margin-bottom: 30px; font-weight: bold; text-align: center; }

        /* Profile Header Styling */
        #profile-header { display: flex; justify-content: space-between; margin-bottom: 30px; border-bottom: 2px solid #e1e4e8;background:#e8e8e8; padding: 35px 0;}
        #profile-pic { border-radius: 100%; width:120px; height: 120px; object-fit:scale-down; border: 3px solid #f0f2f5; background: #fff; text-align: center; }
        .profile-info { text-align: left; padding-left: 20px; }
        .profile-info p { margin: 0; font-size: 1.1rem; color: #555; }
        .btn-edit-profile { background-color: #fff !important; color: #0077b5; padding: 7px 10px !important; border-radius: 5px; }
        .btn-view-resume { background-color: #fff !important; color: #0077b5; padding: 7px 10px !important; border-radius: 5px; margin-top: 10px !important;
    display: block;
    width: 120px;}
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
@include("startup.nav")

<div class="container-fluid">
    {{-- <h2>Profile Details</h2> --}}

    <!-- Top Container -->
    <div id="profile-header">
        <div class="container mt-0 py-0" style="background: transparent;">
            <!-- First Column: Profile Picture -->
            <div class="row">
            <div class="col-md-9 d-flex">
                <img src="#" alt="Profile Picture" class="img-fluid" id="profile-pic">
                <div class="profile-info mt-1">
                    <p><strong> <span id="username"></span></strong></p>
                    <p><strong></strong> <span id="email"></span></p>
                    <p><strong></strong> <span id="headline"></span></p>
                    <a href="#" class="btn-view-resume mt-2" id="resume-btn">View Resume</a>

                </div>
            </div>

            <!-- Second Column: Profile Details -->
        


            <!-- Third Column: Website and LinkedIn -->
            <div class="col-md-3 text-end">
                <p class="d-flex  justify-content-end">
                    <a href="/profile_edit" class="btn-edit-profile me-2">Edit Profile</a>
                </p>
            </div>
            <p class="d-flex text-center justify-content-end">
                <a href="#" id="linkedin" target="_blank" class="mt-2"><img src="{{ asset('images/linkedin.png') }}" alt="LinkedIn" width="20"></a>
            </p>
        </div>
        </div>
    </div>

    <!-- Bottom Container -->
    <div class="container pt-0">
        <div class="row">
        <!-- Left Side: Description and Experience -->
        <div class="col-md-8 pe-5">
            <p id="description" class="section-content text-justify" style="text-align: justify !important;"></p>
            <p id="experience" class="section-content"></p>
        </div>
    </div>
    </div>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route("profiles.details") }}',
                type: 'GET',
                success: function(response) {
                    if (response.profile) {
                        // Update profile details
                        $('#username').text(response.profile.username);
                        $('#email').text(response.profile.email);
    
                        // Handle headline
                        if (response.profile.headline) {
                            $('#headline').html(`<strong>Headline:</strong> ${response.profile.headline}`).show();
                        } else {
                            $('#headline').hide();
                        }
    
                        // Handle description
                        if (response.profile.description) {
                            $('#description').html('<h4 class="section-title">Description</h4>' + response.profile.description).show();
                        } else {
                            $('#description').hide();
                        }
    
                        // Handle LinkedIn ID
                        if (response.profile.linkedin_id) {
                            $('#linkedin').html(`
                                <a href="${response.profile.linkedin_id}" target="_blank">
                                    <img src="{{ asset('images/linkedin.png') }}" alt="LinkedIn" width="20">
                                </a>
                            `).show();
                        } else {
                            $('#linkedin').hide();
                        }
    
                        // Handle profile picture
                        if (response.profile.profile_pic) {
                            $('#profile-pic').attr('src', `/profile_pictures/${response.profile.profile_pic}`);
                        } else {
                            $('#profile-pic').attr('src', 'images/images.jpg'); // Optional: Set a default image if not found
                        }
    
                        // Handle resume
                        if (response.profile.resume) {
                            $('#resume-btn').attr('href', "{{ asset('public/resumes') }}/" + response.profile.resume).show();
                        } else {
                            $('#resume-btn').hide();
                        }
    
                    } else {
                        alert("No profile found!");
                    }
                },
                error: function() {
                    alert("An error occurred while fetching the profile details.");
                }
            });
        });
    </script>
    

</body>
</html>
