<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startup Details</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #000000;
            padding: 30px;
            margin: 0;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            font-size:8rem;
            margin-bottom: 40px;
            color: #000000;

        }

        .details-container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 12px;
            padding: 0px;
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            gap: 20px;
        }

        .startup-info {
            flex: 1;
            margin-right: 20px;
        }

        .startup-info h3 {
            font-size: 2rem;
            color: #2980b9;
            margin-bottom: 15px;
        }

        .startup-info p {
            font-size: 1.1rem;
            color: #000000;
            margin-bottom: 10px;
        }

        .chart-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .chart-wrapper {
            width: 100%;
            max-width: 400px;
            height: 400px;
        }

        .donut-label {
            font-size: 1.1rem;
            color: #2c3e50;
            margin-top: 15px;
            text-align: center;
        }
        .nav-link {
        text-decoration: none;
        color: rgb(0, 0, 0);
        padding: .5rem 1rem;
      }
    </style>
</head>
<body>
    @include("startup.nav")
    <br>
    <h1 style="font-size: 48px"><strong>Startup Funding Details</strong></h1>
    <br>
    <br>
    <div class="details-container">
        <!-- Left Side: Details -->
        <div class="startup-info">
            <br>
            <h3><strong>{{ $startup->title }}</strong></h3>
            <p><strong>Description:</strong> {{ $startup->description }}</p>
            <p><strong>Estimated Amount:</strong> ₹{{ number_format($startup->estimated_amount, 2) }}</p>
            <p><strong>Turnover:</strong> ₹{{ number_format($startup->estimated_turn_over, 2) }}</p>
            <p><strong>Date of Post:</strong> {{ \Carbon\Carbon::parse($startup->created_at)->format('d M Y') }}</p>
        </div>

        <!-- Right Side: Chart -->
        <div class="chart-container">
            <div class="chart-wrapper">
                <canvas id="donutChart"></canvas>
            </div>
            <div class="donut-label">
                {{-- <p><strong>Donation Progress:</strong></p> --}}
                <p><strong>₹{{ number_format($donatedAmount, 2) }} Donated | ₹{{ number_format($startup->estimated_amount - $donatedAmount, 2) }} Remaining</p>
            </div>
        </div>
    </div>

    <script>
        var ctx = document.getElementById('donutChart').getContext('2d');
        var donutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Donated', 'Remaining'],
                datasets: [{
                    data: [{{ $donatedAmount }}, {{ $startup->estimated_amount - $donatedAmount }}],
                    backgroundColor: ['#3498db', '#d6eaf8 '],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: '',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return '₹' + tooltipItem.raw.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
