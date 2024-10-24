<script>
    function toggleMessenger() {
        const messengerContainer = document.getElementById('messenger-container');
        messengerContainer.style.display = (messengerContainer.style.display === 'none' || messengerContainer.style.display === '') ? 'block' : 'none';
    }

    function openChat(name, imgSrc, description) {
        document.getElementById('chat-header-title').innerText = name;
        const chatBody = document.getElementById('chat-body');
        chatBody.innerHTML = ''; // Clear previous messages
        chatBody.innerHTML += `<div class="message message-other">${description}</div>`; // Example message
        document.getElementById('chat-container').style.display = 'flex';
    }

    function sendMessage() {
        const input = document.getElementById('chat-input');
        if (input.value) {
            const chatBody = document.getElementById('chat-body');
            chatBody.innerHTML += `<div class="message message-user">${input.value}</div>`;
            input.value = ''; // Clear input
        }
    }

    function toggleSearch(box) {
        box.classList.toggle('active');
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>