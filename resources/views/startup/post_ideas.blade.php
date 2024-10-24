<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Ideas</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }

        .main-panel {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .content-wrapper {
            display: flex;
            flex-direction: row;
            width: 100%;
            max-width: 1000px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        .image-section {
            flex: 1;
            background: url('your-image-url.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .form-section {
            flex: 2;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form header {
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
            color: #343a40;
            font-weight: 700;
        }

        .input-box {
            margin-bottom: 20px;
        }

        .input-box label {
            display: block;
            margin-bottom: 10px;
            color: #495057;
            font-weight: 500;
        }

        .input_color {
            width: 100%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .form-row .input-box {
            flex: 1 1 calc(50% - 20px);
        }

        .form button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .form button:hover {
            background-color: #0056b3;
            transform: scale(1.02);
        }

        .alert {
            margin-top: 20px;
            border-radius: 5px;
        }

        .alert .close {
            color: #fff;
            opacity: 1;
        }

        #banking_details {
            display: none;
            margin-top: 20px;
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    @include('startup.nav')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="image-section">
                <img src="startup/assets/UploadSVG.jpg" alt="Startup Idea">
            </div>
            <div class="form-section">
                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div id="message"></div> <!-- Display AJAX messages here -->
                <form class="form" id="add_form" action="{{ route('get_ideas') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <header>Post Your Idea</header>
                    <div class="form-row">
                        <div class="input-box">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="input_color" id="company_name" name="company_name" value="{{ $companyName }}" readonly />
                        </div>
                        <div class="input-box">
                            <label for="title">Title</label>
                            <input type="text" class="input_color" id="title" name="title" placeholder="Enter Title" required />
                        </div>
                        <div class="input-box">
                            <label for="description">Description</label>
                            <input type="text" class="input_color" id="description" name="description" placeholder="Describe your idea" required />
                        </div>
                        <div class="input-box">
                            <label for="estimated_amount">Estimated Amount</label>
                            <input type="number" class="input_color" id="estimated_amount" name="estimated_amount" placeholder="Estimated Amount" required />
                        </div>
                        <div class="input-box">
                            <label for="estimated_turn_over">Estimated Turn Over</label>
                            <input type="number" class="input_color" id="estimated_turn_over" name="estimated_turn_over" placeholder="Estimated Turn Over" required />
                        </div>
                        <div class="input-box">
                            <label for="date_of_posting">Date of Posting</label>
                            <input type="date" class="input_color" id="date_of_posting" name="date_of_posting" required />
                        </div>
                        <div class="input-box">
                            <label for="investment">Investment Type</label>
                            <select class="input_color" id="investment" name="investment" required>
                                <option value="vc">Investor</option>
                                <option value="crowdfunding">Crowdfunding</option>
                            </select>
                        </div>
                        <div class="input-box">
                            <label for="pdf_file">Upload Document</label>
                            <input type="file" class="input_color" id="pdf_file" name="pdf_file" accept=".pdf" required />
                        </div>
                    </div>
                    <div id="banking_details">
                        <header>Banking Details</header>
                        <div class="form-row">
                            <div class="input-box">
                                <label for="account_holder_name">Account Holder Name</label>
                                <input type="text" class="input_color" id="account_holder_name" name="account_holder_name" placeholder="Account Holder Name" />
                            </div>
                            <div class="input-box">
                                <label for="account_number">Account Number</label>
                                <input type="text" class="input_color" id="account_number" name="account_number" placeholder="Account Number" />
                            </div>
                            <div class="input-box">
                                <label for="bank_name">Bank Name</label>
                                <input type="text" class="input_color" id="bank_name" name="bank_name" placeholder="Bank Name" />
                            </div>
                            <div class="input-box">
                                <label for="ifsc_code">IFSC Code</label>
                                <input type="text" class="input_color" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code" />
                            </div>
                            <div class="input-box">
                                <label for="swift_code">SWIFT Code</label>
                                <input type="text" class="input_color" id="swift_code" name="swift_code" placeholder="SWIFT Code" />
                            </div>
                            <div class="input-box">
                                <label for="upi_id">UPI ID</label>
                                <input type="text" class="input_color" id="upi_id" name="upi_id" placeholder="UPI ID" />
                            </div>
                        </div>
                    </div>
                    <button type="submit">Submit Idea</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#add_form').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('get_ideas') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#message').html('');
                        $('#add_form')[0].reset();
                        $('#banking_details').hide();
                        $('#successModal').modal('show');
                    },
                    error: function(error) {
                        $('#message').html('<div class="alert alert-danger">Something went wrong. Please try again.</div>');
                    }
                });
            });

            $('#investment').change(function() {
                if ($(this).val() == 'crowdfunding') {
                    $('#banking_details').show();
                } else {
                    $('#banking_details').hide();
                }
            });
        });
    </script>
</body>
</html>
