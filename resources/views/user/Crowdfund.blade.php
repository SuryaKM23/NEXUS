<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crowdfunding</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <style>
        .section-title { 
            margin-bottom: 20px; 
            font-weight: bold;
            font-size: 24px;
        }
        .search-box { position: relative; }
        #search-input {
            display: none;
            transition: all 0.3s ease;
            width: 200px;
            margin-left: 5px;
        }
        .startup-item {
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            height: 350px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: box-shadow 0.3s;
        }
        .startup-item:hover { box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .startup-actions { text-align: center; }
        .startup-actions .btn { width: 100%; }
        .company-name {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .data-spacing p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    @include('user.nav')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="section-title">Crowdfunding</h1>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <div class="search-box">
                            <button type="button" class="btn btn-primary" id="search-icon">
                                <i class="bi bi-search"></i>
                            </button>
                            <input type="text" class="form-control" id="search-input" placeholder="Search..." oninput="fetchCrowdfundingStartups()">
                        </div>
                    </div>
                    <a href="#" class="btn btn-primary">Funded</a>
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
                url: "{{ url('/get-crowdfunding-startups') }}",
                type: 'GET',
                data: { search: searchQuery },
                success: (data) => {
                    const startupsHtml = data.length > 0 ? data.map(startup => `
                        <div class="col-md-4 mb-3">
                            <div class="startup-item">
                                <div class="data-spacing">
                                    <h5 class="company-name">${startup.company_name}</h5>
                                    <p class="title" style="font-size: 24px; font-weight: bold;">${startup.title}</p>
                                    <p>${startup.description}</p>
                                    <p><strong>Estimation amount: $</strong> ${startup.estimated_amount}</p>
                                    <a href="${startup.pdf_file}" target="_blank" class="custom-button">View PDF</a>
                                </div>
                                <div class="startup-actions">
                                    <a href="#" class="btn btn-primary">Invest Now</a>
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
