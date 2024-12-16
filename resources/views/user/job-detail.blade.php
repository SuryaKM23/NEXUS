<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            background-color: #f4f7fa;
            font-family: 'Arial', sans-serif;
            color: #000000;
        }
    
        .container {
            margin-top: 40px;
        }
    
        .job-details-container {
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }
    
        /* Section Title */
        .section-title {
            margin-top: 20px;
            font-size: 2.8rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 10px;
            text-align: center;
        }
    
        /* Job Details Card */
        .job-details-card {
            padding: 20px;
            max-width: 900px;
            width: 100%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            border-radius: 8px;
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
            color: #000000;
            line-height: 1.8;
            margin: 1px 0;
        }
    
        .job-details-card strong {
            color: #212529;
            font-weight: 600;
        }
    
        /* Card Header */
        .card-header {
            background-color: #007bff;
            color: #fff;
            font-size: 1.2rem;
            padding: 20px;
        }
    
        /* Card Body */
        .card-body {
            padding: 30px;
            font-size: 1.1rem;
            line-height: 1.6;
        }
    
        /* Card Footer */
        .card-footer {
            padding: 15px;
            background-color: #f7f9fc;
            text-align: right;
        }
    
        /* Buttons */
        .btn-secondary {
            background-color: #0088ff;
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
    
        .btn-secondary:hover {
            background-color: #5a6268;
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
        .back-btn {
            position: absolute;
            top: 15px;
            left: 15px; /* Adjusting to the left as per your request */
        }
    </style>
    
</head>
<body>
    <!-- Navigation -->
    @include("user.nav")
    
    <div class="container">
        <h1 class="section-title text-center">Job Details</h1>
        
        <div class="job-details-container">
            <!-- Job Details Card -->
            <div class="job-details-card" id="job-details">
                <!-- Job details will be dynamically inserted here via AJAX -->
                @if(isset($job))
                    <h1>{{ $job->job_title }}</h1>
                    <h3>Job Description</h3>
                    <p>{{ $job->job_description }}</p>
                    <p><strong>Company:</strong> {{ $job->company_name }}</p>
                    <p><strong>Location:</strong> {{ $job->job_location }}</p>
                    <p><strong>Salary:</strong> {{ $job->salary }}</p>
                    <div class="apply-now-wrapper">
                        <a href="/apply_job/{{ $job->id }}" class="btn-apply">Apply Now</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const jobId = {{ $job->id ?? 'null' }};  // Dynamically get the job ID from the PHP view data

            // Check if jobId is available for AJAX request
            if (jobId !== null) {
                $.ajax({
                    url: `/job-detail/${jobId}`,
                    method: 'GET',
                    success: function(response) {
                        // Populate the job details if it's an AJAX response
                        if (response.job_title) {
                            $('#job-details').html(`
                                <h1>${response.job_title}</h1>
                                <h3>Job Description</h3>
                                <p>${response.job_description}</p>
                                <a href="/profiles/${response.company_name}" style="text-decoration: none; color: inherit;">
                                    <h5><strong>Company Name:</strong> ${response.company_name}</h5></a>
                                <p><strong>Location:</strong> ${response.job_location}</p>
                                <p><strong>Salary: $</strong> ${response.salary}</p>
                                <div class="apply-now-wrapper">
                                    <a href="/apply_job/${response.id}" class="btn-apply">Apply Now</a>
                                </div>
                            `);
                        }
                    },
                    error: function(error) {
                        console.log('Error fetching job details:', error);
                    }
                });
            }
        });
    </script>
</body>
</html>
