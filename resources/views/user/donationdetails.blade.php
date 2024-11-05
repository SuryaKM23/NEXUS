<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .donation-details-container {
            margin-top: 50px;
        }
        .card-header, .card-body {
            font-size: 1.1em;
        }
        .back-btn {
            position: absolute;
            top: 15px;
            left: 15px;
        }
    </style>
</head>
<body>
    @include('user.nav')

    <div class="container">        
        <div class="donation-details-container">
            <h1 class="mb-4">Donation Details</h1>

            <div class="card">
                <div class="card-header">
                    <strong>Company Name:</strong> <span id="company-name"></span>
                </div>
                <div class="card-body">
                    <p><strong>Title:</strong> <span id="title"></span></p>
                    <p><strong>Description:</strong> <span id="description"></span></p>
                    <p><strong>PDF:</strong> <a id="pdf-url" href="#" target="_blank">View PDF</a></p>
                    <p><strong>Donated Amount:</strong> <span id="donated-amount"></span></p>
                    <p><strong>Total Amount:</strong> <span id="total-amount"></span></p>
                    <p><strong>Transaction ID:</strong> <span id="transaction-id"></span></p>
                    <p><strong>Date:</strong> <span id="date"></span></p>
                </div>
                <div class="card-footer text-right">
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
                        
                        // Set the PDF URL dynamically
                        const pdfPath = data.pdf_url || 'path/to/your/file.pdf'; // Use the PDF URL from the data if available
                        $('#pdf-url').attr('href', pdfPath);

                        $('#donated-amount').text('₹' + data.donated_amount);
                        $('#total-amount').text('₹' + data.total_amount);
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
