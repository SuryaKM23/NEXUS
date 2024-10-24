<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
    <title>Posted Idea</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #eff6fd;
        }
        .h1 {
            font-size: 64px; 
            margin-bottom: 30px; 
            text-align: center; 
            color: #333; 
        }
        .msg {
            text-align: left;
            padding: 40px;
            color: #fefefe;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            border-radius: 10px;
        }
        .row {
            display: flex; 
            flex-wrap: wrap; 
            justify-content: space-between; 
        }
        .idea-box {
            display: flex; 
            flex-direction: column; 
            justify-content: space-between; 
            flex: 1 1 calc(40% - 20px); 
            margin: 10px; 
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            width: calc(40% - 20px); 
            height: 300px; 
            box-sizing: border-box; 
            padding: 20px; 
            position: relative; 
        }
        .idea-box h4 {
            font-size: 24px; 
            font-weight: bold; 
            margin-bottom: 10px; 
            color: #007bff; 
        }
        .custom-button {
            align-self: center; 
            background-color: #007bff; /* Blue background */
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 5px 0; 
        }
        .custom-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropbtn {
            background-color: transparent; /* Change button background */
            border: none; /* Remove border */
            cursor: pointer; /* Pointer cursor */
            color: rgb(210, 210, 210); /* Change icon color to gray */
            font-size: 16px; /* Icon size */
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px; /* Rounded corners */
        }
        .dropdown-content a {
            color: black; /* Link color */
            padding: 12px 16px;
            text-decoration: none;
            display: block; /* Full-width */
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1; /* Light gray on hover */
        }
    </style>
</head>
<body>
    
    @include("startup.nav")
    <div class="container mt-4">
        <div id="alert-container"></div> <!-- Alert container -->
        <div class="row">
            <div class="col-12">
                <h1 class="h1">Recent Ideas</h1>
                <div id="recent-ideas-container" class="row">
                    <!-- AJAX content will be loaded here -->
                </div>
            </div>       
        </div>
    </div>

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
                    Are you sure you want to delete this idea?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        let currentIdeaId = null; // Variable to store the current idea ID for deletion

        $(document).ready(function() {
            fetchRecentIdeas(); // Call the function to fetch recent ideas on page load

            // Handle the confirmation of deletion
            $('#confirmDeleteButton').on('click', function() {
                deleteIdea(currentIdeaId);
                $('#deleteModal').modal('hide'); // Hide the modal after confirming deletion
            });
        });

        function fetchRecentIdeas() {
            $.ajax({
                url: "{{ url('/viewIdeas') }}", // Ensure this URL matches your route in the web.php file
                type: 'GET',
                success: function(response) {
                    let ideasHtml = '';
                    if (response.success && response.data.length > 0) {
                        response.data.forEach(function(viewIdea) {
                            ideasHtml += `
                                <div class="idea-box">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h4>${viewIdea.title}</h4>
                                        <div class="dropdown">
                                            <button class="dropbtn" onclick="toggleDropdown(event);">
                                                <i class="fas fa-pen" style="font-size: 16px;"></i>
                                            </button>
                                            <div class="dropdown-content">
                                                <a href="#" onclick="editIdea(${viewIdea.id}); return false;">Edit</a>
                                                <a href="#" onclick="confirmDelete(${viewIdea.id}); return false;">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <p>${viewIdea.description}</p>
                                    <p><strong>Estimated Amount:</strong> ${viewIdea.estimated_amount}</p>
                                    <p><strong>Estimated Return Over:</strong> ${viewIdea.estimated_turn_over}</p>
                                    <p><strong>Date of Posting:</strong> ${new Date(viewIdea.created_at).toLocaleDateString()}</p>
                                    <a href="${viewIdea.pdf_file}" target="_blank" class="custom-button">View PDF</a>
                                </div>
                            `;
                        });
                    } else {
                        ideasHtml = '<div class="alert alert-warning">No ideas posted yet.</div>';
                    }
                    $('#recent-ideas-container').html(ideasHtml);
                },
                error: function() {
                    $('#recent-ideas-container').html('<div class="alert alert-danger">Error fetching recent ideas.</div>');
                }
            });
        }

        function editIdea(id) {
            // Redirect to the edit idea page or show a modal for editing
            window.location.href = "{{ url('/edit-idea') }}/" + id; // Adjust the URL as necessary
        }

        function confirmDelete(id) {
            currentIdeaId = id; // Set the current idea ID to delete
            $('#deleteModal').modal('show'); // Show the delete confirmation modal
        }

        function deleteIdea(id) {
            $.ajax({
                url: "{{ url('/delete-idea') }}/" + id, // Adjust the URL to match your delete route
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function(response) {
                    if (response.success) {
                        fetchRecentIdeas(); // Refresh the ideas after deletion
                        showAlert('Idea deleted successfully.', 'success');
                    } else {
                        showAlert('Error deleting idea.', 'danger');
                    }
                },
                error: function() {
                    showAlert('Error deleting idea.', 'danger');
                }
            });
        }

        function showAlert(message, type) {
            const alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>`;
            $('#alert-container').html(alertHtml); // Set the alert HTML in the alert container
        }

        function toggleDropdown(event) {
            event.stopPropagation(); // Prevent click event from bubbling up to document
            const dropdownContent = $(event.target).closest('.dropdown').find('.dropdown-content');
            dropdownContent.toggle(); // Toggle dropdown visibility
        }

        $(document).on('click', function (event) {
            if (!$(event.target).closest('.dropdown').length) {
                $('.dropdown-content').hide(); // Hide dropdown if clicked outside
            }
        });
    </script>
</body>
</html>
