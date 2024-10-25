<!-- resources/views/user/jobdetails.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .job-details-container {
            margin-top: 50px;
        }
        .card-header, .card-body {
            font-size: 1.1em;
        }
    </style>
</head>
<body>
    @include('user.nav')
    <div class="container job-details-container">
        <h1 class="mb-4">Job Details</h1>

        <div class="card">
            <div class="card-header">
                <strong>Job Title:</strong> {{ $job->job_title }}
            </div>
            <div class="card-body">
                <p><strong>Company Name:</strong> {{ $job->company_name }}</p>
                <p><strong>Job Description:</strong> {{ $job->job_description }}</p>
                <p><strong>Location:</strong> {{ $job->job_location }}</p>
                <p><strong>Salary:</strong> {{ $job->salary }}</p>
                <p><strong>Application Deadline:</strong> {{ $job->application_deadline}}</p> 
                <p><strong>Job Type:</strong> {{ $job->job_type }}</p>
                <p><strong>Experience Level:</strong> {{ $job->experience_level }}</p>
                <p><strong>Required Skills:</strong> {{ $job->required_skill }}</p>
                <p><strong>Posted On:</strong> {{ $job->created_at->format('Y-m-d') }}</p>
            </div>
            <div class="card-footer text-right">
                <a href="/get-applied-jobs" class="btn btn-secondary">Back to Applied Jobs</a>
            </div>
        </div>
    </div>
</body>
</html>
