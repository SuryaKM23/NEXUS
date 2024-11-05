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
            background-color: #f9f9f9;
            color: #333;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff;
            margin: 40px 0;
        }

        .company-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            margin-bottom: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .company-item:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .company-name {
            font-size: 1.5rem;
            color: #007bff;
            margin-bottom: 10px;
        }

        .title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .description {
            flex-grow: 1;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }

        .custom-button {
            display: inline-block;
            margin-top: auto;
            padding: 10px 15px;
            color: #fff;
            background-color: #007bff;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .custom-button:hover {
            background-color: #0056b3;
        }

        .donation-summary {
            margin-bottom: 10px;
        }

        .bar {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 5px;
            height: 12px;
            position: relative;
            overflow: hidden;
            margin: 10px 0;
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
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .modal-content input {
            margin-bottom: 10px;
        }

        /* Media Query for Responsive Design */
        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }

            .company-item {
                margin-bottom: 15px;
            }

            .company-name {
                font-size: 1.2rem;
            }

            .title {
                font-size: 1rem;
            }

            .custom-button {
                width: 100%;
                padding: 12px;
            }
        }

        @media (max-width: 576px) {
            .company-item {
                padding: 15px;
            }

            .section-title {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    @include('user.nav')
    <div class="container mt-5">
        <h1 class="section-title">Crowdfunding</h1>
        <div id="companies-container" class="row">
            <p class="col-12 text-center">Loading crowdfunding companies...</p>
        </div>
    </div>

    <!-- Donation Modal -->
    <div class="modal" id="donationModal" role="dialog" aria-labelledby="modalTitle" aria-modal="true">
        <div class="modal-content">
            <h5 id="modalTitle">Enter Donation Amount</h5>
            <input type="number" id="donationAmount" class="form-control" placeholder="Enter amount in INR" min="1" required>
            <input type="hidden" id="selectedTitle" value=""/>
            <button class="btn btn-primary mt-2" onclick="processDonation()">Donate</button>
            <button class="btn btn-secondary mt-2" onclick="closeModal()">Cancel</button>
        </div>
    </div>

    <script>
        let selectedCompanyId = '';
        let selectedCompanyName = '';
        let selectedTitle = '';

        const currentUserName = "{{ Auth::user()->name }}"; 
        const currentUserEmail = "{{ Auth::user()->email }}"; 

        function showDonationModal(companyId, companyName, title) {
            selectedCompanyId = companyId;
            selectedCompanyName = companyName; 
            selectedTitle = title; 
            document.getElementById('selectedTitle').value = title; 
            document.getElementById('donationModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('donationModal').style.display = 'none';
            document.getElementById('donationAmount').value = ''; 
            document.getElementById('selectedTitle').value = ''; 
        }

        function fetchCompanies() {
            $.ajax({
                url: "{{ url('/get-crowdfunding-startups') }}",
                type: 'GET',
                success: (data) => {
                    const companiesHtml = data.length > 0 ? data.map(company => {
                        const totalDonations = company.total_donations || 0;
                        const availableAmount = company.estimated_amount; 
                        const totalWidthPercentage = (totalDonations / availableAmount) * 100;

                        return `
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="company-item">
                                <h5 class="company-name">${company.company_name}</h5>
                                <p class="title">${company.title}</p>
                                <p class="description">${company.description}</p>
                                <div class="donation-summary">
                                    <div class="bar">
                                        <div class="bar-fill" style="width: ${totalWidthPercentage}%;"></div>
                                    </div>
                                    <p>₹${totalDonations} Raised Out Of : ₹${availableAmount}</p>
                                </div>
                                <button class="custom-button" onclick="showDonationModal(${company.id}, '${company.company_name}', '${company.title}')">Donate</button>
                            </div>
                        </div>`;
                    }).join('') : '<p class="col-12 text-center">No crowdfunding companies available.</p>';

                    $('#companies-container').html(companiesHtml);
                },
                error: () => {
                    $('#companies-container').html('<p class="col-12 text-center">Error loading companies. Please try again.</p>');
                }
            });
        }

        function processDonation() {
            const amount = document.getElementById('donationAmount').value;
            if (amount) {
                $.ajax({
                    url: "{{ url('/save-donation') }}",
                    type: 'POST',
                    data: {
                        company_name: selectedCompanyName,
                        title: selectedTitle,
                        user_name: currentUserName,
                        user_email: currentUserEmail,
                        donated_amount: amount,
                        transaction_id: 'trans_' + Math.random().toString(36).substr(2, 9), 
                        _token: "{{ csrf_token() }}", 
                    },
                    success: (response) => {
                        alert(response.message);
                        closeModal();
                        fetchCompanies();
                    },
                    error: (error) => {
                        alert('Error saving donation. Please try again.');
                    }
                });
            } else {
                alert('Please enter a valid donation amount.');
            }
        }

        $(document).ready(() => {
            fetchCompanies();
        });
    </script>
</body>

</html>
