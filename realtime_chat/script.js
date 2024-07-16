const socket = new WebSocket('ws://192.168.46.10:8080');//localhost:8080

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
