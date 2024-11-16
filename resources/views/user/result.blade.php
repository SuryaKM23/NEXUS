<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search Results</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            color: #333;
            margin-top: 20px;
        }
    
        .container {
            padding-top: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
    
        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #0056b3;
            margin-bottom: 30px;
        }

        /* Search Input Styling */
        .search-input {
            font-size: 1rem;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            width: 100%;
            box-sizing: border-box;
            background-color: #fff;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.2);
        }

        /* Job Card Styles */
        .job-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 30px;
        }

        .job-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    
        .job-title-link {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0056b3;
            text-decoration: none;
            transition: color 0.2s ease;
        }
    
        .job-title-link:hover {
            color: #003366;
        }
    
        .job-card p {
            margin: 5px 0;
            font-size: 1rem;
            color: #555;
        }
    
        
        .btn-apply {
            padding: 12px 25px;
            background-color: #007bff;
            color: #fff;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-top: 10px;
            display: inline-block;
        }
    
        .btn-apply:hover {
            background-color: #0056b3;
        }

        /* Empty State Message */
        .no-jobs-message {
            font-size: 1.2rem;
            color: #dc3545;
            font-weight: bold;
            margin-top: 30px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }

            .job-card {
                padding: 15px;
            }

            .btn-apply {
                padding: 10px 20px;
            }
        }

        /* Card Title Styling */
        .job-card h5 {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
        }

        .job-card p {
            font-size: 1rem;
            color: #666;
        }
    </style>
</head>
<body>
    @include("user.nav")

    <div class="container">
        <h1 class="section-title">Job Search Results for: <span id="search-term">{{ $searchTerm }}</span></h1>

        <!-- Search Bar -->
        

        <div id="job-results" class="row mt-4">
            @if ($jobs->isEmpty())
                <div class="col-12">
                    <p class="no-jobs-message">No jobs found for the search term '{{ $searchTerm }}'.</p>
                </div>
            @else
                @foreach ($jobs as $job)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="job-card">
                            <h5>{{ $job->job_title }}</h5>
                            <p><strong>Company:</strong><a href="/profile/{{ $job->company_name }}"> {{ $job->company_name }}</p></a>
                            <p><strong>Location:</strong> {{ $job->job_location }}</p>
                            <p><strong>Description:</strong> {{ $job->job_description }}</p>
                            <p class="salary"><strong>Salary:</strong> {{ $job->salary }}</p>
                            <p class="deadline"><strong>Deadline:</strong> {{ $job->application_deadline }}</p>
                            <a href="/apply_job/{{ $job->id }}" class="btn-apply">Apply Now</a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</body>
</html>
