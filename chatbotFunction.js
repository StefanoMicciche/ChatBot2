// Función para añadir mensajes al chat
function addMessage(type, message) {
  const messagesDiv = document.getElementById("chat-messages");
  const messageDiv = document.createElement("div");
  messageDiv.className = `message ${type}-message`;
  messageDiv.textContent = message;
  messagesDiv.appendChild(messageDiv);
  messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

const sendMessage = async () => {
  const input = document.querySelector("#user-input"); // Añadir #
  const message = input.value.trim();

  if (message) {
    addMessage("user", message);
    input.value = "";

    try {
      const response = await fetch("handle_chatbot.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ message }),
      });
      const data = await response.json();

      if (data.status === "success") {
        addMessage("bot", data.message);
      } else {
        addMessage("error", "Error: " + data.message);
      }
    } catch (error) {
      addMessage("error", "An error occurred while sending the message.");
    }
  }
};

// 2. Añadir eventos
document.addEventListener("DOMContentLoaded", () => {
  // Para el botón
  const submitButton = document.querySelector("#submit-button");
  if (submitButton) {
    submitButton.addEventListener("click", sendMessage);
  }

  // Para el Enter
  const input = document.querySelector("#user-input");
  if (input) {
    input.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        sendMessage();
      }
    });
  }
});
