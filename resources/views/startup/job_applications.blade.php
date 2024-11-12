<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applications</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card-title {
            color: #007bff;
        }
        .card-footer {
            background-color: transparent;
            border-top: none;
            text-align: center;
        }
        .btn-view, .btn-hire {
            background-color: white;
            border: 2px solid;
        }
        .btn-view {
            color: #007bff;
        }
        .btn-contact {
            background-color: #007bff;
            color: white;
        }
        .btn-hire {
            color: #28a745;
            border-color: #28a745;
        }
        .btn-hire.confirmed {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    @include('startup.nav')

    <div class="container mt-5">
        <h3 class="text-center">Job Applications for Your Company</h3>
        <div id="job-applied-cards" class="row mt-4">
            <!-- Dynamic job application cards will be loaded here -->
        </div>
    </div>

    <!-- Bootstrap Modal for Email -->
    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="emailModalLabel">Interview Invitation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>To:</strong> <span id="applicantEmail"></span></p>
                    <p><strong>Subject:</strong> <span id="emailSubject"></span></p>
                    <p><strong>Message:</strong></p>
                    <textarea id="emailBody" class="form-control" rows="5" readonly></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="sendEmail()">Send</button>
                </div>
            </div>
        </div>
    </div>

    <!-- User Profile Section -->
    <div id="user-profile-section" class="mt-4"></div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            fetchJobApplications();
        });

        // Fetch and display job applications
        function fetchJobApplications() {
            $.ajax({
                url: '/job-applied',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    renderJobCards(data);
                },
                error: function(jqXHR) {
                    showAlert(jqXHR.responseJSON?.error || "Failed to load job applications for your company.");
                }
            });
        }

        // Encode email using Base64
        function encodeEmail(email) {
            return btoa(email);  // Base64 encode the email
        }

        // Render job application cards
        function renderJobCards(applications) {
            const cards = applications.map(application => `
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">${application.job_title}</h5>
                                <button class="btn btn-hire" onclick="showHireModal('${application.id}', '${application.email}', '${application.name}', '${application.company_name}')">Hire</button>
                            </div>
                            <p><strong>Applicant Name:</strong> ${application.name}</p>
                            <p><strong>Email:</strong> ${application.email}</p>
                            <p><strong>Phone:</strong> ${application.phone}</p>
                            <p><strong>Degree:</strong> ${application.degree}</p>
                            <p><strong>Skills:</strong> ${application.skills}</p>
                            <p><strong>Experience:</strong> ${application.experience} years</p>
                            <p><strong>Applied On:</strong> ${new Date(application.created_at).toISOString().split('T')[0]}</p>
                            <p><strong>Company Name:</strong> ${application.company_name}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-around">
                            <a href="${application.resume}" class="btn btn-view" target="_blank">View Resume</a>
                            <a href="javascript:void(0);" class="btn btn-contact" onclick="fetchUserProfile('${application.email}')">View Profile</a>
                        </div>
                    </div>
                </div>
            `).join('');
            $('#job-applied-cards').html(cards);
        }

        // Show modal with email content
        function showHireModal(applicationId, applicantEmail, applicantName, companyName) {
            const messageSubject = `Interview Call for ${applicantName}`;
            const messageBody = `Dear ${applicantName},\n\nWe are pleased to invite you for an interview regarding your application for the position. Please let us know your availability.\n\nBest Regards,\n${companyName}`;

            // Set email content in modal
            $('#applicantEmail').text(applicantEmail);
            $('#emailSubject').text(messageSubject);
            $('#emailBody').text(messageBody);

            // Show modal
            $('#emailModal').modal('show');
        }

        // Function to send the email (opens Gmail)
        function sendEmail() {
            const applicantEmail = $('#applicantEmail').text();
            const emailSubject = $('#emailSubject').text();
            const emailBody = $('#emailBody').val();

            // Construct the Gmail compose URL
            const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${applicantEmail}&su=${encodeURIComponent(emailSubject)}&body=${encodeURIComponent(emailBody)}`;

            // Open Gmail compose window
            window.open(gmailUrl, '_blank');

            // Optionally, hide the modal after sending the email
            $('#emailModal').modal('hide');
            showAlert('Email draft opened in Gmail.', 'success');
        }

        // Function to show alerts
        function showAlert(message, type = 'danger') {
            const alertDiv = $(`<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>`);
            $('body').prepend(alertDiv);
            setTimeout(() => alertDiv.alert('close'), 3000);
        }

        
    </script>
</body>
</html>
