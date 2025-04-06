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
  if (!input) {
    console.error("Input element not found");
    return;
  }

  const message = input.value.trim();
  if (!message) return;

  try {
    addMessage("user", message);
    input.value = "";
    input.disabled = true;

    const response = await fetch("chatbotprocess_message.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ message }),
    });

    if (!response.ok) {
      throw new Error(
        `Server error: ${response.status} ${response.statusText}`
      );
    }

    const botResponseText = await response.text();
    if (botResponseText && botResponseText.trim()) {
      try {
        const responseData = JSON.parse(botResponseText);
        if (responseData && responseData.messages) {
          addMessage("bot", responseData.messages);
        } else {
          addMessage("bot", botResponseText);
        }
      } catch (e) {
        addMessage("bot", botResponseText);
      }
    } else {
      throw new Error("Empty response from server");
    }
  } catch (error) {
    console.error("Chat error:", error);
    addMessage("error", `Error: ${error.message}`);
  } finally {
    if (input) {
      input.disabled = false;
      input.focus();
    }
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
