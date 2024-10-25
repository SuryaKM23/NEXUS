<!-- resources/views/user/job_application.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @include("user.nav")
    <div class="container mt-5">
        <h1 class="mb-4" style="font-size: 2.5rem;">Apply for Job</h1>

        <!-- Success and Error Messages -->
        <div id="alert-message" style="display:none;" class="alert" role="alert"></div>

        <form id="jobApplicationForm" enctype="multipart/form-data">
            @csrf

            <!-- Hidden fields for job information -->
            <input type="hidden" name="job_id" value="{{ $job->id }}">
            <input type="hidden" name="company_name" value="{{ $job->company_name }}">
            <input type="hidden" name="job_title" value="{{ $job->job_title }}">

            <div class="row">
                <!-- Display Job Information -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="company_name">Company Name:</label>
                        <input type="text" id="company_name" class="form-control" value="{{ $job->company_name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="job_title">Job Title:</label>
                        <input type="text" id="job_title" class="form-control" value="{{ $job->job_title }}" readonly>
                    </div>

                    <!-- Display User Information -->
                    <div class="form-group">
                        <label for="user_name">Name:</label>
                        <input type="text" id="user_name" name="user_name" class="form-control" value="{{ Auth::user()->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="user_email">Email:</label>
                        <input type="text" id="user_email" name="user_email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                    </div>
                </div>

                <!-- Applicant Information -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" name="phone" id="phone" class="form-control" required maxlength="15" placeholder="Enter your phone number">
                    </div>

                    <div class="form-group">
                        <label for="degree">Degree:</label>
                        <input type="text" name="degree" id="degree" class="form-control" required maxlength="255" placeholder="Enter your highest degree">
                    </div>

                    <div class="form-group">
                        <label for="skills">Skills:</label>
                        <textarea name="skills" id="skills" class="form-control" required maxlength="1000" placeholder="Describe your skills"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="experience">Experience:</label>
                        <textarea name="experience" id="experience" class="form-control" required maxlength="1000" placeholder="Describe your work experience"></textarea>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="resume">Upload Resume (PDF, DOC, DOCX):</label>
                <input type="file" name="resume" id="resume" class="form-control-file" required accept=".pdf,.doc,.docx">
            </div>

            <button type="button" id="submitApplication" class="btn btn-primary">Submit Application</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#submitApplication').click(function(e) {
                e.preventDefault();
                
                let formData = new FormData($('#jobApplicationForm')[0]);
                
                $.ajax({
                    url: "{{ url('/applied_job') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#alert-message').removeClass('alert-danger').addClass('alert-success');
                        $('#alert-message').text(response.message).show();
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = "An error occurred:<br>";
                        for (let key in errors) {
                            errorMessage += errors[key][0] + "<br>";
                        }
                        $('#alert-message').removeClass('alert-success').addClass('alert-danger');
                        $('#alert-message').html(errorMessage).show();
                    }
                });
            });
        });
    </script>
</body>
</html>
