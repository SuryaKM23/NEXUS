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
        .table-container {
            max-height: 400px; /* Set a max height for the scrollable area */
            overflow-y: auto; /* Enable vertical scrolling */
            margin-bottom: 20px; /* Add some space at the bottom */
        }
        table {
            width: 100%; /* Increase table width */
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
    </style>
</head>
<body>
    <div class="container-scroller">
        @include('admin.sidebar')
        @include('admin.partial')
        <div class="main-panel">
            <div class="content-wrapper">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session()->get('message') }}
                    </div>
                @endif
                <h1>Startup Details Management</h1>
                <br>
                <div class="table-container">
                    <table id="investorTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company Name</th>
                                <th>Email Id</th>
                                <th>Phone No</th>
                                <th>Location</th>
                                <th>Country</th>
                                <th>License No</th>
                                <th>Role</th>
                                <th>Password</th>
                                <th>Website</th>
                                <th>Profile Picture</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table rows will be dynamically populated -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to fetch data via AJAX
            function fetchData() {
                $.ajax({
                    url: '/startup_details', // Backend route to fetch data
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Clear existing table rows
                        $('#investorTable tbody').empty();
                        
                        // Iterate through response data and append rows to the table
                        $.each(response.data, function(index, item) {
                            var row = `<tr>
                                <td>${item.name}</td>
                                <td>${item.company_name}</td>
                                <td>${item.email}</td>
                                <td>${item.phone}</td>
                                <td>${item.address}</td>
                                <td>${item.country}</td>
                                <td>${item.license_no}</td>
                                <td>${item.usertype}</td>
                                <td>${item.password}</td>
                                <td>${item.website}</td>
                                <td><img src="${item.profile_picture}" width="100px" height="100px"></td>
                            </tr>`;
                            $('#investorTable tbody').append(row);
                        });
                    },
                    error: function(error) {
                        console.log('Error fetching data:', error);
                    }
                });
            }

            // Call fetchData function when document is ready
            fetchData();
        });
    </script>
</body>
</html>
