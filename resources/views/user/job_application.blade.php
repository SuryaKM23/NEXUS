<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
         body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .main-panel {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
            padding: 20px;
        }

        .content-wrapper {
            max-width: 800px; /* Adjusted for two columns */
            width: 100%;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        header {
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
            color: #343a40;
            font-weight: 600;
            border-bottom: 3px solid #007bff;
            padding-bottom: 15px;
        }

        .input-box {
            margin-bottom: 15px;
        }

        .input-box label {
            display: block;
            margin-bottom: 5px;
            color: #495057;
            font-weight: 500;
        }

        .input_color {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            transition: border-color 0.3s;
        }

        .input_color:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
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
            font-size: 14px;
        }
    </style>
</head>
<body>
    @include("user.nav")
    <div class="main-panel">
        <div class="content-wrapper">
            <header>Apply for Job</header>
            <form id="jobApplicationForm" enctype="multipart/form-data">
                @csrf <!-- Required for Laravel security -->

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ Auth::user()->name }}" readonly>
                    </div> 
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 input-box">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="input_color" required maxlength="15">
                    </div>

                    <div class="col-md-6 input-box">
                        <label for="degree">Degree</label>
                        <input type="text" name="degree" id="degree" class="input_color" required maxlength="255">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 input-box">
                        <label for="skills">Skills</label>
                        <textarea name="skills" id="skills" class="input_color" required maxlength="1000"></textarea>
                    </div>

                    <div class="col-md-6 input-box">
                        <label for="experience">Experience</label>
                        <textarea name="experience" id="experience" class="input_color" required maxlength="1000"></textarea>
                    </div>
                </div>

                <div class="input-box">
                    <label for="resume">Upload Resume (PDF/DOC/DOCX)</label>
                    <input type="file" name="resume" id="resume" class="input_color" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Submit Application</button>
            </form>
        </div>
    </div>

    <!-- Modal for response messages -->
    <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="responseModalLabel">Response</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    <!-- Response message will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
 </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#jobApplicationForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Prepare form data for AJAX
                var formData = new FormData(this);

                $.ajax({
                    url: "{{ url('/applied_job') }}", // Use the correct route for submission
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Display success message in modal
                        $('#modal-body').html('<div class="alert alert-success">' + response.message + '</div>');
                        $('#responseModal').modal('show');
                    },
                    error: function(xhr) {
                        // Display error message in modal
                        let errorMessage = 'An error occurred while submitting the form.';
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = '';
                            $.each(errors, function(key, error) {
                                errorMessages += '<p>' + error[0] + '</p>';
                            });
                            errorMessage = errorMessages; // Show validation errors
                        }
                        $('#modal-body').html('<div class="alert alert-danger">' + errorMessage + '</div>');
                        $('#responseModal').modal('show');
                    }
                });
            });
        });
    </script>
</body>
</html>