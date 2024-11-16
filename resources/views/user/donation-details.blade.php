<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Donation Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9ecef;
        }

        .section-title {
            text-align: center;
            margin: 40px 0;
            color: #343a40;
            font-weight: bold;
        }

        .donation-item {
            background: linear-gradient(to right, #ffffff, #f8f9fa);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            border-left: 5px solid #007bff;
        }

        .donation-item:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .donation-item h5 {
            color: #007bff;
            font-weight: bold;
        }

        .donation-item p {
            margin: 5px 0;
            color: #495057;
        }

        #no-donations-message {
            display: none;
            text-align: center;
            font-style: italic;
        }
    </style>
</head>
<body>
    @include('user.nav')

    <div class="container mt-5">
        <h1 class="section-title">Your Donation Details</h1>
        <div id="donation-details"></div>
        <div id="no-donations-message" class="alert alert-info">
            You have not made any donations yet.
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // AJAX call to fetch donation details
            $.ajax({
                url: '/donation', // API endpoint to fetch donation data
                method: 'GET',
                success: function(data) {
                    if (data.length === 0) {
                        $('#no-donations-message').show(); // Show message if no donations found
                    } else {
                        // Iterate through each donation and append to the donation details section
                        $.each(data, function(index, donation) {
                            $('#donation-details').append(`
                                <div class="donation-item" data-id="${donation.id}">
                                   <a href="/profile/${donation.company_name}"><h5><strong>Company Name:</strong> ${donation.company_name}</h5></a>
                                    <p><strong>Donated Amount:</strong> ₹${donation.donated_amount}</p>
                                    <p><strong>Transaction ID: </strong> ${donation.transaction_id}</p>
                                    <p><strong>Date:</strong> ${new Date(donation.created_at).toLocaleDateString()}</p>
                                </div>
                            `);
                        });

                        // Add click event to each donation item
                        $('.donation-item').on('click', function() {
                            const donationId = $(this).data('id');
                            window.location.href = `/donation/details/${donationId}`;
                        });
                    }
                },
                error: function() {
                    alert('Failed to fetch donation details.'); // Alert on error
                }
            });
        });
    </script>
</body>
</html>
