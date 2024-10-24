<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Idea</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .message {
            display: none; /* Hide by default */
            margin-top: 20px;
        }
        .image-section {
            /* Optional background color for contrast */
            padding: 20px;
            text-align: center;
        }
        .form-section {
            padding: 20px;
        }
        .heading {
            font-size: 2.5rem; /* Increase font size */
            font-weight: bold; /* Make it bold */
            text-align: center; /* Center the text */
            margin-bottom: 20px; /* Add some margin at the bottom */
        }
    </style>
</head>
<body>
@include("startup.nav")
<div class="container mt-4">
    <h1 class="heading">Edit Idea</h1> <!-- Updated heading with class -->

    <!-- Message Container -->
    <div id="message" class="message alert" role="alert"></div>
    
    <div class="row">
        <div class="col-md-6 image-section">
            <img src="{{ asset('images/update.jpg') }}" alt="Image Description" class="img-fluid"> <!-- Replace with your image path -->
        </div>
        <div class="col-md-6 form-section">
            <form id="edit-idea-form">
                <input type="hidden" id="idea-id" value="{{ $startup->id }}">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" value="{{ $startup->title }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" required>{{ $startup->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="estimated_amount">Estimated Amount</label>
                    <input type="text" class="form-control" id="estimated_amount" value="{{ $startup->estimated_amount }}" required>
                </div>
                <div class="form-group">
                    <label for="estimated_turn_over">Estimated Turn Over</label>
                    <input type="text" class="form-control" id="estimated_turn_over" value="{{ $startup->estimated_turn_over }}" required>
                </div>
                <div class="text-center"> <!-- Centering the button -->
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#edit-idea-form').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            updateIdea($('#idea-id').val());
        });
    });

    function updateIdea(id) {
        const ideaData = {
            title: $('#title').val(),
            description: $('#description').val(),
            estimated_amount: $('#estimated_amount').val(),
            estimated_turn_over: $('#estimated_turn_over').val(),
            _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
        };

        $.ajax({
            url: "{{ url('/update-idea') }}/" + id, // Correctly construct the URL
            type: 'PUT',
            data: ideaData,
            success: function(response) {
                $('#message').removeClass('alert-success alert-danger').hide();

                if (response.success) {
                    $('#message').addClass('alert alert-success').text('Idea updated successfully.').show();
                    setTimeout(function() {
                        window.location.href = "{{ url('/viewIdeas') }}"; // Redirect to '/viewIdeas'
                    }, 500); // Wait for 0.5 seconds before redirecting
                } else {
                    $('#message').addClass('alert alert-danger').text('Error updating idea: ' + response.message).show();
                }
            },
            error: function() {
                $('#message').removeClass('alert-success').addClass('alert alert-danger').text('Error updating idea.').show();
            }
        });
    }
</script>
</body>
</html>
