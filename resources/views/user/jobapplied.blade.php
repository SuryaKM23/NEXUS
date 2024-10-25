<!-- resources/views/user/jobapplied.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Applied Jobs</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Custom styles to increase the font size of job items */
        .list-group-item {
            font-size: 1.2em; /* Adjust the size as needed */
            padding: 15px; /* Increase padding for a larger clickable area */
        }
        strong {
            font-size: 1.1em; /* Make the strong text slightly larger */
        }
    </style>
</head>
<body>
    @include('user.nav')
    <div class="container mt-5">
        <h1>Your Applied Jobs</h1>

        <div id="applied-jobs-list" class="mt-3">
            @if ($appliedJobs->isEmpty())
                <p>No applied jobs found.</p>
            @else
                <ul class="list-group">
                    @foreach ($appliedJobs as $job)
                        <li class="list-group-item">
                            <strong>Job Title:</strong> {{ $job->job_title }}<br>
                            <strong>Company Name:</strong> {{ $job->company_name }}<br>
                            <strong>Date of Posting:</strong> {{ $job->updated_at->format('Y-m-d') }}<br>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

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
                    $('#applied-jobs-list').append('<p>No applied jobs found.</p>');
                } else {
                    response.forEach(function(job) {
                        $('#applied-jobs-list').append(
                            '<li class="list-group-item">' +
                                '<strong>Job Title:</strong> ' + job.job_title + '<br>' +
                                '<strong>Company Name:</strong> ' + job.company_name + '<br>' +
                                '<strong>Date of Posting:</strong> ' + new Date(job.updated_at).toLocaleDateString() +
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
