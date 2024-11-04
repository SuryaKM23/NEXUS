<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Idea Listings</title>
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
        <h2 class="mb-4">Idea Listings</h2>
        <div id="alert-container"></div>
        <div id="recent-Ideas-container"></div>

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
                        Are you sure you want to delete this Idea?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Editing Idea -->
        <div class="modal fade" id="editIdeaModal" tabindex="-1" role="dialog" aria-labelledby="editIdeaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editIdeaModalLabel">Edit Idea</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editIdeaForm">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" id="editIdeaId" name="Idea_id" value="">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="editIdeaTitle">Idea Title</label>
                                    <input type="text" class="form-control" id="editIdeaTitle" name="title" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="editIdeaCompany">Company Name</label>
                                    <input type="text" class="form-control" id="editIdeaCompany" name="company_name" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="editIdeaLocation">Idea Location</label>
                                    <input type="text" class="form-control" id="editIdeaLocation" name="Idea_location" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="editIdeaSalary">Salary</label>
                                    <input type="text" class="form-control" id="editIdeaSalary" name="salary" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="editIdeaDeadline">Application Deadline</label>
                                    <input type="date" class="form-control" id="editIdeaDeadline" name="application_deadline" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="editIdeaType">Idea Type</label>
                                    <input type="text" class="form-control" id="editIdeaType" name="Idea_type" required>
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
                                <label for="editIdeaDescription">Idea Description</label>
                                <textarea class="form-control" id="editIdeaDescription" name="description" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Idea</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentIdeaId = null;

        $(document).ready(function() {
            fetchIdeas(); // Fetch Ideas on page load

            // Handle Idea deletion confirmation
            $('#confirmDeleteButton').on('click', function() {
                deleteIdea(currentIdeaId); // Pass the current Idea ID for deletion
                $('#deleteModal').modal('hide'); // Hide the modal after confirming deletion
            });

            // Handle Idea update form submission
            $('#editIdeaForm').on('submit', function(event) {
                event.preventDefault();
                updateIdea(currentIdeaId);
            });
        });

        function fetchIdeas() {
            $.ajax({
                url: "{{ url('/IdeasDetails') }}", // Ensure this matches your route in web.php
                type: 'GET',
                success: function(response) {
                    let IdeasHtml = '';
                    if (response.success && response.data.length > 0) {
                        response.data.forEach(function(viewIdea) {
                            IdeasHtml += `
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><b>${viewIdea.title}</b></h5>
                                        <p><strong>Company:</strong> ${viewIdea.company_name}</p>
                                        <p><strong>Description:</strong> ${viewIdea.description}</p>
                                        <p><strong>Estimated Amount: ₹</strong> ${viewIdea.estimated_amount}</p>
                                        <p><strong>Estimated Turn Over: ₹</strong> ${viewIdea.estimated_turn_over}</p>
                                        <p><strong>Date Of Post:</strong> ${new Date(viewIdea.created_at).toLocaleDateString()}</p>
                                        <button onclick="confirmDelete(${viewIdea.id});" class="btn btn-danger">Delete</button>
                                        <button onclick="showEditIdeaModal(${viewIdea.id}, '${viewIdea.title}', '${viewIdea.description}', '${viewIdea.company_name}', '${viewIdea.Idea_location}', '${viewIdea.salary}', '${viewIdea.application_deadline}', '${viewIdea.Idea_type}', '${viewIdea.experience_level}', '${viewIdea.required_skills}');" class="btn edit-button">Edit</button>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        IdeasHtml = '<div class="alert alert-warning">No Ideas found for your company.</div>';
                    }
                    $('#recent-Ideas-container').html(IdeasHtml);
                },
                error: function() {
                    $('#recent-Ideas-container').html('<div class="alert alert-danger">Error fetching Ideas.</div>');
                }
            });
        }

        function confirmDelete(id) {
            currentIdeaId = id; // Set the current Idea ID for deletion
            $('#deleteModal').modal('show'); // Show the delete confirmation modal
        }

        function deleteIdea(id) {
            $.ajax({
                url: "{{ url('/delete-Idea') }}/" + id, // Adjust URL to match your delete route
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function(response) {
                    if (response.success) {
                        fetchIdeas(); // Refresh Ideas after deletion
                        showAlert('Idea deleted successfully.', 'success');
                    } else {
                        showAlert('Error deleting Idea.', 'danger');
                    }
                },
                error: function() {
                    showAlert('Error deleting Idea.', 'danger');
                }
            });
        }

        function showEditIdeaModal(id, title, description, company_name, Idea_location, salary, application_deadline, Idea_type, experience_level, required_skills) {
            currentIdeaId = id; // Store the current Idea ID
            $('#editIdeaId').val(id);
            $('#editIdeaTitle').val(title);
            $('#editIdeaDescription').val(description);
            $('#editIdeaCompany').val(company_name);
            $('#editIdeaLocation').val(Idea_location);
            $('#editIdeaSalary').val(salary);
            $('#editIdeaDeadline').val(application_deadline);
            $('#editIdeaType').val(Idea_type);
            $('#editExperienceLevel').val(experience_level);
            $('#editRequiredSkills').val(required_skills);
            $('#editIdeaModal').modal('show'); // Show the edit modal
        }

        function updateIdea(id) {
            $.ajax({
                url: "{{ url('/update-Idea') }}/" + id, // Adjust URL to match your update route
                type: 'POST',
                data: $('#editIdeaForm').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function(response) {
                    if (response.success) {
                        fetchIdeas(); // Refresh Ideas after update
                        $('#editIdeaModal').modal('hide'); // Hide the modal
                        showAlert('Idea updated successfully.', 'success');
                    } else {
                        showAlert('Error updating Idea.', 'danger');
                    }
                },
                error: function() {
                    showAlert('Error updating Idea.', 'danger');
                }
            });
        }

        function showAlert(message, type) {
            const alertHtml = `<div class="alert alert-${type}">${message}</div>`;
            $('#alert-container').html(alertHtml);
            setTimeout(() => {
                $('#alert-container').fadeOut(); // Fade out alert after 3 seconds
            }, 3000);
        }
    </script>
</body>
</html>
