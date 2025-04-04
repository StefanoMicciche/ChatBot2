const addMessage = (sender, message, error = null) => {
  const chatBox = document.querySelector(".chat-box");
  const messageDiv = document.createElement("div");
  messageDiv.className = `message ${sender}-message`;
  messageDiv.textContent = error || message;
  chatBox.appendChild(messageDiv);
};

const sendMessage = async () => {
  const input = document.querySelector("user-input");
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
      } else if (data.status === "Error") {
        addMessage("bot", null, "Sorry, I could not process your request.");
      }
      return data.message;
    } catch (error) {
      addMessage(
        "bot",
        null,
        "An error occurred while processing your request."
      );
      return null;
    }
  }
};
