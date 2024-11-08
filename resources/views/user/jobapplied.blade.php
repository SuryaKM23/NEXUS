<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Applied Jobs</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Global styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9ecef;
            padding-top: 50px;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 40px;
            text-align: center;
        }

        .container {
            max-width: 1200px;
        }

        /* Card and list styling */
        .card {
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            background-color: #fff;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            font-weight: 600;
            border-radius: 10px 10px 0 0;
            padding: 20px;
        }

        .list-group-item {
            border: none;
            padding: 25px;
            background-color: #fafafa;
            font-size: 1.1rem;
            color: #495057;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .list-group-item:hover {
            background-color: #f1f1f1;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .list-group-item strong {
            font-weight: 600;
            color: #343a40;
        }

        .details-link {
            font-size: 1.1rem;
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .details-link:hover {
            color: #0056b3;
        }

        .no-jobs-message {
            font-size: 1.2rem;
            color: #6c757d;
            text-align: center;
            margin-top: 50px;
        }

        .btn-back {
            background-color: #007bff;
            color: #fff;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 25px;
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-top: 30px;
        }

        .btn-back:hover {
            background-color: #0056b3;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        /* Donation Item Styles */
        .donation-item {
            background: linear-gradient(to right, #ffffff, #f8f9fa);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            border-left: 5px solid #007bff;
        }

        .donation-item:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .donation-item h5 {
            color: #007bff;
            font-weight: bold;
        }

        .donation-item p {
            margin: 5px 0;
            color: #495057;
        }

        #no-donations-message {
            display: none;
            text-align: center;
            font-style: italic;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            .list-group-item {
                padding: 18px;
                font-size: 1rem;
            }
        }

        /* Navbar Styling */
        .navbar {
            background-color: #343a40;
            border-radius: 0;
        }

        .navbar-brand {
            color: #fff;
            font-weight: 600;
        }

        .navbar-nav .nav-link {
            color: #fff;
            font-size: 1.1rem;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
   @include('user.nav')
    <div class="container mt-5">            
        <h1>Your Applied Jobs</h1> 
        <div id="applied-jobs-list">
            @if ($appliedJobs->isEmpty())
                <p class="no-jobs-message">You haven't applied to any jobs yet.</p>
            @else
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($appliedJobs as $job)
                            <li class="donation-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Job Title:</strong> {{ $job->job_title }}<br>
                                    <strong>Company Name:</strong> {{ $job->company_name }}<br>
                                    <strong>Date of Posting:</strong> {{ $job->updated_at->format('Y-m-d') }}<br>
                                </div>
                                <a href="{{ route('job.details', ['job_id' => $job->job_id]) }}" class="details-link">View Details</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        

    <script>
        $(document).ready(function() {
            // Fetch applied jobs on page load or whenever needed
            $.ajax({
                url: '{{ route("get.applied.jobs") }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#applied-jobs-list').empty();

                    if (response.length === 0) {
                        $('#applied-jobs-list').append('<p class="no-jobs-message">You haven’t applied to any jobs yet.</p>');
                    } else {
                        response.forEach(function(job) {
                            $('#applied-jobs-list').append(
                                '<li class="donation-item d-flex justify-content-between align-items-center">' +
                                    '<div>' +
                                        '<strong>Job Title:</strong> ' + job.job_title + '<br>' +
                                        '<strong>Company Name:</strong> ' + job.company_name + '<br>' +
                                        '<strong>Date of Posting:</strong> ' + new Date(job.updated_at).toLocaleDateString() +
                                    '</div>' +
                                    '<a href="/job/details/' + job.job_id + '" class="details-link">View Details</a>' +
                                '</li>'
                            );
                        });
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('An error occurred while fetching applied jobs.');
                }
            });
        });
    </script>
</body>
</html>
