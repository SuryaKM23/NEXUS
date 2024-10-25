<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crowdfunding Platform</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"> <!-- Include Bootstrap Icons -->
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
      
        .rippon {
            background-color: #f8f9fa; /* Background color for rippon bar */
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
            height: 400px; /* Increased height for the startup items */
            display: flex;
            flex-direction: column; /* Stack content vertically */
            justify-content: space-between; /* Space content evenly */
        }

        .startup-item p {
            margin: 5px 0; /* Adjust margin for paragraphs */
        }

        /* Decrease the width of the search input */
        #search-input {
            width: 250px; /* Adjust this value to decrease or increase width */
            margin-left: 20px; /* Space between heading and search input */
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="section-title">Fund Raising</h1>
                <div class="d-flex align-items-center">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search-input" placeholder="Search..." oninput="fetchCrowdfundingStartups()">
                        <button class="btn btn-outline-primary" id="search-icon">
                            <i class="bi bi-search"></i> <!-- Search icon -->
                        </button>
                    </div>
                </div>
            </div>
            <div id="startups-container" class="row">
                <p class="col-12">Loading crowdfunding startups...</p>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        fetchCrowdfundingStartups();

        $('#search-icon').on('click', () => {
            $('#search-input').slideToggle(300, function() {
                if ($(this).is(':visible')) $(this).focus();
            });
        });
    });

    function fetchCrowdfundingStartups() {
        const searchQuery = $('#search-input').val();
        $.ajax({
            url: "{{ url('/get-crowdfunding-vc') }}",
            type: 'GET',
            data: { search: searchQuery },
            success: (data) => {
                const startupsHtml = data.length > 0 ? data.map(startup => `
                    <div class="col-md-4 mb-3">
                        <div class="startup-item border p-3">
                            <div class="data-spacing">
                                <h5 class="company-name">${startup.company_name}</h5>
                                <p class="title" style="font-size: 24px; font-weight: bold;">${startup.title}</p>
                                <p>${startup.description}</p>
                                <p><strong>Estimation amount: $</strong> ${startup.estimated_amount}</p>
                                <p><strong>Estimation Turn Over: $</strong> ${startup.estimated_turn_over}</p>
                            </div>
                            <div class="button-container">
                                <a href="${startup.pdf_file}" target="_blank" class="custom-button view-pdf-button">View PDF</a>
                                <a href="#" class="custom-button invest-button">Make Chat</a>
                            </div>
                        </div>
                    </div>
                `).join('') : '<p class="col-12">No available crowdfunding startups at the moment.</p>';
                $('#startups-container').html(startupsHtml);
            },
            error: () => {
                $('#startups-container').html('<p class="text-danger">Error fetching startups.</p>');
            }
        });
    }
</script>
</body>
</html>
