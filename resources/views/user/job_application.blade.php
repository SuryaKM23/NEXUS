<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fb;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px;
        }

        h1 {
            font-weight: bold;
            color: #000000;
            text-align: center;
            margin-bottom: 40px;
        }

        .job-details {
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .job-details h2 {
            font-size: 2rem;
            color: #343a40;
            margin-bottom: 20px;
        }

        .job-details p {
            font-size: 1.1rem;
            margin: 10px 0;
            color: #6c757d;
        }

        .job-details strong {
            font-size: 1.1rem;
            color: #333;
        }

        .btn-primary {
            background: #2575fc;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-size: 1.1rem;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #1a4fad;
            transform: scale(1.05);
        }

        .modal-content {
            border-radius: 12px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .modal-header {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        .modal-title {
            font-size: 1.5rem;
            color: #343a40;
            font-weight: bold;
        }

        .btn-close {
            background-color: transparent;
            border: none;
            font-size: 1.2rem;
            color: #343a40;
        }

        .form-label {
            font-weight: 500;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 12px 15px;
            font-size: 1rem;
            transition: border 0.3s ease;
        }

        .form-control:focus {
            border-color: #2575fc;
            box-shadow: 0 0 5px rgba(37, 117, 252, 0.5);
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group .form-control {
            border-radius: 8px;
        }

        .resume-upload input[type="file"] {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            background-color: #f8f9fa;
            width: 100%;
        }

        .modal-body {
            padding: 30px;
            background-color: #f9f9f9;
        }

        footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
        }

        footer a:hover {
            color: #2575fc;
        }

        @media (max-width: 768px) {
            .job-details {
                padding: 20px;
            }

            .btn-primary {
                padding: 10px 20px;
                font-size: 1rem;
            }

            h1 {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }

            .modal-dialog {
                width: 90%;
            }

            .btn-primary {
                width: 100%;
            }

            h1 {
                font-size: 1.8rem;
            }
        }

    </style>
</head>
<body>
    @include("user.nav")

    <div class="container my-5">
        <h1 class="text-center mb-4" style="font-size: 30px;">JOB DETAILS</h1>
        <!-- Job Details Section -->
        <div class="job-details">
            <h2>{{ $job->job_title }}</h2>
            <p><strong>Company:</strong> {{ $job->company_name }}</p>
            <p><strong>Location:</strong> {{ $job->job_location }}</p>
            <p><strong>Description:</strong> {{ $job->job_description }}</p>
            <p><strong>Required Skills:</strong> {{ $job->required_skills }}</p>
            <p><strong>Experience:</strong> {{ $job->experience_level }}</p>
            <p><strong>Salary: $</strong> {{ $job->salary }}</p>
        </div>

        <!-- Apply Button -->
        <div class="text-center mt-4">
            <button type="button" id="applyButton" class="btn btn-primary btn-lg px-4 py-2">Apply Now</button>
        </div>
    </div>

    <!-- Modal for Application Form -->
    <div class="modal fade" id="jobApplicationModal" tabindex="-1" aria-labelledby="jobApplicationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobApplicationModalLabel">Apply for {{ $job->job_title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="jobApplicationForm" enctype="multipart/form-data">
                        @csrf

                        <!-- Job Information Section -->
                        <input type="hidden" name="job_id" value="{{ $job->id }}">
                        
                        <!-- Personal Information Section -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_name" class="form-label">Name</label>
                                    <input type="text" id="user_name" name="user_name" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="user_email" class="form-label">Email</label>
                                    <input type="email" id="user_email" name="user_email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" name="phone" id="phone" class="form-control" placeholder="Enter your phone number" required>
                                </div>

                                <div class="mb-3">
                                    <label for="degree" class="form-label">Degree</label>
                                    <input type="text" name="degree" id="degree" class="form-control" placeholder="Enter your highest degree" required>
                                </div>
                            </div>
                        </div>

                        <!-- Skills and Experience Section -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="skills" class="form-label">Skills</label>
                                    <textarea name="skills" id="skills" class="form-control" rows="3" placeholder="Describe your skills" required></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="experience" class="form-label">Experience</label>
                                    <textarea name="experience" id="experience" class="form-control" rows="3" placeholder="Describe your work experience" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Resume Upload -->
                        <div class="mb-3 resume-upload">
                            <label for="resume" class="form-label">Upload Resume</label>
                            <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx" class="form-control" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-4 py-2">Submit Application</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("applyButton").addEventListener("click", function() {
            const modal = new bootstrap.Modal(document.getElementById('jobApplicationModal'));
            modal.show();
        });

        document.getElementById("jobApplicationForm").addEventListener("submit", function(event) {
            event.preventDefault();
            // Process form submission
            alert("Application submitted successfully!");
        });
    </script>
</body>
</html>
