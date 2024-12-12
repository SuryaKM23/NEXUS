<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }

        .search-box {
            position: relative;
        }

        #search-input {
            display: none;
            transition: all 0.3s ease;
            width: 250px;
            margin-left: 10px;
        }

        .job-item {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            height: 380px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease-in-out;
        }

        .job-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .job-title {
            color: #007bff;
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 15px;
            text-align: center;
            cursor: pointer;
        }

        .job-details p {
            font-size: 0.95rem;
            color: #555;
        }

        .job-actions {
            text-align: center;
            margin-top: auto;
        }

        .job-actions .btn {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
        }

        .no-jobs {
            text-align: center;
            font-size: 1.2rem;
            color: #888;
        }

        @media (max-width: 768px) {
            .job-item {
                height: auto;
            }
        }
    </style>
</head>
<body>
    @include('user.nav')

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="section-title">Available Jobs</h1>

                <!-- Search bar after the heading -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <div class="search-box">
                            <button type="button" class="btn btn-outline-primary" id="search-icon">
                                <i class="bi bi-search"></i>
                            </button>
                            <input type="text" class="form-control" id="search-input" placeholder="Search jobs..." oninput="fetchJobs()">
                        </div>
                    </div>
                    <div>
                        <a href="/get-applied-jobs" class="btn btn-primary">Applied Jobs</a>
                    </div>
                </div>

                <div id="jobs-container" class="row">
                    <div class="col-12 text-center">
                        <p class="no-jobs">Loading jobs...</p>
                    </div>
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
                                    <div class="job-item" data-id="${job.id}">
                                        <div class="job-details">
                                            <h5 class="job-title" data-id="${job.id}">${job.job_title}</h5>
                                             <a href="/profiles/${job.company_name}"><p><h2><strong>${job.company_name}</p></strong></h2></a>
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
                        jobsHtml = '<div class="col-12"><p class="no-jobs">No jobs available at the moment.</p></div>';
                    }
                    $('#jobs-container').html(jobsHtml);

                    // Attach click event to job titles
                    $('.job-title').on('click', function() {
                        const id = $(this).data('id');
                        fetchJobDetails(id);
                    });
                },
                error: function() {
                    $('#jobs-container').html('<p class="text-danger text-center">Error fetching jobs.</p>');
                }
            });
        }

        function fetchJobDetails(jobId) {
            $.ajax({
                url: `{{ url('/get-job-details') }}/${jobId}`,
                type: 'GET',
                success: function(data) {
                    // Handle the job details here (e.g., open a modal, redirect, etc.)
                    console.log(data); // For demonstration
                },
                error: function() {
                    alert('Error fetching job details.');
                }
            });
        }
    </script>
</body>
</html>
