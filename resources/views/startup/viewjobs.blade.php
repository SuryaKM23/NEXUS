<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .edit-button, .delete-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #007bff;
            color: white;
        }
        .delete-button {
            background-color: #dc3545;
            margin-right: 70px;
        }
        .edit-button:hover, .delete-button:hover {
            background-color: #0056b3;
            color: aliceblue;
        }
        .card {
            position: relative;
            margin-bottom: 1rem;
        }
        .form-row {
            margin-bottom: 1rem; /* Spacing between rows */
        }
        .nav-link {
            text-decoration: none;
            color: rgb(0, 0, 0);
            padding: .5rem 1rem;
        }
        .job-card {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
@include("startup.nav")
<div class="container mt-5">
    <h2 class="mb-4">Job Listings</h2>
    <div id="alert-container"></div>
    <div id="recent-jobs-container" class="row"></div> <!-- Row container for jobs -->

    <!-- Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this job?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Job -->
    <div class="modal fade" id="editJobModal" tabindex="-1" role="dialog" aria-labelledby="editJobModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editJobModalLabel">Edit Job</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editJobForm">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" id="editJobId" name="job_id" value="">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editJobTitle">Job Title</label>
                                <input type="text" class="form-control" id="editJobTitle" name="title" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editJobCompany">Company Name</label>
                                <input type="text" class="form-control" id="editJobCompany" name="company_name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editJobLocation">Job Location</label>
                                <input type="text" class="form-control" id="editJobLocation" name="job_location" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editJobSalary">Salary</label>
                                <input type="text" class="form-control" id="editJobSalary" name="salary" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editJobDeadline">Application Deadline</label>
                                <input type="date" class="form-control" id="editJobDeadline" name="application_deadline" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editJobType">Job Type</label>
                                <input type="text" class="form-control" id="editJobType" name="job_type" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editExperienceLevel">Experience Level</label>
                                <input type="text" class="form-control" id="editExperienceLevel" name="experience_level" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editRequiredSkills">Required Skills</label>
                                <input type="text" class="form-control" id="editRequiredSkills" name="required_skills" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editJobDescription">Job Description</label>
                            <textarea class="form-control" id="editJobDescription" name="description" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Job</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentJobId = null;

$(document).ready(function() {
    fetchJobs(); // Fetch jobs on page load

    // Handle job deletion confirmation
    $('#confirmDeleteButton').on('click', function() {
        deleteJob(currentJobId); // Pass the current job ID for deletion
        $('#deleteModal').modal('hide'); // Hide the modal after confirming deletion
    });

    // Handle job update form submission
    $('#editJobForm').on('submit', function(event) {
        event.preventDefault();
        updateJob(currentJobId);
    });
});

function fetchJobs() {
    $.ajax({
        url: "{{ url('/viewJobs') }}",
        type: 'GET',
        success: function(response) {
            let jobsHtml = '';
            if (response.success && response.data.length > 0) {
                response.data.forEach(function(job, index) {
                    // Create two jobs per row
                    if (index % 2 === 0) {
                        jobsHtml += `<div class="col-md-6">`; // Start new row for every 2 jobs
                    }
                    jobsHtml += `
                        <div class="card job-card">
                            <div class="card-body">
                                <h5 class="card-title"><b>${job.job_title}</b></h5>
                                <p><strong>Company:</strong> ${job.company_name}</p>
                                <p><strong>Location:</strong> ${job.job_location}</p>
                                <p><strong>Salary:</strong> ${job.salary}</p>
                                <p><strong>Application Deadline:</strong> ${new Date(job.application_deadline).toLocaleDateString()}</p>
                                <button onclick="showEditJobModal(${job.id}, '${job.job_title}', '${job.job_description}', '${job.company_name}', '${job.job_location}', '${job.salary}', '${job.application_deadline}', '${job.job_type}', '${job.experience_level}', '${job.required_skills}');" class="btn edit-button">Edit</button>
                            </div>
                        </div>
                    `;
                    if (index % 2 === 1 || index === response.data.length - 1) {
                        jobsHtml += `</div>`; // Close row after every 2 jobs
                    }
                });
            } else {
                jobsHtml = '<div class="alert alert-warning">No jobs found for your company.</div>';
            }
            $('#recent-jobs-container').html(jobsHtml);
        },
        error: function(xhr, status, error) {
            $('#recent-jobs-container').html('<div class="alert alert-danger">Error fetching jobs: ' + error + '</div>');
        }
    });
}

function confirmDelete(id) {
    currentJobId = id; // Set the current job ID for deletion
    $('#deleteModal').modal('show'); // Show the delete confirmation modal
}

function deleteJob(id) {
    $.ajax({
        url: "{{ url('/delete-job') }}/" + id, // Adjust URL to match your delete route
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
        },
        success: function(response) {
            if (response.success) {
                fetchJobs(); // Refresh the job listings after deletion
            }
        },
        error: function(xhr, status, error) {
            console.error('Error deleting job:', error);
        }
    });
}

function showEditJobModal(id, title, description, company, location, salary, deadline, type, level, skills) {
    currentJobId = id;
    $('#editJobTitle').val(title);
    $('#editJobDescription').val(description);
    $('#editJobCompany').val(company);
    $('#editJobLocation').val(location);
    $('#editJobSalary').val(salary);
    $('#editJobDeadline').val(deadline);
    $('#editJobType').val(type);
    $('#editExperienceLevel').val(level);
    $('#editRequiredSkills').val(skills);
    $('#editJobModal').modal('show'); // Show the edit modal
}

function updateJob(id) {
    $.ajax({
        url: "{{ url('/update-job') }}/" + id, // Adjust URL to match your update route
        type: 'PUT',
        data: $('#editJobForm').serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
        },
        success: function(response) {
            if (response.success) {
                $('#editJobModal').modal('hide');
                fetchJobs(); // Refresh the job listings after update
            }
        },
        error: function(xhr, status, error) {
            console.error('Error updating job:', error);
        }
    });
}
</script>
</body>
</html>
