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
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            color: #333;
            padding-top: 20px;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #343a40;
            margin: 30px 0 20px;
            text-align: center;
        }

        /* Job Details Container */
        .job-details-container {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        /* Job Details Card */
        .job-details-card {
            max-width: 800px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            transition: box-shadow 0.3s ease;
        }

        .job-details-card:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }

        .job-details-card h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #007bff;
            margin-bottom: 15px;
            text-align: center;
        }

        .job-details-card p {
            font-size: 1rem;
            color: #555;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .detail-label {
            font-weight: bold;
            color: #343a40;
            display: inline-block;
            width: 180px;
        }

        /* Buttons */
        .btn-apply, .btn-back {
            display: inline-block;
            font-size: 1rem;
            padding: 10px 25px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-apply {
            background-color: #28a745;
            color: #fff;
            margin-top: 20px;
        }

        .btn-apply:hover {
            background-color: #218838;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-back {
            background-color: #007bff;
            color: #fff;
            margin-top: 20px;
        }

        .btn-back:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Card Header */
        .card-header {
            background-color: #007bff;
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 15px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .section-title {
                font-size: 1.8rem;
            }
            .job-details-card {
                padding: 20px;
                margin: 10px;
            }
            .job-details-card p {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    @include('user.nav')

    <div class="job-details-container">
        <div class="job-details-card">
            <div class="card-header">Job Details</div>
            <div class="card-body">
                <p><span class="detail-label">Job Title:</span> <span id="job-title"></span></p>
                <p><span class="detail-label">Company Name:</span> <span id="company-name"></span></p>
                <p><span class="detail-label">Job Description:</span> <span id="job-description"></span></p>
                <p><span class="detail-label">Location:</span> <span id="job-location"></span></p>
                <p><span class="detail-label">Salary: </span> $<span id="salary"></span></p>
                <p><span class="detail-label">Application Deadline:</span> <span id="application-deadline"></span></p>
                <p><span class="detail-label">Job Type:</span> <span id="job-type"></span></p>
                <p><span class="detail-label">Experience Level:</span> <span id="experience-level"></span></p>
                <p><span class="detail-label">Required Skills:</span> <span id="required-skills"></span></p>
                <p><span class="detail-label">Posted On:</span> <span id="posted-on"></span></p>
            </div>
            <div class="text-center">
                <a href="/get-applied-jobs" class="btn-back">Back to Applied Jobs</a>
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
                        $('#required-skills').text(data.required_skills);
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
