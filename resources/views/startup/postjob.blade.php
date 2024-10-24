<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Post Job Vacancy</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .form-title {
            margin-bottom: 30px;
        }

        .form-group label {
            font-weight: bold;
        }

        .custom-button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .custom-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="form-title text-center">Post a Job Vacancy</h1>
        <form id="job-vacancy-form">
            <div class="form-group">
                <label for="job-title">Job Title</label>
                <input type="text" class="form-control" id="job-title" name="job_title" required>
            </div>
            <div class="form-group">
                <label for="company-name">Company Name</label>
                <input type="text" class="form-control" id="company-name" name="company_name" required>
            </div>
            <div class="form-group">
                <label for="job-description">Job Description</label>
                <textarea class="form-control" id="job-description" name="job_description" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="job-location">Job Location</label>
                <input type="text" class="form-control" id="job-location" name="job_location" required>
            </div>
            <div class="form-group">
                <label for="salary">Salary</label>
                <input type="number" class="form-control" id="salary" name="salary" required>
            </div>
            <div class="form-group">
                <label for="application-deadline">Application Deadline</label>
                <input type="date" class="form-control" id="application-deadline" name="application_deadline" required>
            </div>
            <button type="submit" class="custom-button">Post Job Vacancy</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#job-vacancy-form').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Collect form data
                const formData = $(this).serialize();

                // Make an AJAX request to post the job vacancy
                $.ajax({
                    url: "{{ url('/post-job-vacancy') }}", // Update with your server endpoint
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert('Job vacancy posted successfully!');
                        $('#job-vacancy-form')[0].reset(); // Reset the form
                    },
                    error: function(xhr, status, error) {
                        console.error('Error posting job vacancy:', error);
                        alert('Error posting job vacancy. Please try again.');
                    }
                });
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>