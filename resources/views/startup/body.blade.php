<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ideas Posted</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        a:hover {
            text-decoration: none;
            color: #fff;
        }
        .menu-title:hover {
            color: #000000;
        }
        .msg {
            text-align: left;
            padding: 40px;
            color: #fefefe;
            background-size: cover;
            background-position: center;
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
        .msg h5 {
            font-size: 18px;
            color: #ffffff;
            opacity: 70%;
            margin-top: 20px;
        }
        .rippon {
            width: 100%;
            height: 250px;
            position: relative;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .bar {
            font-size: 20px;
            height: 250px;
            background-image: url('landingpage/img/header2.jpg');
            background-size: cover;
            background-position: center;
            color: #000000;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            text-align: center;
        }
        .custom-button:hover {
            background-color: #0056b3;
        }
        .idea-box {
            max-width: 600px;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            text-align: left;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            min-height: 350px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .idea-box h4 {
            margin-top: 0;
            font-size: 20px;
            font-weight: 600;
        }
        .idea-box p {
            font-size: 16px;
            line-height: 1.5;
            flex-grow: 1;
        }
        .post-ideas-button {
            text-align: right;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .post-ideas-button a {
            color: #ffffff;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .post-ideas-button a:hover {
            color: #ffffff;
        }
        .ideas-posted {
            text-align: center;
        }
        @media (max-width: 768px) {
            .bar {
                font-size: 24px;
            }
            .idea-box {
                margin-bottom: 20px;
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
                    <h1>Recent Ideas</h1>
                </div>
                <div id="recent-ideas-container" class="row">
                    <!-- AJAX content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function() {
            fetchRecentIdeas();
        });

        function fetchRecentIdeas() {
            $.ajax({
                url: "{{ url('get-recent-ideas') }}",
                type: 'GET',
                success: function(data) {
                    if (data.length > 0) {
                        let ideasHtml = '';
                        data.forEach(function(recentIdeas) {
                            ideasHtml += `
                                <div class="col-md-4">
                                    <div class="idea-box">
                                        <h4>${recentIdeas.title}</h4>
                                        <p>${recentIdeas.description}</p>
                                        <p><strong>Estimated Amount:</strong> ${recentIdeas.estimated_amount}</p>
                                        <p><strong>Date of Posting:</strong> ${recentIdeas.date_of_posting}</p>
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
                error: function() {
                    $('#recent-ideas-container').html('<div class="alert alert-danger">Error fetching recent ideas.</div>');
                }
            });
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
