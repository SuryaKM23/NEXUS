<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Custom style for centering the form */
        body, html {
            height: 100%;
            margin: 0;
        }
        .centered-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
        }
        .form-container {
            width: 100%;
            max-width: 600px; /* Set a max-width for larger screens */
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #fff;
        }
        .semi-bold {
            font-weight: 600; /* Set to semi-bold */
        }
    </style>
</head>
<body>
    <div class="container centered-container">
        <div class="form-container">
            <h2 class="semi-bold">Application</h2> <!-- Added semi-bold class here -->
            <form id="job-application-form" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" readonly>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="degree">Degree</label>
                    <input type="text" id="degree" name="degree" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="skills">Skills</label>
                    <input type="text" id="skills" name="skills" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="experience">Experience</label>
                    <input type="text" id="experience" name="experience" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="resume">Upload Resume</label>
                    <input type="file" id="resume" name="resume" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Apply</button>
            </form>
            <div id="response-message" class="mt-3"></div>
        </div>
    </div>

    <script>
        $(document).ready(() => {
            $('#job-application-form').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                let formData = new FormData(this); // Create a FormData object from the form

                $.ajax({
                    url: "{{ route('apply-job') }}", // Make sure this route is defined in your Laravel routes
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        $('#response-message').html('<div class="alert alert-success">' + response.message + '</div>');
                        $('#job-application-form')[0].reset(); // Reset the form
                    },
                    error: (xhr) => {
                        let errorMessage = xhr.responseJSON.message || 'An error occurred while submitting the application.';
                        $('#response-message').html('<div class="alert alert-danger">' + errorMessage + '</div>');
                    }
                });
            });
        });
    </script>
</body>
</html>
