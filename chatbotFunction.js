/**
 * Adds a message to the chat display
 * @param {string} type - The type of message ('user', 'bot', or 'error')
 * @param {string} message - The message content to display
 */
function addMessage(type, message) {
  const messagesDiv = document.getElementById("chat-messages");
  const messageDiv = document.createElement("div");
  messageDiv.className = `message ${type}-message`;
  messageDiv.textContent = message;
  messagesDiv.appendChild(messageDiv);
  messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

/**
 * Handles sending messages and receiving responses
 */
const sendMessage = async () => {
  const input = document.querySelector("#user-input");
  const message = input.value.trim();

  if (!message) return;

  try {
    addMessage("user", message);
    input.value = "";

    const response = await fetch('chatbotprocess_message.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ message })
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();

    if (data.status === "success") {
      addMessage("bot", data.message);
    } else {
      addMessage("error", data.message || 'An error occurred');
    }
  } catch (error) {
    console.error("Error:", error);
    addMessage('error', 'Failed to send message');
  }
};
/**
 * Initialize event listeners when DOM is loaded
 */
document.addEventListener("DOMContentLoaded", () => {
  const submitButton = document.querySelector("#submit-button");
  const input = document.querySelector("#user-input");

  if (submitButton) {
    submitButton.addEventListener("click", sendMessage);
  }

  if (input) {
    input.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        sendMessage();
      }
    });
  }
});

