<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .profile-container {
            margin-top: 50px;
        }
        .top-container {
            background-color: #007bff; /* Bootstrap primary blue color */
            color: white; /* Change text color to white */
            padding: 20px; /* Add some padding */
            border-radius: 5px; /* Optional: round the corners */
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .bottom-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .left, .right {
            width: 48%;
        }
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }
        #skills, #experience {
            list-style-type: none;
            padding: 0;
        }
        .edit-icon {
            cursor: pointer;
            margin-left: 15px;
            color: #ffc107; /* Optional: change edit icon color */
        }
    </style>
</head>
<body>
    @include('user.nav')

    <div class="container profile-container">
        <h1 class="mb-4">User Profile</h1>

        <div class="top-container">
            <div class="left">
                <img id="profile-pic" src="{{ asset('default-profile.png') }}" alt="Profile Picture" class="profile-pic">
                <h2 id="name">Name</h2>
                <p id="role">Role</p>
                <p id="email">Email</p>
                <p id="phone">Phone Number</p>
                <a href="/path/to/resume.pdf" class="btn btn-primary">Resume</a>
            </div>
            <div class="right text-center">
                <a href="https://linkedin.com" target="_blank">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/01/LinkedIn_Logo.png" alt="LinkedIn" style="width: 50px;">
                </a>
                <span class="edit-icon" id="edit-profile">✏️ Edit Profile</span>
            </div>
        </div>

        <div class="bottom-container">
            <div class="left">
                <h3>Description</h3>
                <p id="description">Description goes here.</p>

                <h3>Experience</h3>
                <ul id="experience"></ul>
            </div>
            <div class="right">
                <h3>Skills</h3>
                <ul id="skills"></ul>
            </div>
        </div>

        <button id="load-profile" class="btn btn-secondary">Load Profile</button>
    </div>

    <script>
        $(document).ready(function() {
            $('#load-profile').click(function() {
                const userId = "{{ $user->id }}"; // Get the user ID dynamically

                $.ajax({
                    url: `/profile/${userId}`, // Adjust the URL to match your routing
                    method: 'GET',
                    dataType: 'json', // Expecting JSON response
                    success: function(data) {
                        // Populate the profile fields with returned data
                        $('#name').text(data.name);
                        $('#role').text(data.role);
                        $('#email').text(data.email);
                        $('#phone').text(data.phone);
                        $('#description').text(data.description);

                        // Clear existing experience and skills
                        $('#experience').empty();
                        $('#skills').empty();

                        // Populate experience data
                        if (data.experience && data.experience.length > 0) {
                            data.experience.forEach(function(exp) {
                                $('#experience').append(`<li>${exp}</li>`);
                            });
                        } else {
                            $('#experience').append('<li>No experience listed.</li>');
                        }

                        // Populate skills data
                        if (data.skills && data.skills.length > 0) {
                            data.skills.forEach(function(skill) {
                                $('#skills').append(`<li>${skill}</li>`);
                            });
                        } else {
                            $('#skills').append('<li>No skills listed.</li>');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                        alert('Error loading profile data: ' + xhr.responseText);
                    }
                });
            });

            // Handle edit profile click
            $('#edit-profile').click(function() {
                // Show the edit profile modal or redirect to edit profile page
                alert("Edit profile clicked! Implement your edit profile functionality here.");
                // Example: window.location.href = '/profile/edit/' + userId;
            });
        });
    </script>
</body>
</html>
