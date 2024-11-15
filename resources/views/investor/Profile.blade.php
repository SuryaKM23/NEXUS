<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    @include("investor.nav")
<div class="container mt-5">
    <h2 class="text-center">Edit Profile</h2>
    
    <!-- Display Success and Error Messages -->
    <div id="message" class="mt-3"></div>

    <!-- Profile Edit Form -->
    <form id="editProfileForm" enctype="multipart/form-data" action="{{ route('pro.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group mb-3">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ Auth::user()->name }}" readonly>
        </div>
        
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
        </div>

        <div class="form-group mb-3">
            <label for="headline">Headline</label>
            <input type="text" name="headline" id="headline" class="form-control">
        </div>

        {{-- <div class="form-group mb-3">
            <label for="skills">Skills</label>
            <input type="text" name="skills" id="skills" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="experience">Experience</label>
            <textarea name="experience" id="experience" class="form-control"></textarea>
        </div> --}}

        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="website">Website</label>
            <input type="url" name="website" id="website" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="linkedin_id">LinkedIn Profile</label>
            <input type="url" name="linkedin_id" id="linkedin_id" class="form-control">
        </div>

        {{-- <div class="form-group mb-3">
            <label for="education">Education</label>
            <input type="text" name="education" id="education" class="form-control">
        </div> --}}

        <div class="form-group mb-3">
           
            <input type="file" name="profile_pic" id="profile_pic" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="file">Portfolio</label>
            <input type="file" name="file" id="file" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#editProfileForm').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        
        $.ajax({
            url: "{{ route('pro.update') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                    setTimeout(function() {
                        window.location.href = "{{ route('pro.update') }}";
                    }, 2000); // Redirect to profile details page after 2 seconds
                } else {
                    $('#message').html('<div class="alert alert-danger">Failed to update profile.</div>');
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = '<div class="alert alert-danger"><ul>';
                $.each(errors, function(key, value) {
                    errorMessage += '<li>' + value[0] + '</li>';
                });
                errorMessage += '</ul></div>';
                $('#message').html(errorMessage);
            }
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
