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
            background-color: #f7faff;
        }

        a:hover {
            text-decoration: none;
            color: #0069d9;
        }

        .container {
            max-width: auto;
        }

        .header-section {
            background-image: linear-gradient(120deg, #007bff, #00c8ff);
            color: #fff;
            padding: 40px 20px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .header-section h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .header-section p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .header-section .custom-button {
            background-color: #fff;
            color: #007bff;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .header-section .custom-button:hover {
            background-color: #007bff;
            color: #fff;
        }

        .ideas-container {
            padding: 20px;
        }

        .ideas-title {
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 600;
            color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .view-ideas-link {
            font-size: 16px;
            color: #007bff;
            font-weight: 600;
        }

        #recent-ideas-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center; /* Center-aligns the idea boxes */
}

        .idea-box {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 320px;
            transition: transform 0.3s ease;
        }
        .idea-box p {
    margin-bottom: 10px;
    color: #555;
    text-align: justify;
    font-size: 15px;
    display: -webkit-box;
    -webkit-line-clamp: 4; /* Limit to 4 lines */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

        .idea-box:hover {
            transform: translateY(-5px);
        }

        .idea-box h4 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #007bff;
            font-weight: 700;
        }

        .idea-box p {
            margin-bottom: 10px;
            color: #555;
            text-align: justify;
            font-size: 15px;
        }

        .idea-box .custom-button {
            background-color: #007bff;
            color: #fff;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
        }

        .idea-box .custom-button:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-top: 20px;
            font-size: 16px;
            color: #555;
        }

        @media (max-width: 768px) {
            .header-section h1 {
                font-size: 28px;
            }

            .header-section p {
                font-size: 16px;
            }

            .ideas-title {
                font-size: 20px;
                flex-direction: column;
                align-items: flex-start;
            }

            #recent-ideas-container {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="header-section">
        <h1>Post Your Ideas</h1>
        <p>Share your innovations and connect with potential investors to bring your ideas to life.</p>
        <a href="{{ url('post_ideas') }}" class="custom-button">Post your Idea</a>
    </div>
    <div class="container mt-4">
        

        <div class="ideas-container">
            <div class="ideas-title">
                <span>Recent Ideas</span>
                <a href="{{ url('viewIdeas') }}" class="view-ideas-link">View All >></a>
            </div>
            <div id="recent-ideas-container">
                <!-- AJAX content will be loaded here -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            fetchRecentIdeas();
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
                                <div class="idea-box">
                                    <h4>${recentIdeas.title}</h4>
                                    <p>${recentIdeas.description}</p>
                                    <p><strong>Estimated Amount: ₹</strong> ${recentIdeas.estimated_amount}</p>
                                    <p><strong>Estimated Turn Over: ₹</strong> ${recentIdeas.estimated_turn_over}</p>
                                    <p><strong>Date of Posting:</strong> ${new Date(recentIdeas.created_at).toLocaleDateString()}</p>
                                    <a href="${recentIdeas.pdf_file}" target="_blank" class="custom-button">View PDF</a>
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
