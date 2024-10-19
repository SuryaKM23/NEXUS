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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="logo/startup.png" alt="Logo" width="140" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            @include('user.index')
        </div>
    </nav>

    <!-- Jobs Section -->
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h1 class="fw-bold me-3 section-title">Jobs</h1>
                <div class="box" onclick="toggleSearch(this)">
                    <form name="search" onsubmit="return false;">
                        <input type="text" class="input" name="txt" placeholder="Search...">
                        <i class="fas fa-search"></i>
                    </form>
                </div>
            </div>
            <a href="#" class="btn btn-primary">Applied Jobs</a>
        </div>

        <div class="mt-4">
            <p>List of available jobs will go here.</p>
        </div>
    </div>

    <!-- CrowdFunding Section -->
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h1 class="fw-bold me-3 section-title">CrowdFunding</h1>
                <div class="box" onclick="toggleSearch(this)">
                    <form name="search" onsubmit="return false;">
                        <input type="text" class="input" name="txt" placeholder="Search...">
                        <i class="fas fa-search"></i>
                    </form>
                </div>
            </div>
            <a href="#" class="btn btn-primary">Recent Fund</a>
        </div>

        <div class="mt-4">
            <p>List of available crowdfunding projects will go here.</p>
        </div>
    </div>

    <!-- Messenger Section -->
    <div class="messenger-container" id="messenger-container">
        <div class="messenger-layout">
            <div class="contacts">
                <h4>Contacts</h4>
                <div class="contact" onclick="openChat('John Doe', 'john.jpg', 'Software Engineer at Tech Co.')">
                    <img src="images/john.jpg" alt="John Doe">
                    <div>
                        <strong>John Doe</strong>
                    </div>
                </div>
                <div class="contact" onclick="openChat('Jane Smith', 'jane.jpg', 'Project Manager at Business Inc.')">
                    <img src="images/jane.jpg" alt="Jane Smith">
                    <div>
                        <strong>Jane Smith</strong>
                    </div>
                </div>
                <div class="contact" onclick="openChat('Mark Wilson', 'mark.jpg', 'Data Scientist at Data Corp.')">
                    <img src="images/mark.jpg" alt="Mark Wilson">
                    <div>
                        <strong>Mark Wilson</strong>
                    </div>
                </div>
            </div>
            <div class="chat-container" id="chat-container">
                <div class="chat-header" id="chat-header">Chat</div>
                <div class="chat-body" id="chat-body"></div>
                <div class="chat-input">
                    <input type="text" id="message-input" onkeypress="handleKeyPress(event)" placeholder="Type a message...">
                    <button type="button" onclick="sendMessage()">Send</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Icon -->
    <div class="message-icon" onclick="toggleMessenger()">
        <i class="fas fa-comments"></i>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-5">
        <p>&copy; </p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSearch(element) {
            const input = element.querySelector('.input');
            input.classList.toggle('active');
            input.focus();
        }

        function toggleMessenger() {
            const messengerContainer = document.getElementById('messenger-container');
            messengerContainer.style.display = (messengerContainer.style.display === 'none' || messengerContainer.style.display === '') ? 'block' : 'none';
        }

        function openChat(contactName, contactImage, contactDescription) {
            document.getElementById('chat-header').innerText = contactName;
            document.getElementById('chat-body').innerHTML = ''; // Clear previous messages
            document.getElementById('chat-container').style.display = 'flex'; // Show chat container

            // Optional: Load the contact's image and description if needed
            const chatBody = document.getElementById('chat-body');
            const contactInfo = document.createElement('div');
            contactInfo.innerHTML = `<img src="${contactImage}" alt="${contactName}" style="width: 40px; height: 40px; border-radius: 50%;"/> <p>${contactDescription}</p>`;
            chatBody.appendChild(contactInfo);
        }

        function sendMessage() {
            const messageInput = document.getElementById('message-input');
            const messageText = messageInput.value;
            if (messageText.trim() !== '') {
                const messageElement = document.createElement('div');
                messageElement.className = 'message message-user';
                messageElement.innerText = messageText;
                document.getElementById('chat-body').appendChild(messageElement);
                messageInput.value = ''; // Clear input after sending
            }
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }

        $(document).ready(function() {
            $('.messenger-container').hide(); // Hide messenger on page load
        });
    </script>
</body>
</html>
