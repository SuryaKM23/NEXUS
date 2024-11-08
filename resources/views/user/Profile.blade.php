<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .profile-card {
            background-color: white;
            border-radius: 15px;
           
            padding: 40px;
            margin-bottom: 30px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-pic {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ddd;
            transition: transform 0.3s;
        }

        .profile-pic:hover {
            transform: scale(1.1);
            border-color: #38a1db;
        }

        .form-control {
            border-radius: 10px;
            box-shadow: none;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .btn-submit {
            background-color: #38a1db;
            color: white;
            border-radius: 30px;
            padding: 12px 30px;
            width: 100%;
            border: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #007bff;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
        }

        .card-body {
            padding: 30px;
        }

        .social-icon {
            width: 30px;
            height: 30px;
            margin-right: 10px;
            transition: transform 0.3s;
        }

        .social-icon:hover {
            transform: scale(1.1);
        }

        .container-top {
            display: flex;
            justify-content: space-between;
        }

        .container-bottom {
            display: flex;
            justify-content: space-between;
        }

        .half-col {
            width: 48%;
        }

        .row .col-md-4, .row .col-md-8 {
            padding-right: 15px;
            padding-left: 15px;
        }
    </style>
</head>
<body>

@include('user.nav')

<div class="container">
    <div class="profile-card">
        <h1 class="profile-header text-primary">Edit Profile</h1>
        <form id="profileForm" enctype="multipart/form-data">
            @csrf

            <!-- Top Container Split into 3 -->
            <div class="container-top">
                <!-- First Part: Profile Picture -->
                <div class="col-md-4 text-center">
                    <div class="mb-4">
                        <label for="profile_pic">Profile Picture</label>
                        <img src="{{ asset('profile_pictures/default.jpg') }}" alt="Profile Picture" class="profile-pic mb-3">
                        <input type="file" class="form-control" id="profile_pic" name="profile_pic" required>
                    </div>
                </div>

                <!-- Second Part: Name, Headline, Email, and Resume -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ Auth::user()->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="headline">Headline</label>
                        <input type="text" class="form-control" id="headline" name="headline" required>
                    </div>
                    <div class="form-group">
                        <label for="file">Resume</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf, .doc, .docx">
                    </div>
                </div>

                <!-- Third Part: Website and LinkedIn with default logos -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="website">Website</label>
                        <input type="url" class="form-control" id="website" name="website">
                    </div>
                    <div class="form-group">
                        <label for="linkedin_id">LinkedIn</label>
                        <div class="d-flex align-items-center">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a7/LinkedIn_logo_initials.png" class="social-icon" alt="LinkedIn">
                            <input type="text" class="form-control" id="linkedin_id" name="linkedin_id">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Container Split into 2 -->
            <div class="container-bottom">
                <!-- Left Part: Description, Experience -->
                <div class="half-col">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="experience">Experience</label>
                        <textarea class="form-control" id="experience" name="experience" rows="4"></textarea>
                    </div>
                </div>

                <!-- Right Part: Skills -->
                <div class="half-col">
                    <div class="form-group">
                        <label for="skills">Skills</label>
                        <input type="text" class="form-control" id="skills" name="skills" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">Submit</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#profileForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '{{ route("checkAndStoreProfile") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        window.location.href = '{{ route("user.profile.details") }}';
                    } else {
                        alert("An error occurred, please try again.");
                    }
                },
                error: function(xhr, status, error) {
                    alert("An error occurred, please try again.");
                }
            });
        });
    });
</script>

</body>
</html>
