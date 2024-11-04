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
                        <!-- Form will be populated by JavaScript -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn edit-button" id="updateIdeaButton">Update Idea</button>
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

            // Handle Idea update button click
            $('#updateIdeaButton').on('click', function() {
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
                                        <button onclick="showEditIdeaModal(${viewIdea.id}, '${viewIdea.title}', '${viewIdea.description}', '${viewIdea.company_name}', '${viewIdea.estimated_amount}', '${viewIdea.estimated_turn_over}', '${viewIdea.created_at}');" class="btn edit-button">Edit</button>
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

        function showEditIdeaModal(id, title, description, companyName, estimatedAmount, estimatedTurnOver, createdAt) {
            currentIdeaId = id; // Store the current Idea ID

            // Populate the edit form fields
            $('#editIdeaModal .modal-body').html(`
                <form id="editIdeaForm">
                    <div class="form-group">
                        <label for="editTitle">Title</label>
                        <input type="text" class="form-control" id="editTitle" name="title" value="${title}" required>
                    </div>
                    <div class="form-group">
                        <label for="editCompanyName">Company Name</label>
                        <input type="text" class="form-control" id="editCompanyName" name="company_name" value="${companyName}" required>
                    </div>
                    <div class="form-group">
                        <label for="editDescription">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" required>${description}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="editEstimatedAmount">Estimated Amount</label>
                        <input type="number" class="form-control" id="editEstimatedAmount" name="estimated_amount" value="${estimatedAmount}" required>
                    </div>
                    <div class="form-group">
                        <label for="editEstimatedTurnOver">Estimated Turn Over</label>
                        <input type="number" class="form-control" id="editEstimatedTurnOver" name="estimated_turn_over" value="${estimatedTurnOver}" required>
                    </div>
                    <div class="form-group">
                        <label for="editDateOfPost">Date Of Post</label>
                        <input type="text" class="form-control" id="editDateOfPost" name="date_of_post" value="${new Date(createdAt).toLocaleDateString()}" readonly>
                    </div>
                </form>
            `);

            // Show the modal
            $('#editIdeaModal').modal('show');
        }

        function updateIdea(id) {
            $.ajax({
                url: "{{ url('/update-Idea') }}/" + id, // Adjust URL to match your update route
                type: 'PUT',
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
            const alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>`;
            $('#alert-container').html(alertHtml);
        }
    </script>
</body>
</html>
