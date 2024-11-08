<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Reset basic styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and container styling */
        body {
            font-family: 'Arial', sans-serif;
        }

        .container {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            margin-top: 50px;
            max-width: 900px;
        }

        /* Heading styling */
        h2 {
            font-size: 2.2rem;
            color: #0056b3;
            margin-bottom: 25px;
            text-align: center;
            font-weight: bold;
        }

        /* Profile details layout */
        #profile-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .profile-column {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Profile picture styling */
        #profile-pic {
            border-radius: 50%;
            border: 5px solid #eaeaea;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .profile-details-column {
            padding-left: 20px;
            width: 60%;
        }

        h4 {
            font-size: 1.5rem;
            color: #0056b3;
            margin-bottom: 15px;
        }

        p {
            font-size: 1rem;
            line-height: 1.8;
            margin-bottom: 12px;
            color: #555;
        }

        strong {
            font-weight: bold;
            color: #333;
        }

        .btn-view-resume,
        .btn-edit-profile {
            background-color: #38a1db;
            color: white;
            border-radius: 30px;
            padding: 10px 30px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-view-resume:hover,
        .btn-edit-profile:hover {
            background-color: #006bb3;
        }

        .social-link img {
            width: 25px;
            margin-right: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #profile-details {
                flex-direction: column;
                text-align: center;
            }

            .profile-column, .profile-details-column {
                width: 100%;
                margin-bottom: 20px;
            }

            #profile-pic {
                width: 120px;
                height: 120px;
            }
        }
    </style>
</head>
<body>
@include("user.nav")
<div class="container">
    <h2>Profile Details</h2>

    <!-- Top Container -->
    <div id="profile-details" class="row">
        <div class="col-md-4 profile-column">
            <h4>Profile Picture</h4>
            <img src="#" alt="Profile Picture" class="img-fluid" id="profile-pic">
        </div>
        <div class="col-md-4 profile-details-column">
            <h4>Details</h4>
            <p><strong>Username:</strong> <span id="username"></span></p>
            <p><strong>Email:</strong> <span id="email"></span></p>
            <p><strong>Headline:</strong> <span id="headline"></span></p>
            <a href="#" class="btn-view-resume" id="resume-btn">View Resume</a>
            <a href="{{ route('showProfileForm') }}" class="btn-edit-profile">Edit Profile</a> <!-- Edit Button -->
        </div>
        <div class="col-md-4 profile-column">
            <p><strong>Website:</strong> <a href="#" id="website" target="_blank"></a></p>
            <p><strong>LinkedIn:</strong> <a href="#" id="linkedin" target="_blank" class="social-link">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a9/LinkedIn_icon.svg" alt="LinkedIn"> 
                <span id="linkedin-text"></span>
            </a></p>
        </div>
    </div>

    <!-- Bottom Container -->
    <div class="row">
        <!-- Left Column -->
        <div class="col-md-6">
            <div class="row">
                <div class="col-12">
                    <h4>Description</h4>
                    <p id="description"></p>
                </div>
                <div class="col-12">
                    <h4>Experience</h4>
                    <p id="experience"></p>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-6">
            <h4>Skills</h4>
            <p id="skills"></p>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Fetch profile details via AJAX
        $.ajax({
            url: '{{ route("user.profile.details") }}',
            type: 'GET',
            success: function(response) {
                if (response.profile) {
                    // Populate fields with profile data
                    $('#username').text(response.profile.username);
                    $('#email').text(response.profile.email);
                    $('#headline').text(response.profile.headline);
                    $('#skills').text(response.profile.skills);
                    $('#experience').text(response.profile.experience);
                    $('#description').text(response.profile.description);
                    $('#website').attr('href', response.profile.website).text(response.profile.website);
                    $('#linkedin').attr('href', response.profile.linkedin_id).text(response.profile.linkedin_id);
                    $('#linkedin-text').text(response.profile.linkedin_id);

                    // If profile picture exists, update the image
                    if (response.profile.profile_pic) {
                        $('#profile-pic').attr('src', "{{ asset('public/profile_pictures') }}/" + response.profile.profile_pic);
                    }

                    // If resume exists, show the resume button
                    if (response.profile.resume) {
                        $('#resume-btn').attr('href', "{{ asset('public/resumes') }}/" + response.profile.resume).show();
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
