<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="chatbot.css">
    <script defer src="chatbot.js"></script>
</head>
<body>
<div class="chat-container">
        <div class="chat-header">
            <h2>Talk with Ada</h2>
        </div>
        <div class="chat-messages" id="chat-messages">
        </div>
        <div class="chat-input">
            <input type="text" id="user-input" placeholder="Escribe un mensaje...">
            <button onclick="sendMessage()">Enviar</button>
        </div>
        <?php
require_once 'chatbotConfig.php';
?>
</body>
</html>