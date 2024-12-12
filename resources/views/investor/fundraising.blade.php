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
            margin-bottom: 10px;
        }

        .rippon {
            background-color: #f8f9fa;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .bar {
            font-size: 24px;
            text-align: center;
            margin-bottom: 10px;
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
            margin-top: 10px;
        }

        .startup-item {
            height: 380px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .startup-item p {
            margin: 3px 0;
        }

        #search-input {
            width: 250px;
            margin-left: 10px;
        }

        .profile-btn {
            position: fixed;
            bottom: 15px;
            right: 15px;
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
                bottom: 5px;
                right: 5px;
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
            fetchCrowdfundingStartups();

            $('#confirm-send-email').on('click', function () {
                const to = $('#popup-to').text();
                const subject = $('#popup-subject').text();
                const body = $('#popup-body').text();
                const emailLink = `mailto:${to}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
                window.location.href = emailLink;
            });
        });

        function fetchCrowdfundingStartups() {
            const searchQuery = $('#search-input').val();
            const url = searchQuery
                ? "{{ url('/search-crowdfunding-vc') }}"
                : "{{ url('/get-crowdfunding-vc') }}";

            $.ajax({
                url: url,
                type: 'GET',
                data: { search: searchQuery },
                success: (data) => {
                    const startupsHtml = data.length > 0
                        ? data.map(startup => `
                            <div class="col-md-4 mb-3">
                                <div class="startup-item border p-3">
                                    <a href="/profile/${encodeURIComponent(startup.company_name)}"><h5>${startup.company_name}</h5></a>
                                    <p><strong>${startup.title}</strong></p>
                                    <p>${startup.description}</p>
                                    <p><strong>Estimated Amount: $</strong> ${startup.estimated_amount}</p>
                                    <p><strong>Estimated Turnover: $</strong> ${startup.estimated_turn_over}</p>
                                    <div class="button-container">
                                        <a href="${startup.pdf_file}" target="_blank" class="custom-button view-pdf-button">View PDF</a>
                                        <button class="custom-button invest-button" onclick="openEmailPopup('${startup.company_name}', '${startup.title}')">Contact</button>
                                    </div>
                                </div>
                            </div>
                        `).join('')
                        : '<p class="col-12 text-danger">No startups found.</p>';
                    $('#startups-container').html(startupsHtml);
                },
                error: () => {
                    $('#startups-container').html('<p class="col-12 text-danger">Failed to load startups.</p>');
                }
            });
        }

        function openEmailPopup(companyName, title) {
            $.ajax({
                url: "{{ url('/get-startup-investor-email') }}",
                type: 'GET',
                data: { company_name: companyName },
                success: (response) => {
                    if (response.email) {
                        $('#popup-to').text(response.email);
                        $('#popup-subject').text(`Investment Inquiry for ${title}`);
                        $('#popup-body').text(`Hello, I am interested in your startup, ${title}. Please provide more details.`);
                        $('#email-popup').modal('show');
                    } else {
                        alert('Email not found.');
                    }
                },
                error: () => {
                    alert('Error fetching email.');
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
