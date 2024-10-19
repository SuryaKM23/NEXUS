<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('admin.css')
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 24px;
            color: white;
            align-content: center;
        }

        .center-table {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .table-container {
            max-width: 1000px;
            width: 100%;
        }

        table {
            color: #fff;
            width: 100%;
            border-collapse: collapse;
        }

        th, td, tr {
            color: #fff;
            border: 1px solid #686868;
            padding: 25px;
            text-align: center; /* Center-align table cell content */
        }

        th {
            color: white;
        }

        .btn.btn-edit {
            background-color: #007bff;
            color: #fff;
            border: 1px solid #007bff;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
            margin-right: 10px; /* Add margin to the right */
        }

        .btn.btn-edit:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            color: #fff;
        }

        .btn.btn-delete {
            background-color: #dc3545;
            color: #fff;
            border: 1px solid #dc3545;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        .btn.btn-delete:hover {
            background-color: #680a13;
            border-color: #680a13;
        }
        .footer {
      margin-top: 50px;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    }
    </style>
</head>
<body>
    <div class="container-scroller">
        @include('admin.sidebar')
      

        <div class="main-panel">
            <div class="content-wrapper">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        {{ session()->get('message') }}
                    </div>
                @endif
                <p><h1> Startup / Investor Management </h1></p> <br>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email Id</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->name}}</td>
                                    <td>{{ $item->email}}</td>
                                    <td>{{ $item->usertype}}</td>
                                    <td>
                                        <a class="btn btn-edit" href="{{ url('editdetails', $item->id) }}">Edit</a>
                                        <a onclick="return confirm('Are you sure to delete this?')" class="btn btn-delete" href="{{ url('delete_details', $item->id) }}">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="footer">
                    @include('admin.footer')
                  </div> --}}
            </div>
        </div>
    </div>
</body>
</html>
