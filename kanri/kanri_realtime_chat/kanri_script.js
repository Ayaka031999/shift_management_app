const socket = new WebSocket('ws://localhost:8080');

socket.addEventListener('message', function(event) {
  const messageDiv = document.createElement('div');
  messageDiv.textContent = event.data;
  document.getElementById('chat-messages').appendChild(messageDiv);
});

function sendMessage() {
  const messageInput = document.getElementById('message-input');
  const message = messageInput.value;
  socket.send(message);
  messageInput.value = '';
}
