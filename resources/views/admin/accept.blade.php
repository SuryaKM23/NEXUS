<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Startup Details Management</title>
        <!-- Include your CSS -->
        @include('admin.css')
        <style>
            body {
                font-family: Arial, sans-serif;
                color: white; /* Set text color to white */
            }
            .main-panel {
                padding-top: 0%;
            }
    
            .table-container {
                width: 100%;
                overflow-x: auto; /* Enable horizontal scroll if needed */
            }
    
            table {
                width: auto;
                margin: auto;
                border-collapse: collapse;
                color: white; /* Ensure table text color is white */
                text-align: center;
            }
    
            th, td, tr {
                border: 1px solid #ddd;
                padding: 5px;
                text-align: center;
                color: white; /* Ensure th, td, tr text color is white */
            }
    
            th {
                background-color: rgb(27, 27, 27);
                color: white; /* Header text color */
            }
    
            .alert {
                color: black; /* Keep alerts readable */
            }
            .table thead th, .jsgrid .jsgrid-table thead th{
                color: white;
            }
        </style>
    </head>
<body>
    <div class="container-scroller">
        @include('admin.sidebar')
        @include('admin.partial')
        <div class="main-panel">
            <div class="content-wrapper">
                <div id="alert-container" class="alert alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <h1>Startup / Investor Acception</h1> 
<br>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Company Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Country</th>
                                <th>License No</th>
                                <th>Role</th>
                                <th>Website</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="startupinverstors">
                            <!-- Table rows will be dynamically populated -->
                        </tbody>
                    </table>
                </div>

                {{-- <div class="footer">
                    @include('admin.footer')
                </div> --}}
            </div>
        </div>
    </div>
<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function fetchStartupInvestors() {
    $.ajax({
        url: '{{ url('accept_page') }}',
        method: 'GET',
        dataType: 'json', // Ensure dataType is set to json
        success: function(response) {
            var tableBody = $('#startupinverstors');
            tableBody.empty();

            if (response.data) {
                response.data.forEach(function(data) {
                    var row = '<tr>' +
                        '<td><img src="' + data.profile_picture + '" width="100px" height="100px"></td>' +
                        '<td>' + data.name + '</td>' +
                        '<td>' + data.company_name + '</td>' +
                        '<td>' + data.email + '</td>' +
                        '<td>' + data.phone + '</td>' +
                        '<td>' + data.address + '</td>' +
                        '<td>' + data.country + '</td>' +
                        '<td>' + data.license_no + '</td>' +
                        '<td>' + data.usertype + '</td>' + // Assuming 'role' is the correct attribute
                        '<td>' + data.website + '</td>' +
                        '<td>' + data.status + '</td>' +
                        '<td>' +
                        '<button class="acceptBtn btn btn-primary" data-id="' + data.id + '">Accept</button> ' +
                        '<button class="rejectBtn btn btn-danger" data-id="' + data.id + '">Reject</button>' +
                        '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });
            } 
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

// Event handler for accepting an investor
$(document).on('click', '.acceptBtn', function() {
    var id = $(this).data('id');
    $.ajax({
        url: '/accept/' + id,
        method: 'POST',
        dataType: 'json', // Ensure dataType is set to json
        success: function(response) {
            console.log('Server response:', response);
            if (response.success) {
                alert(response.message);
                fetchStartupInvestors(); // Refresh the data after accepting
            } else {
                alert('Failed to accept startup/investor: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('An error occurred: ' + xhr.responseText);
        }
    });
});

// Event handler for rejecting an investor
$(document).on('click', '.rejectBtn', function() {
    var id = $(this).data('id');
    $.ajax({
        url: '/reject/' + id,
        method: 'POST',
        dataType: 'json', // Ensure dataType is set to json
        success: function(response) {
            if (response.success) {
                alert('Startup/investor rejected successfully.');
                fetchStartupInvestors(); // Refresh the data after rejecting
            } else {
                alert('Failed to reject startup/investor.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
});

// Fetch startup investors initially when the page loads
fetchStartupInvestors();
    });
    
</script>
</body>
</html>
