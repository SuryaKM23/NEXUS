<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        /* General Styles */
        body {
            background-color: #f9fafb;
            font-family: 'Roboto', sans-serif;
            color: #333;
        }

        .section-title {
            margin-top: 20px;
            font-size: 2.8rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 10px;
        }

        .job-details-container {
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }

        /* Job Details Card */
        .job-details-card {
            padding: 10px;
            max-width: 900px;
            width: 100%;
            transition: transform 0.3s ease;
        }

        .job-details-card:hover {
            transform: translateY(-10px);
        }

        .job-details-card h1 {
            font-size: 2.2rem;
            font-weight: 600;
            color: #007bff;
            text-align: center;
        }

        .job-details-card p {
            font-size: 1.2rem;
            color: #6c757d;
            line-height: 1.8;
            margin: 1px 0;
        }

        .job-details-card strong {
            color: #212529;
            font-weight: 600;
        }

        .btn-apply {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            font-size: 1.1rem;
            padding: 12px 25px;
            border-radius: 30px;
            text-align: center;
            text-decoration: none;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-apply:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .section-title {
                font-size: 2.2rem;
                text-align: center;
            }

            .job-details-card {
                padding: 25px;
                margin: 15px;
            }
        }

        /* Custom Styles */
        .card-header, .card-body {
            font-size: 1.1em;
        }
        .back-btn {
            position: absolute;
            top: 15px;
            left: 15px; /* Adjusting to the left as per your request */
        }
    </style>
</head>
<body>
    @include('user.nav')
        <div class="job-details-container">
            <div class="job-details-card">
                <h1 class="section-title">Job Details</h1>

                <div class="card">
                    <div class="card-header">
                        <strong>Job Title:</strong> <span id="job-title"></span>
                    </div>
                    <div class="card-body">
                        <p><strong>Company Name:</strong> <span id="company-name"></span></p>
                        <p><strong>Job Description:</strong> <span id="job-description"></span></p>
                        <p><strong>Location:</strong> <span id="job-location"></span></p>
                        <p><strong>Salary:</strong> <span id="salary"></span></p>
                        <p><strong>Application Deadline:</strong> <span id="application-deadline"></span></p>
                        <p><strong>Job Type:</strong> <span id="job-type"></span></p>
                        <p><strong>Experience Level:</strong> <span id="experience-level"></span></p>
                        <p><strong>Required Skills:</strong> <span id="required-skills"></span></p>
                        <p><strong>Posted On:</strong> <span id="posted-on"></span></p>
                    </div>
                    <div class="card-footer text-right">
                        <a href="/get-applied-jobs" class="btn btn-secondary">Back to Applied Jobs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const jobId = "{{ $job->id }}"; // Get the job ID from your backend

            // Function to fetch job details using AJAX
            function fetchJobDetails() {
                $.ajax({
                    url: `/job/details/${jobId}`, // Ensure this route is set up in your routes
                    method: 'GET',
                    success: function(data) {
                        // Update the job details in the UI
                        $('#job-title').text(data.job_title);
                        $('#company-name').text(data.company_name);
                        $('#job-description').text(data.job_description);
                        $('#job-location').text(data.job_location);
                        $('#salary').text(data.salary);
                        $('#application-deadline').text(data.application_deadline);
                        $('#job-type').text(data.job_type);
                        $('#experience-level').text(data.experience_level);
                        $('#required-skills').text(data.required_skill);
                        $('#posted-on').text(new Date(data.created_at).toLocaleDateString());
                    },
                    error: function() {
                        alert('Error fetching job details.');
                    }
                });
            }

            // Call the function on page load
            fetchJobDetails();
        });
    </script>
</body>
</html>
