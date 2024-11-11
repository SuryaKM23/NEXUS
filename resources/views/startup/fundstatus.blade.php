<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crowdfunding Ideas</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 85px;
            margin-bottom: 30px;
            color: #333;
        }

        /* Card Container */
        #ideas-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .idea {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 400px; /* Fix the height for all cards */
        }

        .idea:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .idea h3 {
            font-size: 1.6rem;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .idea p {
            font-size: 1rem;
            color: #7f8c8d;
            margin-bottom: 10px;
        }

        /* Truncate description to 3 lines */
        .idea p.description {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
            -webkit-line-clamp: 3; /* Limit the description to 3 lines */
            color: #7f8c8d;
        }

        .idea p strong {
            color: #2c3e50;
        }

        /* Top Container (Idea Details) */
        .idea-details {
            flex-grow: 1;
        }

        /* Bottom Container (View Details Button) */
        .details {
            margin-top: 10px;
            display: flex;
            justify-content: center;
        }

        .details a {
            display: inline-block;
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .details a:hover {
            background-color: #2980b9;
        }

        /* No data message */
        .no-ideas {
            text-align: center;
            font-size: 1.2rem;
            color: #e74c3c;
            margin-top: 30px;
        }

        /* Loader */
        .loader {
            text-align: center;
            margin-top: 50px;
        }

        .loader img {
            width: 50px;
        }
    </style>
</head>
<body>
@include("startup.nav")
    <h1><strong>Crowdfunding </strong></h1>
<br>

    <div id="ideas-list">
        <!-- Ideas will be loaded here -->
    </div>

    <div class="no-ideas" id="no-ideas" style="display: none;">
        <p>No crowdfunding ideas found.</p>
    </div>

    <script>
        $(document).ready(function() {
            // Show loader while fetching data
            $('#loader').show();
            $('#ideas-list').hide();
            $('#no-ideas').hide();

            // Fetch crowdfunding ideas via AJAX when the page loads
            $.ajax({
                url: '/get-crowdfunding-startups',  // URL to the controller method
                method: 'GET',
                success: function(data) {
                    // Hide loader after data is fetched
                    $('#loader').hide();

                    // Check if data is returned
                    if (data.length > 0) {
                        let ideasHtml = '';
                        // Loop through the returned data and create HTML for each idea
                        data.forEach(function(idea) {
                            ideasHtml += `
                                <div class="idea">
                                    <!-- Upper Section - Idea Details -->
                                    <div class="idea-details">
                                        <h3>${idea.title}</h3>
                                        <p class="description"><strong>Description:</strong> ${idea.description}</p>
                                        <p><strong>Estimated Amount:</strong> ${idea.estimated_amount}</p>
                                        <p><strong>Turnover:</strong> ${idea.estimated_turn_over}</p>
                                        <p><strong>Date of Post:</strong> ${new Date(idea.created_at).toLocaleDateString()}</p>
                                    </div>

                                    <!-- Bottom Section - View Details Button -->
                                    <div class="details">
                                        <a href="/view-details/${idea.id}" class="view-details-btn">View Details</a>
                                    </div>
                                </div>
                            `;
                        });
                        // Append the ideas HTML to the container
                        $('#ideas-list').html(ideasHtml).show();
                    } else {
                        // If no ideas are found, display a message
                        $('#no-ideas').show();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error if the AJAX request fails
                    console.log('Error fetching data:', error);
                    $('#loader').hide();
                    $('#ideas-list').html('<p>Error fetching data. Please try again later.</p>');
                }
            });
        });
    </script>

</body>
</html>
