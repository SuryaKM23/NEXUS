<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startup Details Management</title>
    @include('admin.css')
    <style>
        body {
            font-family: Arial, sans-serif;
            color: white;
        }
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            margin: auto;
            border-collapse: collapse;
            color: white;
            text-align: left;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
            color: white;
        }

        th {
            background-color: rgb(27, 27, 27);
            color: white;
        }

        .alert {
            color: black;
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
                    <table id="startupTable">
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
                        if (response.data) {
                            $('#startupTable tbody').empty(); // Clear existing rows

                            // Append rows with fetched data
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
                                    <td>${item.website}</td>
                                    <td>
                                        <img src="${item.profile_picture}" alt="Profile Picture" width="100px" height="100px">
                                    </td>
                                </tr>`;
                                $('#startupTable tbody').append(row);
                            });
                        } else {
                            console.error('No data received from the server.');
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            // Fetch data on page load
            fetchData();
        });
    </script>
</body>
</html>
