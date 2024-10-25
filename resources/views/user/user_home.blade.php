<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom styles for search box with icon */
        .box {
            position: relative;
        }
        .input {
            padding: 5px;
            width: 35px;
            height: 35px;
            background: none;
            border: 1px solid #007bff;
            border-radius: 30%;
            font-size: 20px;
            color: #000000;
            outline: none;
            transition: width 0.5s, border-radius 0.5s;
            visibility: hidden;
            opacity: 0;
        }
        .box:hover .input,
        .box.active .input {
            visibility: visible;
            opacity: 1;
            width: 200px;
            border-radius: 10px;
        }
        .box i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            font-size: 20px;
            color: #007bff;
            cursor: pointer;
            transition: .2s;
        }
        .box:hover i {
            opacity: 0.7;
        }
        /* Increased font size for headings */
        .section-title {
            font-size: 2.5rem;
        }
        /* Messenger styles */
        .messenger-container {
            display: none;
            position: fixed;
            bottom: 60px;
            right: 20px;
            width: 400px;
            height: 500px; /* Increased height for the messenger */
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .messenger-layout {
            display: flex;
            height: 100%; /* Fill height */
        }
        .contacts {
            padding: 10px;
            border-right: 1px solid #ddd; /* Divider line */
            width: 40%; /* Set width for contacts */
            height: 100%; /* Fill height */
            overflow-y: auto; /* Scrollable if too many contacts */
            background: #f8f9fa; /* Light background for contacts */
        }
        .contact {
            display: flex;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        .contact:hover {
            background: #e0e0e0;
        }
        .contact img {
            width: 40px; /* Profile image size */
            height: 40px; /* Profile image size */
            border-radius: 50%; /* Circular image */
            margin-right: 10px; /* Space between image and name */
        }
        .chat-container {
            display: flex;
            flex-direction: column;
            width: 60%; /* Set width for chat */
            height: 100%; /* Fill height */
        }
        .chat-header {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            background: #007bff;
            color: white;
            border-top-right-radius: 8px;
            border-top-left-radius: 0; /* Remove rounded corners on left */
        }
        .chat-body {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            background: #f8f9fa;
        }
        .chat-input {
            display: flex;
            border-top: 1px solid #ddd;
            padding: 10px;
            background: white;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        .chat-input input {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            margin-right: 10px;
        }
        .chat-input button {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 15px;
            cursor: pointer;
        }
        .chat-input button:hover {
            background: #0056b3;
        }
        .message {
            margin: 5px 0;
            padding: 5px 10px;
            border-radius: 4px;
            max-width: 80%;
            clear: both;
        }
        .message-user {
            margin-left: auto; /* Align user messages to the right */
            background: #007bff;
            color: white;
        }
        .message-other {
            background: #e9ecef; /* Light background for other messages */
            color: #333;
        }
        /* Positioning the message icon */
        .message-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 30px;
            background: #007bff;
            color: white;
            border-radius: 50%;
            padding: 15px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: background 0.3s;
        }
        .message-icon:hover {
            background: #0056b3; /* Darker background on hover */
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    {{-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="logo/startup.png" alt="Logo" width="140" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> --}}
            @include('user.nav')
            
        </div>
    </nav>

    <!-- Jobs Section -->
    @include("user.body")
    @include("user.message")
    @include("user.scrpit")
</body>
</html>
