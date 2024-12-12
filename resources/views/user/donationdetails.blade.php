<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        /* General Styles */
        body {
            background-color: #f4f7fa;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .container {
            margin-top: 40px;
        }

        .donation-details-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #007bff;
            margin-bottom: 30px;
        }

        /* Card Styling */
        .card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            font-size: 1.2rem;
            padding: 20px;
        }

        .card-body {
            padding: 30px;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .card-footer {
            padding: 15px;
            background-color: #f7f9fc;
            text-align: right;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 1rem;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-pdf {
            background-color: #28a745;
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 1rem;
        }

        .btn-pdf:hover {
            background-color: #218838;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
                text-align: center;
            }

            /* .card-body {
                padding: 20px;
            } */
        }
    </style>
</head>
<body>
    @include('user.nav')

    <div class="container">
        <div class="donation-details-container">
            <h1 class="section-title text-center">Donation Details</h1>

            <div class="card">
                <div class="card-header">
                    <strong>Company Name:</strong> <span id="company-name"></span>
                </div>
                <div class="card-body">
                    <p><strong>Title:</strong> <span id="title"></span></p>
                    <p><strong>Description:</strong> <span id="description"></span></p>
                    <p><strong>Donated Amount:<strong> <span id="donated-amount"></span></p>
                    <p><strong>Total Amount:</strong> <span id="total-amount"></span></p>
                    <p><strong>Transaction ID:</strong> <span id="transaction-id"></span></p>
                    <p><strong>Date:</strong> <span id="date"></span></p>
                </div>
                <div class="card-footer">
                    <a href="/donation" class="btn btn-secondary">Back to Donations</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const donationId = "{{ $donation->id }}"; // Get the donation ID from your backend

            // Function to fetch donation details using AJAX
            function fetchDonationDetails() {
                $.ajax({
                    url: `/donation/details/${donationId}`, // Ensure this route is set up in your routes
                    method: 'GET',
                    success: function(data) {
                        // Update the donation details in the UI
                        $('#company-name').text(data.company_name);
                        $('#title').text(data.title);
                        $('#description').text(data.description || 'No description available');
                        $('#donated-amount').text('$ ' + data.donated_amount);
                        $('#total-amount').text('$ ' + data.total_amount);
                        $('#transaction-id').text(data.transaction_id);
                        $('#date').text(new Date(data.created_at).toLocaleDateString());
                    },
                    error: function() {
                        alert('Error fetching donation details.');
                    }
                });
            }

            // Call the function on page load
            fetchDonationDetails();
        });
    </script>
</body>
</html>
