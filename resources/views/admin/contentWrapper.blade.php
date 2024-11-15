<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        body {
            background-color: #000000;
            font-family: 'Roboto', sans-serif;
            color: #e0e0e0;
        }
        .dashboard-container {
            margin-top: 30px;
            /* margin-left: 30px; Shift towards the left */
        }
        .card {
            border: none;
            border-radius: 10px;
            background-color: #282828;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px; /* Add space between cards */
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
        }
        .chart-container {
            margin-top: 40px;
            border-radius: 10px;
            padding: 30px;
            background-color: #282828;
        }
        h2, h3 {
            font-weight: 700;
        }
        footer {
            margin-top: 50px;
            text-align: center;
            color: #bbb;
            padding: 20px 0;
        }
        @media (max-width: 576px) {
            .card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    
    <div class="container dashboard-container">
        <br><br>
        <h2 class="mb-4"><strong>Dashboard Overview</h2>

        <!-- Cards Section -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <h5>Total Users</h5>
                    <p class="display-4" id="totalUsers">Loading...</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <h5>Total Startups</h5>
                    <p class="display-4" id="totalStartups">Loading...</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <h5>Total Investors</h5>
                    <p class="display-4" id="totalInvestors">Loading...</p>
                </div>
            </div>
        </div>

        <div class="row mb-4 text-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h5>Ideas Posted</h5>
                    <p class="display-4" id="totalIdeasPosted">Loading...</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4">
                    <h5>Jobs Posted</h5>
                    <p class="display-4" id="totalJobsPosted">Loading...</p>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="chart-container">
            <h3 class="text-center">Statistics Overview</h3>
            <canvas id="dashboardChart"></canvas>
        </div>

        <footer>
            <p>&copy; 2024 NEXUS. All Rights Reserved.</p>
        </footer>
    </div>

    <script>
        $(document).ready(function() {
            // Fetch the stats using AJAX
            $.ajax({
                url: '/admin/dashboard/fetch-stats',  // Ensure this matches the defined route
                method: 'GET',
                success: function(response) {
                    // Update the card values
                    $('#totalUsers').text(response.totalUsers);
                    $('#totalStartups').text(response.totalStartups);
                    $('#totalInvestors').text(response.totalInvestors);
                    $('#totalIdeasPosted').text(response.totalIdeasPosted);
                    $('#totalJobsPosted').text(response.totalJobsPosted);

                    // Update the chart
                    const data = {
                        labels: ['Total Users', 'Total Startups', 'Total Investors', 'Ideas Posted', 'Jobs Posted'],
                        datasets: [{
                            label: 'Statistics Overview',
                            data: [
                                response.totalUsers,
                                response.totalStartups,
                                response.totalInvestors,
                                response.totalIdeasPosted,
                                response.totalJobsPosted
                            ],
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(153, 102, 255, 0.8)',
                                'rgba(255, 99, 132, 0.8)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }]
                    };

                    const config = {
                        type: 'bar',
                        data: data,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: '#e0e0e0'
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: '#e0e0e0'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        color: '#e0e0e0'
                                    }
                                }
                            }
                        }
                    };

                    // Render the chart
                    const dashboardChart = new Chart(
                        document.getElementById('dashboardChart'),
                        config
                    );
                },
                error: function(error) {
                    console.log("Error fetching data", error);
                }
            });
        });
    </script>
</body>
</html>
