<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
    <title>Applied Jobs</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #eff6fd;
        }
        .h1 {
            font-size: 64px; 
            margin-bottom: 30px; 
            text-align: center; 
            color: #333; 
        }
        .job-box {
            display: flex;
            flex-direction: column; 
            justify-content: space-between; 
            margin: 10px; 
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            padding: 10px; 
        }
        .job-box h4 {
            font-size: 24px; 
            font-weight: bold; 
            margin-bottom: 10px; 
            color: #007bff; 
        }
        .custom-button {
            background-color: #007bff; /* Blue background */
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 5px 0; 
        }
        .custom-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .container {
            max-width: 1200px; /* Set a max-width for the container */
            margin: auto; /* Center the container */
        }
    </style>
</head>
<body>
    
    @include("startup.nav")
    <div class="container mt-4">
        <div id="alert-container"></div> <!-- Alert container -->
        <div class="row">
            <div class="col-12">
                <h1 class="h1">Applied Jobs</h1>
                <div id="applied-jobs-container" class="row">
                    <!-- AJAX content will be loaded here -->
                </div>
            </div>       
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            fetchAppliedJobs(); // Call the function to fetch applied jobs on page load
        });

        function fetchAppliedJobs() {
            $.ajax({
                url: "{{ url('/jobs_applied') }}", // Ensure this URL matches your route in the web.php file
                type: 'GET',
                success: function(response) {
                    let jobsHtml = '';
                    if (response.success && response.data.length > 0) {
                        response.data.forEach(function(job) {
                            jobsHtml += `
                                <div class="job-box col-md-4">
                                    <h4>${job.title}</h4>
                                    <p><strong>Company:</strong> ${job.company_name}</p>
                                    <p><strong>Applied On:</strong> ${new Date(job.pivot.created_at).toLocaleDateString()}</p>
                                    <p><strong>Status:</strong> ${job.pivot.status}</p>
                                    <a href="#" class="custom-button">View Details</a>
                                </div>
                            `;
                        });
                    } else {
                        jobsHtml = '<div class="alert alert-warning">You have not applied for any jobs yet.</div>';
                    }
                    $('#applied-jobs-container').html(jobsHtml);
                },
                error: function() {
                    $('#applied-jobs-container').html('<div class="alert alert-danger">Error fetching applied jobs.</div>');
                }
            });
        }

        function showAlert(message, type) {
            const alertHtml = `<div class="alert alert-${type}" role="alert">${message}</div>`;
            $('#alert-container').html(alertHtml);
            setTimeout(() => {
                $('#alert-container').html(''); // Remove alert after 3 seconds
            }, 3000);
        }
    </script>
</body>
</html>
