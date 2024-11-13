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
        #profile-header { display: flex; justify-content: space-between; margin-bottom: 30px; border-bottom: 2px solid #e1e4e8; background: #e8e8e8; padding: 35px 0; }
        #profile-pic { border-radius: 100%; width: 120px; height: 120px; object-fit: scale-down; border: 3px solid #f0f2f5; background: #fff; }
        .profile-info { text-align: left; padding-left: 20px; }
        .profile-info p { margin: 0; font-size: 1.1rem; color: #555; }
        .btn-view-resume { background-color: #fff; color: #0077b5; padding: 7px 10px; border-radius: 5px; display: block; width: 120px; margin-top: 10px; }
        .btn-view-resume:hover { background-color: #005f8f; color: #fff; }
        #website, #linkedin { margin-right: 0.5px; }

        /* Bottom Container Styling */
        .section-title { font-size: 1.5rem; color: #0077b5; font-weight: bold; }
        .section-content p { font-size: 1.1rem; color: #555; line-height: 1.6; }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #profile-header { flex-direction: column; text-align: center; }
            .profile-info { text-align: center; padding-left: 0; }
        }
    </style>
</head>
<body>
@include("startup.nav")
<div class="container-fluid">
    <!-- Top Container -->
    <div id="profile-header">
        <div class="container mt-0 py-0" style="background: transparent;">
            <div class="row">
                <div class="col-md-9 d-flex">
                    <img src="#" alt="Profile Picture" class="img-fluid" id="profile-pic">
                    <div class="profile-info mt-1">
                        <p><strong><span id="username">N/A</span></strong></p>
                        <p><strong>Email: </strong><span id="email">N/A</span></p>
                        <p><strong>Headline: </strong><span id="headline">N/A</span></p>
                        <a href="#" class="btn-view-resume mt-2" id="resume-btn" style="display: none;">View Resume</a>
                    </div>
                </div>
                <p class="d-flex text-center justify-content-end">
                    <a href="#" id="linkedin" target="_blank" style="display: none;"><img src="{{ asset('images/linkedin.png') }}" alt="LinkedIn" width="20"></a>
                </p>
            </div>
        </div>
    </div>

    <!-- Bottom Container -->
    <div class="container pt-0">
        <div class="row">
            <div class="col-md-8 pe-5">
                <div id="description" class="section-content"></div>
                <div id="experience" class="section-content"></div>
            </div>
            <div class="col-md-4">
                <div id="education" class="section-content"></div>
                <div id="skills" class="section-content"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const email = "{{ request()->route('email') }}";  // Use Blade to inject the email from the route

        // Fetch profile details via AJAX
        $.ajax({
            url: '/profile_detail/' + encodeURIComponent(email),
            type: 'GET',
            success: function(response) {
                if (response.profile) {
                    const profile = response.profile;
                    $('#username').text(profile.username || 'N/A');
                    $('#email').text(profile.email || 'N/A');
                    $('#headline').text(profile.headline || '');

                    // Education and Experience sections
                    $('#education').html(profile.education ? `<h4 class="section-title">Education</h4>${profile.education}` : '').toggle(!!profile.education);
                    $('#experience').html(profile.experience ? `<h4 class="section-title">Experience</h4>${profile.experience}` : '').toggle(!!profile.experience);
                    
                    // Description and Skills sections
                    $('#description').html(profile.description ? `<h4 class="section-title">Description</h4>${profile.description}` : '').toggle(!!profile.description);
                    $('#skills').html(profile.skills ? `<h4 class="section-title">Skills</h4>${profile.skills}` : '').toggle(!!profile.skills);

                    // LinkedIn
                    $('#linkedin').attr('href', profile.linkedin_id).toggle(!!profile.linkedin_id);

                    // Profile picture and resume
                    $('#profile-pic').attr('src', profile.profile_pic ? `{{ asset('profile_pictures/') }}/${profile.profile_pic}` : 'images/images.jpg');
                    $('#resume-btn').attr('href', `{{ asset('resumes/') }}/${profile.file}`).toggle(!!profile.file);
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
