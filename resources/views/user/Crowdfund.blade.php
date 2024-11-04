<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crowdfunding</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        /* Basic page styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        .section-title {
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            color: #333;
        }
        .startup-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }
        .startup-item:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .company-name {
            font-size: 18px;
            color: #007bff;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .custom-button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            color: #fff;
            background-color: #007bff;
            border-radius: 4px;
            text-decoration: none;
        }
        .custom-button:hover {
            background-color: #0056b3;
        }
        .startup-actions {
            text-align: right;
            margin-top: 15px;
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
        }
        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            width: 100%;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .modal-content h5 {
            font-size: 20px;
            font-weight: bold;
        }
        .modal-content .form-control {
            width: 100%;
            margin: 10px 0;
        }
        .modal-content .btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    @include('user.nav')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="section-title">Crowdfunding</h1>
                <div id="startups-container" class="row">
                    <p class="col-12">Loading crowdfunding startups...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Donation Modal -->
    <div class="modal" id="donationModal">
        <div class="modal-content">
            <h5>Enter Donation Amount</h5>
            <input type="number" id="customAmount" class="form-control" placeholder="Enter amount in INR" min="1" required>
            <button class="btn btn-primary" onclick="processDonation()">Donate</button>
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
        </div>
    </div>

    <script>
        $(document).ready(() => {
            fetchCrowdfundingStartups();
        });

        function fetchCrowdfundingStartups() {
            $.ajax({
                url: "{{ url('/get-crowdfunding-startups') }}",
                type: 'GET',
                success: (data) => {
                    const startupsHtml = data.length > 0 ? data.map(startup => `
                        <div class="col-md-4 mb-3">
                            <div class="startup-item">
                                <div class="data-spacing">
                                    <h5 class="company-name">${startup.company_name}</h5>
                                    <p class="title">${startup.title}</p>
                                    <p>${startup.description}</p>
                                    <p><strong>Estimation amount: ₹</strong> ${startup.estimated_amount}</p>
                                    <a href="${startup.pdf_file}" target="_blank" class="custom-button">View PDF</a>
                                </div>
                                <div class="startup-actions">
                                    <button class="btn btn-primary" onclick="showDonationModal('${startup.id}', '${startup.company_name}')">Donate</button>
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

        let selectedStartupId = '';
        let selectedCompanyName = '';

        function showDonationModal(startupId, companyName) {
            selectedStartupId = startupId;
            selectedCompanyName = companyName;
            $('#donationModal').css('display', 'flex');
        }

        function closeModal() {
            $('#donationModal').css('display', 'none');
            $('#customAmount').val('');
        }

        function processDonation() {
            const amount = $('#customAmount').val();
            if (amount === '' || parseFloat(amount) <= 0) {
                alert("Please enter a valid amount.");
                return;
            }
            closeModal();
            initiatePayment(amount);
        }

        function initiatePayment(amount) {
            const amountInPaise = parseFloat(amount) * 100;

            var options = {
                key: 'rzp_test_DrASf34mihEAtB', // Replace with your Razorpay key
                amount: amountInPaise,
                currency: 'INR',
                name: selectedCompanyName,
                description: 'Crowdfunding Donation',
                handler: function (response) {
                    alert('Donation successful! Payment ID: ' + response.razorpay_payment_id);
                },
                prefill: {
                    name: 'User Name', // Replace with actual user's name if available
                    email: 'user@example.com', // Replace with actual user's email if available
                },
                theme: {
                    color: '#3399cc'
                }
            };

            var razorpay = new Razorpay(options);
            razorpay.open();
        }
    </script>
</body>
</html>
