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
      } else {
        addMessage("error", "Error: " + data.message);
      }
    } catch (error) {
      addMessage("error", "An error occurred while sending the message.");
    }
  }
};
