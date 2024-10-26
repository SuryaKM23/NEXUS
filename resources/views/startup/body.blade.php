<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Startup Home</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #eff6fd;
        }

        a:hover {
            text-decoration: none;
            color: #00c8ff;
        }

        .msg {
            text-align: left;
            padding: 40px;
            color: #fefefe;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            border-radius: 10px;
        }

        .msg h1, .msg h2 {
            margin: 0 0 20px;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .msg h1 {
            font-size: 42px;
        }

        .msg h2 {
            font-size: 32px;
        }

        .rippon {
            width: 100%;
            height: auto;
            position: relative;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .bar {
            font-size: 20px;
            background-image: url('landingpage/img/header2.jpg'); /* Update with the correct path */
            background-size: cover;
            background-position: center;
            color: #000000;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* text-align: center; */
        }

        .custom-button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-top: 10px;
        }

        .custom-button:hover {
            background-color: #0056b3;
        }

        .ideas-posted h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .view-ideas-link {
            font-size: 16px;
            color: #007bff;
        }

        #recent-ideas-container {
            display: flex; /* Use flexbox for layout */
            flex-wrap: wrap; /* Allow wrapping of items */
            justify-content: center; /* Center items */
            margin-top: 20px; /* Add margin for spacing */
        }

        .idea-box {
    background-color: #ffffffe2;
    width: 350px; /* Increased width */
    height: 400px; /* Maintain the height */
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin: 10px; /* Add margin for spacing */
    display: flex; /* Use flexbox */
    flex-direction: column; /* Align items vertically */
    justify-content: space-between; /* Space items evenly */
}   

        .idea-box h4 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .idea-box p {
            margin-bottom: 10px;
            color: #555;
            text-align: justify;
        }

        .alert {
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .bar {
                padding: 20px;
                font-size: 16px;
            }

            .ideas-posted h1 {
                font-size: 20px;
                text-align: center;
            }

            .idea-box {
                padding: 15px;
            }

            .custom-button {
                font-size: 14px;
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="rippon">
        <div class="bar">
            <h1><b>Post Your Ideas</b></h1>
            <p>Announce new product launches, updates, and partnerships to keep your audience informed and engaged.</p>
            <a href="{{ url('post_ideas') }}" class="custom-button">Post your Idea</a>
        </div>
    </div>

    <div class="container ideas mt-4">
        <div class="row">
            <div class="col-12">
                <div class="ideas-posted">
                    <h1>Recent Ideas
                        <a href="{{ url('viewIdeas') }}" class="view-ideas-link float-right">View All >></a>
                    </h1>
                </div>
                <div id="recent-ideas-container" class="row justify-content-center">
                    <!-- AJAX content will be loaded here -->
                </div>
            </div>       
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Set up CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            fetchRecentIdeas(); // Fetch recent ideas on page load
        });

        function fetchRecentIdeas() {
            $.ajax({
                url: "{{ url('/get-recent-ideas') }}",
                type: 'GET',
                success: function(data) {
                    if (data.length > 0) {
                        let ideasHtml = '';
                        data.forEach(function(recentIdeas) {
                            ideasHtml += `
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="idea-box">
                                        <h4>${recentIdeas.title}</h4>
                                        <p>${recentIdeas.description}</p>
                                        <p><strong>Estimated Amount:₹</strong> ${recentIdeas.estimated_amount}</p>
                                        <p><strong>Estimated Turn Over:₹</strong> ${recentIdeas.estimated_turn_over}</p>
                                        <p><strong>Date of Posting:</strong> ${new Date(recentIdeas.created_at).toLocaleDateString()}</p>
                                        <a href="${recentIdeas.pdf_file}" target="_blank" class="custom-button">View PDF</a>
                                    </div>
                                </div>
                            `;
                        });
                        $('#recent-ideas-container').html(ideasHtml);
                    } else {
                        $('#recent-ideas-container').html('<div class="alert alert-warning">No ideas posted yet.</div>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    $('#recent-ideas-container').html('<div class="alert alert-danger">Error fetching recent ideas.</div>');
                }
            });
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
