<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crowdfunding</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ffffff;
            color: #000000;
        }

        .section-title {
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 40px;
        }

        .company-item {
            border-radius: 10px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .top-section {
            margin-bottom: auto; /* Pushes the bottom section down */
        }

        .company-name {
            font-size: 20px;
            color: #007bff;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        .custom-button {
            display: inline-block;
            margin: 5px;
            padding: 10px 15px;
            color: #007bff;
            background-color: transparent;
            border: 2px solid #007bff;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .custom-button:hover {
            background-color: #007bff;
            color: #fff;
        }

        .donation-summary {
            margin-bottom: 10px;
        }

        .bar {
            width: 100%;
            background-color: transparent;
            border: 1px solid #007bff;
            border-radius: 5px;
            height: 15px;
            position: relative;
            overflow: hidden;
            margin: 5px 0;
        }

        .bar-fill {
            height: 100%;
            background-color: #007bff;
            position: absolute;
            top: 0;
            left: 0;
            border-radius: 5px;
            transition: width 0.4s ease;
        }

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
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .loading {
            text-align: center;
            font-size: 18px;
            color: #007bff;
            display: none;
        }

        .notification {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            padding: 15px;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
        }

        .alert-success {
            background-color: #28a745;
        }

        .alert-danger {
            background-color: #dc3545;
        }

        .description {
            display: none;
        }

        .description-visible {
            display: block;
        }

        .description-toggle {
            cursor: pointer;
            color: #007bff;
            text-decoration: underline;
            margin-top: 10px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px; /* Space above the buttons */
        }
    </style>
</head>

<body>
    @include('user.nav')

    <div class="notification" id="notification"></div>

    <div class="container mt-5">
        <h1 class="section-title">Crowdfunding</h1>
        <div class="loading" id="loading">Loading crowdfunding companies...</div>
        <div id="companies-container" class="row"></div>
    </div>

    <div class="modal" id="donationModal" role="dialog" aria-labelledby="modalTitle" aria-modal="true">
        <div class="modal-content">
            <h5 id="modalTitle">Enter Donation Amount</h5>
            <input type="number" id="donationAmount" class="form-control" placeholder="Enter amount in INR" min="1" required>
            <button class="btn btn-primary mt-2" onclick="processDonation()">Donate</button>
            <button class="btn btn-secondary mt-2" onclick="closeModal()">Cancel</button>
        </div>
    </div>

    <script>
        let selectedCompanyId = '';
        let selectedCompanyName = '';
        const currentUserName = "{{ Auth::user()->name }}";
        const currentUserEmail = "{{ Auth::user()->email }}";

        function showDonationModal(companyId, companyName) {
            selectedCompanyId = companyId;
            selectedCompanyName = companyName;
            document.getElementById('donationModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('donationModal').style.display = 'none';
            document.getElementById('donationAmount').value = '';
        }

        function processDonation() {
            const amount = document.getElementById('donationAmount').value;
            if (!amount || parseFloat(amount) <= 0) {
                showNotification("Please enter a valid amount.", "error");
                return;
            }
            closeModal();
            initiatePayment(amount);
        }

        function initiatePayment(amount) {
            const amountInPaise = parseFloat(amount) * 100;
            const options = {
                key: 'rzp_test_DrASf34mihEAtB',
                amount: amountInPaise,
                currency: 'INR',
                name: 'Crowdfunding Donation',
                description: `Donation for ${selectedCompanyName}`,
                handler: function (response) {
                    saveDonation(response.razorpay_payment_id, amount);
                },
                prefill: {
                    name: currentUserName,
                    email: currentUserEmail,
                },
                theme: {
                    color: '#3399cc'
                },
                modal: {
                    ondismiss: function () {
                        showNotification('Payment process cancelled.', 'error');
                    }
                }
            };

            const razorpay = new Razorpay(options);
            razorpay.open();
        }

        function saveDonation(transactionId, amount) {
    $.ajax({
        url: "{{ route('save.donation') }}",
        type: 'POST',
        data: {
            company_id: selectedCompanyId,
            company_name: selectedCompanyName,
            user_name: currentUserName,
            user_email: currentUserEmail,
            donated_amount: amount,
            transaction_id: transactionId,
            title: selectedCompanyName, // Ensure the title field is added here
            _token: "{{ csrf_token() }}",
        },
        success: (response) => {
            showNotification(response.message, "success");
            fetchCompanies();
        },
        error: () => {
            showNotification('Error saving donation. Please try again.', "error");
        }
    });
}


        function fetchCompanies() {
            $('#loading').show();
            $.ajax({
                url: "{{ url('/getcrowdfundingstartups') }}",
                type: 'GET',
                success: (data) => {
                    $('#loading').hide();
                    const companiesHtml = data.length > 0 ? data.map(company => {
                        const totalDonations = company.total_donations || 0;
                        const availableAmount = company.estimated_amount;
                        const totalWidthPercentage = (totalDonations / availableAmount) * 100;
                        const pdfPath = company.pdf_file ? `{{ url('') }}/${company.pdf_file}` : '';

                        return `
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="company-item">
                                    <div class="top-section">
                                        <h5 class="company-name">${company.company_name}</h5>
                                        <p class="company-title"><strong>${company.title}</strong></p>
                                        <p class="company-description">${company.description.substring(0, 100)}...</p>
                                        <p class="description">${company.description}</p>
                                        <span class="description-toggle" onclick="toggleDescription(this)">Read More</span>
                                    </div>
                                    <div class="donation-summary">
                                        <div class="bar">
                                            <div class="bar-fill" style="width: ${totalWidthPercentage}%"></div>
                                        </div>
                                        <p>₹${totalDonations}Raised Out Of ₹${availableAmount}</p>
                                    </div>
                                    <div class="button-container">
                                        <a class="custom-button" href="${pdfPath}" target="_blank">View PDF</a>
                                        <button class="custom-button" onclick="showDonationModal(${company.id}, '${company.company_name}')">Donate</button>
                                    </div>
                                </div>
                            </div>
                        `;
                    }).join('') : '<p>No crowdfunding companies available.</p>';
                    $('#companies-container').html(companiesHtml);
                },
                error: () => {
                    $('#loading').hide();
                    showNotification('Error fetching companies. Please try again.', "error");
                }
            });
        }

        function toggleDescription(element) {
            const descriptionElement = $(element).closest('.company-item').find('.description');
            descriptionElement.toggleClass('description-visible');
            element.text(descriptionElement.hasClass('description-visible') ? 'Read Less' : 'Read More');
        }

        function showNotification(message, type) {
            const notificationElement = $('#notification');
            notificationElement.removeClass('alert-success alert-danger');
            notificationElement.addClass(type === 'success' ? 'alert-success' : 'alert-danger');
            notificationElement.text(message).fadeIn().delay(3000).fadeOut();
        }

        $(document).ready(() => {
            fetchCompanies();
        });
    </script>
</body>

</html>
