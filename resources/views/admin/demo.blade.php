<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Details</title>
    @include('admin.css')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c3e50;
        }

        .container-scroller {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .main-panel {
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin: 20px;
        }

        .content-wrapper {
            width: 100%;
        }

        .addform header {
            font-size: 26px;
            margin-bottom: 20px;
            text-align: center;
        }

        .form {
            display: flex;
            flex-direction: column;
        }

        .input-box {
            margin-bottom: 20px;
        }

        .input-box label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .input_color {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .column {
            display: flex;
            flex-direction: column;
        }

        button[type="submit"] {
            padding: 12px 20px;
            font-size: 16px;
            background-color: #079ffd;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #054f7d;
        }

        .alert {
            text-align: center;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert .close {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px; 
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .alert .close:hover {
            color: black;
        }

        @media (max-width: 768px) {
            .main-panel {
                padding: 10px;
            }

            .input-box {
                margin-bottom: 15px;
            }

            button[type="submit"] {
                width: 100%;
                padding: 14px;
            }
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
                    {{ session()->get('message') }}
                </div>
                @endif
                <section class="addform">
                    <header><b>Update Details</b></header>
                    <form action="{{ url('/update_user', $data->id) }}" class="form" method="post" id="add_form">
                        @csrf
                        <div class="input-box">
                            <label>Name</label>
                            <input type="text" class="input_color" name="name" placeholder="Name" required value="{{ $data->name }}" />
                        </div>

                        <div class="input-box">
                            <label>Email Address</label>
                            <input type="email" class="input_color" name="email" placeholder="Enter email address" required value="{{ $data->email }}" />
                        </div>

                        <div class="column">
                            <div class="input-box">
                                <label>Password</label>
                                <input type="text" class="input_color" name="password" placeholder="Enter Password" required value="{{ $data->password }}" />
                            </div>
                        </div>

                        <div class="column">
                            <div class="input-box">
                                <label>Usertype</label>
                                <input type="text" class="input_color" name="usertype" placeholder="Enter UserType" required value="{{ $data->usertype }}" />
                            </div>
                        </div>

                        <button type="submit">Update</button>
                    </form>
                    <div id="message"></div>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
