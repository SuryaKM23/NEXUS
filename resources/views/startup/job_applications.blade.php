<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applications</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light background */
        }
        .card {
            border: none; /* Remove card border */
            height: 100%; /* Ensure equal height for all cards */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card-title {
            color: #007bff; /* Bootstrap primary color */
        }
        .card-body {
            padding-bottom: 0;
        }
        .card-footer {
            background-color: transparent;
            border-top: none;
            text-align: center;
        }
    </style>
</head>
<body>
    @include('startup.nav')
    <div class="container mt-5">
        <h3 class="text-center">Job Applications for Your Company</h3>
        <div id="job-applied-cards" class="row mt-4">
            <!-- Cards will be dynamically populated here -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // AJAX request to fetch job applications where company_name matches current user's company
            $.ajax({
                url: '/job-applied',  // The route URL
                method: 'GET',        // HTTP method to use for the request
                dataType: 'json',     // Expected data type from the server
                success: function(data) {
                    console.log('Fetched Data:', data); // Log the fetched data
                    let cards = '';   // Variable to store HTML content for cards

                    // Loop through the response data to build each card
                    data.forEach(function(application) {
                        cards += `
                            <div class="col-md-4">
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">${application.job_title}</h5>
                                        <p class="card-text"><strong>Applicant Name:</strong> ${application.name}</p>
                                        <p class="card-text"><strong>Email:</strong> ${application.email}</p>
                                        <p class="card-text"><strong>Phone:</strong> ${application.phone}</p>
                                        <p class="card-text"><strong>Degree:</strong> ${application.degree}</p>
                                        <p class="card-text"><strong>Skills:</strong> ${application.skills}</p>
                                        <p class="card-text"><strong>Experience:</strong> ${application.experience} years</p>
                                        <p class="card-text"><strong>Applied On:</strong> ${new Date(application.created_at).toISOString().split('T')[0]}</p>
                                        <p class="card-text"><strong>Company Name:</strong> ${application.company_name}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="${application.resume}" class="btn btn-primary" target="_blank">View Resume</a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    // Append the constructed cards to the cards container
                    $('#job-applied-cards').html(cards);
                },
                error: function(jqXHR) {
                    console.error('Error fetching job applications:', jqXHR.responseJSON.error);
                    alert(jqXHR.responseJSON.error || "Failed to load job applications for your company.");
                }
            });
        });
    </script>
</body>
</html>
