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
@include("user.nav")
<div class="container-fluid">
    <!-- Top Container -->
    <div id="profile-header">
        <div class="container mt-0 py-0" style="background: transparent;">
            <!-- First Column: Profile Picture -->
            <div class="row">
            <div class="col-md-9 d-flex">
                <img src="#" alt="Profile Picture" class="img-fluid" id="profile-pic">
                <div class="profile-info mt-1">
                    <p><strong><span id="username"></span></strong></p>
                    <p><strong></strong> <span id="email"></span></p>
                    <p><strong></strong> <span id="headline"></span></p>
                    <a href="#" class="btn-view-resume mt-2" id="resume-btn">View Resume</a>
                </div>
            </div>

            <!-- Second Column: Profile Details -->
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
            <br>
            <p id="experience" class="section-content"></p>
        </div>

        <!-- Right Side: Education and Skills -->
        <div class="col-md-4">
            <p id="education" class="section-content"></p>
            <br>
            <p id="skills" class="section-content"></p>
        </div>
    </div>
    </div>
</div>

<script>
  $(document).ready(function() {
    // Fetch profile details via AJAX
    $.ajax({
        url: '/profile_detail/{email}',
        type: 'GET',
        success: function(response) {
            if (response.profile) {
                const profile = response.profile;
                
                // Populate fields conditionally
                $('#username').text(profile.username || 'N/A');
                $('#email').text(profile.email || 'N/A');
                
                if (profile.headline) $('#headline').text(profile.headline);

                // Education and Experience sections
                if (profile.education) {
                    $('#education').html('<h4 class="section-title">Education</h4>' + profile.education).show();
                } else {
                    $('#education').hide();
                }

                if (profile.experience) {
                    $('#experience').html('<h4 class="section-title">Experience</h4>' + profile.experience).show();
                } else {
                    $('#experience').hide();
                }

                // Description and Skills sections
                if (profile.description) {
                    $('#description').html('<h4 class="section-title">Description</h4>' + profile.description).show();
                } else {
                    $('#description').hide();
                }

                if (profile.skills) {
                    $('#skills').html('<h4 class="section-title">Skills</h4>' + profile.skills).show();
                } else {
                    $('#skills').hide();
                }

                if (response.profile.linkedin_id) {
                            $('#linkedin').html(`
                                <a href="${response.profile.linkedin_id}" target="_blank">
                                    <img src="{{ asset('images/linkedin.png') }}" alt="LinkedIn" width="20">
                                </a>
                            `).show();
                        } else {
                            $('#linkedin').hide();
                        }

                // Profile picture and resume
                if (profile.profile_pic) {
                    $('#profile-pic').attr('src', "{{ asset('profile_pictures/') }}/" + profile.profile_pic);
                } else {
                    $('#profile-pic').attr('src', 'images/images.jpg'); // Optional: Set a default image if not found
                }
                if (profile.file) {
                    $('#resume-btn').attr('href', "{{ asset('resumes/') }}/" + profile.file).show();
                } else {
                    $('#resume-btn').hide();
                }
            } else {
                alert("No profile found!");
            }
        },
        error: function(xhr, status, error) {
            alert("An error occurred while fetching the profile details.");
        }
    });
});
</script>

</body>
</html>
