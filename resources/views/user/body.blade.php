<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <style>
        .section-title {
            margin-bottom: 20px;
        }
        .search-box {
            position: relative;
        }
        #search-input {
            display: none;
            transition: all 0.3s ease;
            width: 200px;
            margin-left: 5px;
        }
        .job-item {
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            height: 350px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: box-shadow 0.3s;
        }
        .job-item:hover {
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .job-details {
            flex-grow: 1;
        }
        .job-actions {
            text-align: center;
        }
        .job-actions .btn {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="fw-bold section-title">Jobs</h1>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <div class="search-box">
                            <button type="button" class="btn btn-primary" id="search-icon">
                                <i class="bi bi-search"></i>
                            </button>
                            <input type="text" class="form-control" name="txt" id="search-input" placeholder="Search..." oninput="fetchJobs()">
                        </div>
                    </div>
                    <div>
                        <a href="/get-applied-jobs" class="btn btn-primary">Applied Jobs</a>
                    </div>
                </div>
                <div id="jobs-container" class="row">
                    <p class="col-12">Loading jobs...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            fetchJobs(); // Fetch jobs on page load

            $('#search-icon').on('click', function() {
                $('#search-input').slideToggle(300, function() {
                    if ($(this).is(':visible')) {
                        $(this).focus();
                    }
                });
            });
        });

        function fetchJobs(jobId = null) {
            const searchQuery = $('#search-input').val();

            $.ajax({
                url: "{{ url('/get-jobs') }}", // URL for fetching jobs
                type: 'GET',
                data: { search: searchQuery, id: jobId }, // Include job ID if provided
                success: function(data) {
                    let jobsHtml = '';
                    if (data.length > 0) {
                        data.forEach(function(job) {
                            jobsHtml += `
                                <div class="col-md-4 mb-3">
                                    <div class="job-item" data-id="${job.id}"> <!-- Store job ID -->
                                        <div class="job-details">
                                            <h5 class="job-title" data-id="${job.id}">${job.job_title}</h5> <!-- Add data-id to title -->
                                            <p>${job.job_description}</p>
                                            <p><strong>Location:</strong> ${job.job_location}</p>
                                            <p><strong>Salary:</strong> ${job.salary}</p>
                                        </div>
                                        <div class="job-actions">
                                            <a href="/apply_job/${job.id}" class="btn btn-primary">Apply Now</a>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        jobsHtml = '<p class="col-12">No available jobs at the moment.</p>';
                    }
                    $('#jobs-container').html(jobsHtml);

                    // Attach click event to job titles
                    $('.job-title').on('click', function() {
                        const id = $(this).data('id'); // Get job ID from data attribute
                        fetchJobDetails(id); // Fetch job details using the ID
                    });
                },
                error: function() {
                    $('#jobs-container').html('<p class="text-danger">Error fetching jobs.</p>');
                }
            });
        }

        function fetchJobDetails(jobId) {
            $.ajax({
                url: `{{ url('/get-job-details') }}/${jobId}`, // URL for fetching job details
                type: 'GET',
                success: function(data) {
                    // Handle the job details here, e.g., open a modal or redirect to a detail page
                    console.log(data); // For demonstration, log the job details
                },
                error: function() {
                    alert('Error fetching job details.');
                }
            });
        }
    </script>
</body>
</html>
