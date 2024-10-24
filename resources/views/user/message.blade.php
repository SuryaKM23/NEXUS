<!-- Messenger Section -->
<div class="messenger-container" id="messenger-container">
    <div class="messenger-layout">
        <div class="contacts">
            <h4>Contacts</h4>
            <div class="contact" onclick="openChat('John Doe', 'john.jpg', 'Software Engineer at Tech Co.')">
                <img src="images/john.jpg" alt="John Doe">
                <div>
                    <strong>John Doe</strong>
                    <p>Software Engineer at Tech Co.</p>
                </div>
            </div>
            <div class="contact" onclick="openChat('Jane Smith', 'jane.jpg', 'Product Manager at Startup Inc.')">
                <img src="images/jane.jpg" alt="Jane Smith">
                <div>
                    <strong>Jane Smith</strong>
                    <p>Product Manager at Startup Inc.</p>
                </div>
            </div>
            <!-- Add more contacts as needed -->
        </div>
        <div class="chat-container" id="chat-container" style="display: none;">
            <div class="chat-header" id="chat-header">
                <h5 id="chat-header-title"></h5>
            </div>
            <div class="chat-body" id="chat-body">
                <!-- Chat messages will be appended here -->
            </div>
            <div class="chat-input">
                <input type="text" id="chat-input" placeholder="Type your message...">
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>
</div>

<div class="message-icon" onclick="toggleMessenger()">
    <i class="fas fa-comments"></i>
</div>

