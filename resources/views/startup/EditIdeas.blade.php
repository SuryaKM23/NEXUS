<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Idea</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #eff6fd;
        }
        .container {
            margin-top: 50px;
        }
        .form-title {
            font-size: 32px;
            margin-bottom: 20px;
            color: #007bff;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .custom-button {
            background-color: #007bff; /* Blue background */
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .custom-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="form-title">Edit Idea</h1>
    <form id="edit-idea-form">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="estimated_amount">Estimated Amount:</label>
            <input type="number" class="form-control" id="estimated_amount" name="estimated_amount" required>
        </div>
        <div class="form-group">
            <label for="estimated_turn_over">Estimated Return Over:</label>
            <input type="text" class="form-control" id="estimated_turn_over" name="estimated_turn_over" required>
        </div>
        <button type="submit" class="custom-button">Update Idea</button>
    </form>
    <div id="message" class="alert" style="display:none;"></div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
    $(document).ready(function() {
        const ideaId = getParameterByName('id'); // Assuming you pass the ID in the URL

        // Fetch existing idea details and populate the form
        $.ajax({
            url: `/edit-idea/${ideaId}`, // Fetch the specific idea details
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#title').val(response.data.title);
                    $('#description').val(response.data.description);
                    $('#estimated_amount').val(response.data.estimated_amount);
                    $('#estimated_turn_over').val(response.data.estimated_turn_over);
                } else {
                    showMessage('Error fetching idea details.', 'danger');
                }
            },
            error: function() {
                showMessage('Error fetching idea details.', 'danger');
            }
        });

        // Handle form submission
        $('#edit-idea-form').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            const formData = {
                title: $('#title').val(),
                description: $('#description').val(),
                estimated_amount: $('#estimated_amount').val(),
                estimated_turn_over: $('#estimated_turn_over').val(),
            };

            $.ajax({
                url: `/update-idea/${ideaId}`, // This URL is correct according to your routes
                type: 'PUT', // Use PUT for update
                data: formData,
                success: function(response) {
                    if (response.success) {
                        showMessage('Idea updated successfully!', 'success');
                    } else {
                        showMessage('Error updating idea.', 'danger');
                    }
                },
                error: function() {
                    showMessage('Error updating idea.', 'danger');
                }
            });
        });

        function showMessage(message, type) {
            $('#message').text(message).removeClass('alert-danger alert-success').addClass(`alert-${type}`).show();
        }

        function getParameterByName(name) {
            const url = new URL(window.location.href);
            return url.searchParams.get(name);
        }
    });
</script>

</body>
</html>
