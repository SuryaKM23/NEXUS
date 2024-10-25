<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" rel="stylesheet"> <!-- Bootstrap Icons -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <style>
        .section-title {
            margin-bottom: 20px;
        }
        .search-box {
            position: relative; /* Position relative for absolute elements inside */
        }
        #search-input {
            display: none; /* Hide the input initially */
            transition: all 0.3s ease; /* Smooth transition */
            width: 200px; /* Fixed width for the search input */
            margin-left: 5px; /* Space between button and input */
        }
        .job-item {
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            height: 350px; /* Set fixed height for uniformity */
            display: flex; /* Flex display for layout */
            flex-direction: column; /* Column direction */
            justify-content: space-between; /* Space out child elements */
            transition: box-shadow 0.3s; /* Smooth shadow transition */
        }
        .job-item:hover {
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); /* Shadow on hover */
        }
        .job-details {
            flex-grow: 1; /* Allow this section to grow */
        }
        .job-actions {
            text-align: center; /* Center align buttons */
        }
        .job-actions .btn {
            width: 100%; /* Make the button full width */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Jobs Section -->
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
                        <a href="#" class="btn btn-primary">Applied Jobs</a>
                    </div>
                </div>
                <div id="jobs-container" class="row">
                    <!-- Jobs will be loaded here -->
                    <p class="col-12">Loading jobs...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            fetchJobs(); // Fetch jobs on page load

            // Toggle search input visibility with smooth animation on search icon click
            $('#search-icon').on('click', function() {
                $('#search-input').slideToggle(300, function() {
                    if ($(this).is(':visible')) {
                        $(this).focus(); // Focus on the input when it's shown
                    }
                });
            });
        });

        function fetchJobs() {
            const searchQuery = $('#search-input').val(); // Get the search input value

            $.ajax({
                url: "{{ url('/get-jobs') }}", // URL for fetching jobs
                type: 'GET',
                data: { search: searchQuery }, // Send the search query to the server
                success: function(data) {
                    let jobsHtml = '';
                    if (data.length > 0) {
                        data.forEach(function(job) {
                            jobsHtml += `
                                <div class="col-md-4 mb-3">
                                    <div class="job-item">
                                        <div class="job-details">
                                            <h5>${job.job_title}</h5>
                                            <p>${job.job_description}</p>
                                            <p><strong>Location:</strong> ${job.job_location}</p>
                                            <p><strong>Salary:</strong> ${job.salary}</p>
                                        </div>
                                        <div class="job-actions">
                                            <a href="apply_job" class="btn btn-primary">Apply Now</a>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        jobsHtml = '<p class="col-12">No available jobs at the moment.</p>';
                    }
                    $('#jobs-container').html(jobsHtml);
                },
                error: function() {
                    $('#jobs-container').html('<p class="text-danger">Error fetching jobs.</p>');
                }
            });
        }
    </script>
</body>
</html>
