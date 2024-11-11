<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Job Vacancy</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
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
            min-height: 100vh;
            padding: 20px;
        }

        .content-wrapper {
            max-width: 600px;
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
        .nav-link {
      text-decoration: none;
      color: rgb(0, 0, 0);
      padding: .5rem 1rem;
    }
    </style>
</head>

<body>
    @include("startup.nav")
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="form-section">
                <div id="message"></div> <!-- Display AJAX messages here -->
                <form class="form" id="add_form" method="POST" action="{{ route('post.job.vacancy') }}">
                    @csrf
                    <header>Post a Job Vacancy</header>
                    <div class="form-row">
                        <div class="input-box">
                            <label for="job_title">Job Title</label>
                            <input type="text" class="input_color" id="job_title" name="job_title" placeholder="Enter Job Title" required />
                        </div>
                        <div class="input-box">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="input_color" id="company_name" name="company_name" placeholder="Enter Company Name" value="{{ old('company_name', $companyName) }}" required />
                        </div>
                        <div class="input-box">
                            <label for="job_description">Job Description</label>
                            <textarea class="input_color" id="job_description" name="job_description" placeholder="Enter Job Description" rows="4" required></textarea>
                        </div>
                        <div class="input-box">
                            <label for="job_location">Job Location</label>
                            <input type="text" class="input_color" id="job_location" name="job_location" placeholder="Enter Job Location" required />
                        </div>
                        <div class="input-box">
                            <label for="salary">Salary</label>
                            <input type="text" class="input_color" id="salary" name="salary" placeholder="Enter Salary" required />
                        </div>
                        <div class="input-box">
                            <label for="application_deadline">Application Deadline</label>
                            <input type="date" class="input_color" id="application_deadline" name="application_deadline" required />
                        </div>
                        <div class="input-box">
                            <label for="job_type">Job Type</label>
                            <input type="text" class="input_color" id="job_type" name="job_type" placeholder="Enter Job Type" required />
                        </div>
                        <div class="input-box">
                            <label for="experience_level">Experience Level</label>
                            <input type="text" class="input_color" id="experience_level" name="experience_level" placeholder="Enter Experience Level" required />
                        </div>
                        <div class="input-box">
                            <label for="required_skills">Required Skills</label>
                            <textarea class="input_color" id="required_skills" name="required_skills" placeholder="Enter Required Skills" rows="4" required></textarea>
                        </div>
                    </div>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#add_form').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('post.job.vacancy') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#add_form')[0].reset();
                        $('#message').html('<div class="alert alert-success alert-dismissible fade show">' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            'Job vacancy posted successfully!' +
                            '</div>'); // Added fadeIn and fadeOut
                    },
                    error: function (xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';
                        $.each(errors, function (key, value) {
                            errorMessage += value + '<br>';
                        });
                        $('#message').html('<div class="alert alert-danger alert-dismissible fade show">' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            errorMessage +
                            '</div>'); // Added fadeIn and fadeOut
                    }
                });
            });
        });
    </script>
</body>

</html>
