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
        .edit-button {
            background-color: #007bff; /* Bootstrap primary color */
            color: white; /* White text */
        }
        .edit-button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
        .form-row {
            margin-bottom: 1rem; /* Spacing between rows */
        }
    </style>
</head>
<body>
@include("startup.nav")
<div class="container mt-5">
    <h2 class="mb-4">Job Listings</h2>
    <div id="alert-container"></div>
    <div id="recent-jobs-container"></div>

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
        url: "{{ url('/viewJobs') }}", // Ensure this matches your route in web.php
        type: 'GET',
        success: function(response) {
            let jobsHtml = '';
            if (response.success && response.data.length > 0) {
                response.data.forEach(function(job) {
                    jobsHtml += `
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">${job.title}</h5>
                                <p class="card-text">${job.description}</p>
                                <p><strong>Company:</strong> ${job.company_name}</p>
                                <p><strong>Location:</strong> ${job.job_location}</p>
                                <p><strong>Salary:</strong> ${job.salary}</p>
                                <p><strong>Application Deadline:</strong> ${new Date(job.application_deadline).toLocaleDateString()}</p>
                                <button onclick="confirmDelete(${job.id});" class="btn btn-danger">Delete</button>
                                <button onclick="showEditJobModal(${job.id}, '${job.title}', '${job.description}', '${job.company_name}', '${job.job_location}', '${job.salary}', '${job.application_deadline}', '${job.job_type}', '${job.experience_level}', '${job.required_skills}');" class="btn edit-button">Edit</button>
                            </div>
                        </div>
                    `;
                });
            } else {
                jobsHtml = '<div class="alert alert-warning">No jobs found for your company.</div>';
            }
            $('#recent-jobs-container').html(jobsHtml);
        },
        error: function() {
            $('#recent-jobs-container').html('<div class="alert alert-danger">Error fetching jobs.</div>');
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
                fetchJobs(); // Refresh jobs after deletion
                showAlert('Job deleted successfully.', 'success');
            } else {
                showAlert('Error deleting job.', 'danger');
            }
        },
        error: function() {
            showAlert('Error deleting job.', 'danger');
        }
    });
}

function showEditJobModal(id, title, description, companyName, jobLocation, salary, applicationDeadline, jobType, experienceLevel, requiredSkills) {
    currentJobId = id; // Set the current job ID for editing
    $('#editJobId').val(id);
    $('#editJobTitle').val(title);
    $('#editJobDescription').val(description);
    $('#editJobCompany').val(companyName);
    $('#editJobLocation').val(jobLocation);
    $('#editJobSalary').val(salary);
    $('#editJobDeadline').val(applicationDeadline);
    $('#editJobType').val(jobType);
    $('#editExperienceLevel').val(experienceLevel);
    $('#editRequiredSkills').val(requiredSkills);
    $('#editJobModal').modal('show'); // Show the edit job modal
}

function updateJob(id) {
    const formData = $('#editJobForm').serialize(); // Serialize the form data
    $.ajax({
        url: "{{ url('/update-job') }}/" + id, // Adjust URL to match your update route
        type: 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
        },
        data: formData,
        success: function(response) {
            if (response.success) {
                fetchJobs(); // Refresh jobs after updating
                $('#editJobModal').modal('hide'); // Hide the edit modal
                showAlert('Job updated successfully.', 'success');
            } else {
                showAlert('Error updating job.', 'danger');
            }
        },
        error: function() {
            showAlert('Error updating job.', 'danger');
        }
    });
}

function showAlert(message, type) {
    const alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>`;
    $('#alert-container').html(alertHtml);
}
</script>
</body>
</html>
