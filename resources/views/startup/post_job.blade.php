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
            /* background-color: #f4f6f9; */
        }

        .main-panel {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2px;
        }

        .content-wrapper {
            display: flex;
            max-width: 1200px;
            width: 100%;
            background-color: #fff;
            border-radius: 12px;
            /* box-shadow: 0 0 15px rgba(0, 0, 0, 0.15); */
            overflow: hidden;
        }

        .image-section {
            width: 40%;
            background: url('{{asset("images/post_job.png")}}') no-repeat center center;
            background-size: cover;
        }

        .form-section {
            width: 60%;
            padding: 50px;
        }

        header {
            font-size: 26px;
            margin-bottom: 25px;
            text-align: center;
            color: #333;
            font-weight: 600;
            border-bottom: 4px solid #007bff;
            padding-bottom: 15px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .input-box {
            flex: 1;
        }

        .input-box label {
            display: block;
            font-weight: 500;
            margin-bottom: 6px;
            color: #495057;
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
    @include("startup.nav")
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="image-section"></div>
            <div class="form-section">
                <header>Post a Job Vacancy</header>
                <div id="message"></div> <!-- Display AJAX messages here -->
                <form class="form" id="add_form" method="POST" action="{{ route('post.job.vacancy') }}">
                    @csrf
                    <!-- Row 1 -->
                    <div class="form-row">
                        <div class="input-box">
                            <label for="job_title">Job Title</label>
                            <input type="text" class="input_color" id="job_title" name="job_title" placeholder="Enter Job Title" required />
                        </div>
                        <div class="input-box">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="input_color" id="company_name" name="company_name" placeholder="Enter Company Name" value="{{ old('company_name', $companyName) }}" required />
                        </div>
                    </div>
                    <!-- Row 2 -->
                    <div class="form-row">
                        <div class="input-box">
                            <label for="job_description">Job Description</label>
                            <textarea class="input_color" id="job_description" name="job_description" placeholder="Enter Job Description" rows="4" required></textarea>
                        </div>
                        <div class="input-box">
                            <label for="job_location">Job Location</label>
                            <input type="text" class="input_color" id="job_location" name="job_location" placeholder="Enter Job Location" required />
                        </div>
                    </div>
                    <!-- Row 3 -->
                    <div class="form-row">
                        <div class="input-box">
                            <label for="salary">Salary</label>
                            <input type="text" class="input_color" id="salary" name="salary" placeholder="Enter Salary" required />
                        </div>
                        <div class="input-box">
                            <label for="application_deadline">Application Deadline</label>
                            <input type="date" class="input_color" id="application_deadline" name="application_deadline" required />
                        </div>
                    </div>
                    <!-- Row 4 -->
                    <div class="form-row">
                        <div class="input-box">
                            <label for="job_type">Job Type</label>
                            <input type="text" class="input_color" id="job_type" name="job_type" placeholder="Enter Job Type" required />
                        </div>
                        <div class="input-box">
                            <label for="experience_level">Experience Level</label>
                            <input type="text" class="input_color" id="experience_level" name="experience_level" placeholder="Enter Experience Level" required />
                        </div>
                    </div>
                    <!-- Row 5 -->
                    <div class="form-row">
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
                            '</div>');
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
                            '</div>');
                    }
                });
            });
        });
    </script>
</body>

</html>
