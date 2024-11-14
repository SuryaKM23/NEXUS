<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search & Crowdfunding</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        /* General Styling */
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        h1, h2, h3, h4 {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Section Titles */
        .section-title, .crowdfunding-title {
            font-size: 3rem;
            font-weight: 100;
            text-transform: uppercase;
            color: #1a73e8;
            /* margin-bottom: 40px; */
            text-align: center;
            letter-spacing: 1.5px;
            transition: margin-top 0.5s ease-in-out;
        }
        
        /* Search Box Styling */
        .search-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        
        .search-box {
            position: relative;
            width: 100%;
            max-width: 500px;
            padding-left: 15px;
        }
        
        #search-input {
            width: 100%;
            padding: 15px 20px;
            font-size: 1.2rem;
            border-radius: 10px;
            border: 2px solid #f3f3f3;
            background-color: #fff;
            /* box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); */
            transition: all 0.3s ease;
        }
        
        #search-input:focus {
            border-color: #1a73e8;
            outline: none;
            box-shadow: 0 0 15px rgba(26, 115, 232, 0.4);
        }
        
        /* Suggestions List */
        .suggestions-list {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }
        
        .suggestion-item {
            padding: 10px;
            cursor: pointer;
            font-size: 1.2rem;
            color: #333;
        }
        
        .suggestion-item:hover {
            background-color: #1a73e8;
            color: #fff;
        }
        
        /* Crowdfunding Section */
        .crowdfunding-section {
            background-color: #ffffff;
            padding: 40px 0;
            text-align: center;
            border-radius: 8px;
            margin-top: 50px;
        }
        
        .crowdfunding-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a73e8;
            margin-bottom: 20px;
        }
        
        .crowdfunding-info {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 30px;
        }
        
        .crowdfunding-btn {
            display: inline-block;
            padding: 15px 30px;
            font-size: 1.2rem;
            font-weight: 600;
            background-color: #1a73e8;
            color: #fff;
            border-radius: 50px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        
        .crowdfunding-btn:hover {
            background-color: #0056b3;
        }
        
        /* Job Content Section */
        .job-content {
            margin-top: 50px;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
        }
        
        .job-content h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }
        
        .job-content .vc-info, .job-content .startup-info {
            margin-bottom: 30px;
        }
        
        .job-content ul {
            list-style-type: disc;
            padding-left: 20px;
        }
        
        .job-content ul li {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.5;
        }
        
        /* Profile Button */
        .profile-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #1a73e8;
            color: #fff;
            padding: 12px 18px;
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
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .search-container {
                flex-direction: column;
                align-items: center;
            }
        
            .search-box {
                width: 90%;
            }
        
            .crowdfunding-section {
                padding: 30px;
            }
        
            .profile-btn {
                bottom: 10px;
                right: 10px;
            }
        }
        
        /* Styling for the GIF */
        .gif-container img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row align-items-center">
            <div class="col-md-6 col-12">
                <div class="search-container">
                    <div class="search-box mb-4">
                        <h1 class="section-title">Find Job</h1>
                        <input type="text" class="form-control" id="search-input" placeholder="Search" oninput="fetchSuggestions()">
                        <div id="suggestions" class="suggestions-list"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="image">
                    <img src="{{ asset('images/Jobhunt.gif') }}" alt="Job Search GIF" style="width: 100%; max-width: 500px; height: auto;">
                </div>
            </div>
        </div>
    </div>

<!-- Crowdfunding Section -->
<div class="crowdfunding-section container">
<h2 class="crowdfunding-title">Crowdfunding for Startups</h2>
<div class="crowdfunding-info">
    <p>Are you a startup looking for funding? Contribute to our crowdfunding platform and receive the
        support you need to grow your business. Learn more about how we can help you!</p>
</div>
<a href="/getcrowdfundingstartups" class="crowdfunding">
    <button class="btn btn-primary">Start a Contribution Now</button>
</a>
</div>

<!-- Job Content Section -->
<div class="job-content container">
<h2>Job Opportunities & Startups</h2>
<div class="vc-info">
    <h3>About Venture Capitalists (VCs)</h3>
    <ul>
        <li>VCs provide funding for startups and emerging companies in exchange for equity.</li>
        <li>They help startups scale by offering guidance, networking opportunities, and capital.</li>
        <li>VCs are essential players in the startup ecosystem.</li>
    </ul>
</div>
<div class="startup-info">
    <h3>About Startups</h3>
    <ul>
        <li>Startups are newly established businesses focused on innovation and growth.</li>
        <li>They aim to solve real-world problems with cutting-edge technologies.</li>
        <li>Startups often require funding, mentorship, and support to succeed.</li>
    </ul>
</div>
</div>

    <!-- Chatify Button -->
    {{-- <button class="profile-btn" onclick="redirectToChatify()">
        <i class="bi bi-chat"></i>
    </button> --}}

    <script>
        function fetchSuggestions() {
            const searchQuery = $('#search-input').val().trim();
            if (searchQuery.length > 0) {
                $.ajax({
                    url: "{{ route('search.suggestions') }}",
                    type: 'GET',
                    data: { query: searchQuery },
                    success: function(response) {
                        const suggestions = response.suggestions;
                        let suggestionItems = '';
                        if (suggestions.length > 0) {
                            suggestions.forEach(function(suggestion) {
                                suggestionItems += `
                                    <div class="suggestion-item" onclick="selectSuggestion('${suggestion}')">
                                        ${suggestion}
                                    </div>
                                `;
                            });
                            $('#suggestions').html(suggestionItems).show();
                        } else {
                            $('#suggestions').hide();
                        }
                    }
                });
            } else {
                $('#suggestions').hide();
            }
        }

        function selectSuggestion(jobTitle) {
            $('#search-input').val(jobTitle);
            $('#suggestions').hide();
            window.location.href = "{{ route('search.jobs') }}?search=" + jobTitle;
        }

        function redirectToChatify() {
            window.location.href = `/chatify/`;
        }
    </script>
</body>
</html>
