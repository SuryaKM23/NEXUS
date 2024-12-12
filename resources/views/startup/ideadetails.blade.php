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
        .card {
            position: relative;
        }
        .card-header-buttons {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 10px;
        }
        .card-header-buttons .btn {
            padding: 5px 10px;
            font-size: 14px;
        }
        .card-body {
            padding-top: 15px;
        }
        .edit-button {
            background-color: #007bff;
            color: white;
        }
        .edit-button:hover {
            background-color: #0056b3;
            color: white;
        }
        .delete-button {
            background-color: #dc3545;
            color: white;
        }
        .delete-button:hover {
            background-color: #931925;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .col-12.col-md-6 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    @include("startup.nav")
    <div class="container mt-5">
        <h2 class="mb-4">Idea Listings</h2>
        <div id="alert-container"></div>
        <div class="row" id="recent-Ideas-container"></div>

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
                        <button type="button" class="btn btn-primary" id="updateIdeaButton">Update Idea</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentIdeaId = null;

        $(document).ready(function() {
            fetchIdeas();

            $('#confirmDeleteButton').on('click', function() {
                deleteIdea(currentIdeaId);
                $('#deleteModal').modal('hide');
            });

            $('#updateIdeaButton').on('click', function() {
                updateIdea(currentIdeaId);
            });
        });

        function fetchIdeas() {
            $.ajax({
                url: "{{ url('/IdeasDetails') }}",
                type: 'GET',
                success: function(response) {
                    let IdeasHtml = '';
                    if (response.success && response.data.length > 0) {
                        response.data.forEach(function(viewIdea) {
                            let editButton = `
                                <button onclick="showEditIdeaModal(${viewIdea.id}, '${viewIdea.title}', '${viewIdea.description}', '${viewIdea.company_name}', '${viewIdea.estimated_amount}', '${viewIdea.estimated_turn_over}', '${viewIdea.created_at}');" class="btn edit-button">
                                    Edit
                                </button>
                            `;
                            let deleteButton = `
                                <button onclick="confirmDelete(${viewIdea.id});" class="btn delete-button">
                                    Delete
                                </button>
                            `;

                            IdeasHtml += `
                                <div class="col-12 col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="card-header-buttons">
                                                ${editButton} 
                                            </div>
                                            <h5 class="card-title"><b>${viewIdea.title}</b></h5>
                                            <p><strong>Description:</strong> ${viewIdea.description}</p>
                                            <p><strong>Estimated Amount: $</strong> ${viewIdea.estimated_amount}</p>
                                            <p><strong>Estimated Turn Over: $</strong> ${viewIdea.estimated_turn_over}</p>
                                            <p><strong>Date Of Post:</strong> ${new Date(viewIdea.created_at).toLocaleDateString()}</p>
                                        </div>
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
            currentIdeaId = id;
            $('#deleteModal').modal('show');
        }

        function deleteIdea(id) {
            $.ajax({
                url: "{{ url('/delete-Idea') }}/" + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        fetchIdeas();
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
            currentIdeaId = id;
            $('#editIdeaModal .modal-body').html(`
                <form id="editIdeaForm">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="${title}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>${description}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="company_name">Company Name</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" value="${companyName}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="estimated_amount">Estimated Amount</label>
                        <input type="number" class="form-control" id="estimated_amount" name="estimated_amount" value="${estimatedAmount}" required>
                    </div>
                    <div class="form-group">
                        <label for="estimated_turn_over">Estimated Turn Over</label>
                        <input type="number" class="form-control" id="estimated_turn_over" name="estimated_turn_over" value="${estimatedTurnOver}" required>
                    </div>
                    <div class="form-group">
                        <label for="created_at">Date of Post</label>
                        <input type="text" class="form-control" id="created_at" name="created_at" value="${createdAt}" readonly>
                    </div>
                </form>
            `);
            $('#editIdeaModal').modal('show');
        }

        function updateIdea(id) {
            const formData = $('#editIdeaForm').serialize();
            $.ajax({
                url: "{{ url('/update-Idea') }}/" + id,
                type: 'PUT',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        fetchIdeas();
                        $('#editIdeaModal').modal('hide');
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
            $('#alert-container').html(`
                <div class="alert alert-${type}">
                    ${message}
                </div>
            `);
            setTimeout(function() {
                $('#alert-container').html('');
            }, 3000);
        }
    </script>
</body>
</html>
