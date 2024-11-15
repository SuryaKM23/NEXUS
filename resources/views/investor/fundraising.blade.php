<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fund Raising</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .title {
            font-size: 32px;
        }

        .rippon {
            background-color: #f8f9fa;
            padding: 20px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        .bar {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        .custom-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .view-pdf-button {
            background-color: transparent;
            border: 2px solid #007bff;
            color: #007bff;
        }

        .view-pdf-button:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }

        .invest-button {
            background-color: #007bff;
            color: #fff;
        }

        .invest-button:hover {
            background-color: #0056b3;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .startup-item {
            height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .startup-item p {
            margin: 5px 0;
        }

        #search-input {
            width: 250px;
            margin-left: 20px;
        }

        .profile-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background-color: #1a73e8;
            color: #fff;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            font-size: 24px;
            z-index: 9999;
            transition: background-color 0.3s ease;
        }

        .profile-btn:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .profile-btn {
                bottom: 10px;
                right: 10px;
            }
        }
    </style>
</head>
<body>
    @include("investor.nav")
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="title"><strong>Fund Raising</strong></h1>
                    <div class="d-flex align-items-center">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search-input" placeholder="Search..." oninput="fetchCrowdfundingStartups()">
                            <button class="btn btn-outline-primary" id="search-icon">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="startups-container" class="row">
            <!-- Startups will be populated here by the fetchCrowdfundingStartups() function -->
        </div>
    </div>

    <!-- Popup for Email Confirmation -->
    <div id="email-popup" class="modal fade" tabindex="-1" aria-labelledby="emailPopupLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="emailPopupLabel">Investment Inquiry Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>To:</strong> <span id="popup-to"></span></p>
                    <p><strong>Subject:</strong> Investment Inquiry for <span id="popup-subject"></span></p>
                    <p><strong>Message:</strong> <span id="popup-body"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirm-send-email">Send Email</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(() => {
            fetchCrowdfundingStartups(); // Fetch startups initially
    
            $('#search-icon').on('click', () => {
                $('#search-input').slideToggle(300, function() {
                    if ($(this).is(':visible')) $(this).focus(); // Focus on input after toggle
                });
            });
    
            // Confirm and send email when the user confirms in the modal
            $('#confirm-send-email').on('click', function() {
                const to = $('#popup-to').text();
                const subject = $('#popup-subject').text();
                const body = $('#popup-body').text();
                const emailLink = `https://mail.google.com/mail/?view=cm&fs=1&to=${to}&su=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
                window.location.href = emailLink; // Redirect to Gmail with the pre-filled details
            });
        });
    
        // Function to fetch crowdfunding startups based on search query
        function fetchCrowdfundingStartups() {
            const searchQuery = $('#search-input').val(); // Get search input value
            $.ajax({
                url: "{{ url('/get-crowdfunding-vc') }}", // Endpoint to get crowdfunding startups
                type: 'GET',
                data: { search: searchQuery }, // Send search query as data
                success: (data) => {
                    // Check if the response has data
                    const startupsHtml = data.length > 0 ? data.map(startup => `
                        <div class="col-md-4 mb-3">
                            <div class="startup-item border p-3">
                                <div class="data-spacing">
                                   <a href="/profile/${startup.company_name}"><h5 class="company-name">${startup.company_name}</h5></a>
                                    <p class="title" style="font-size: 24px; font-weight: bold;">${startup.title}</p>
                                    <p>${startup.description}</p>
                                    <p><strong>Estimation amount: </strong> ${startup.estimated_amount}</p>
                                    <p><strong>Estimation Turn Over: </strong> ${startup.estimated_turn_over}</p>
                                </div>
                                <div class="button-container">
                                    <a href="${startup.pdf_file}" target="_blank" class="custom-button view-pdf-button">View PDF</a>
                                    <button class="custom-button invest-button" onclick="openEmailPopup('${startup.company_name}', '${startup.title}')">Contact</button>
                                </div>
                            </div>
                        </div>
                    `).join('') : '<p class="col-12">No available crowdfunding startups at the moment.</p>';
                    $('#startups-container').html(startupsHtml); // Insert the HTML into the container
                },
                error: () => {
                    $('#startups-container').html('<p class="text-danger">Error fetching startups.</p>'); // Show error message if AJAX fails
                }
            });
        }
    
        // Function to open the email confirmation popup
        function openEmailPopup(companyName, title) {
            // Fetch the email for the company
            $.ajax({
                url: "{{ url('/get-startup-investor-email') }}", // Controller method URL
                type: 'GET',
                data: { company_name: companyName }, // Send company name to get the email
                success: (response) => {
                    if (response.email) {
                        // Populate the modal with email and other info
                        $('#popup-to').text(response.email);
                        $('#popup-subject').text(`Investment Inquiry for ${title}`);
                        $('#popup-body').text(`Hello, I am interested in your startup, ${title}. Please provide more information.`);
                        $('#email-popup').modal('show'); // Show the modal
                    } else {
                        alert('Email not found for this company.');
                    }
                },
                error: () => {
                    alert('Error fetching email.');
                }
            });
        }
    </script>
    


    <!-- Bootstrap JS (required for the modal to function) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
