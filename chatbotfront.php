<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="chatbot.css?v=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="chatbotFunction.js"></script>
</head>
<body>
<div class="chat-container">
        <div class="chat-header">
            <h2>Ada</h2>
            <small>Powered by Hugging Face</small>
        </div>
        <div class="chat-messages" id="chat-messages">
        </div>
        <div class="chat-input">
            <input type="text" id="user-input" placeholder="Write a message...">
            <button onclick="sendMessage()">Submit</button>
        </div>
        <?php
        require_once 'chatbotConfig.php';
        require_once 'chatbotLearning.php';
        require_once 'responseinjector.php';

        $chatbot = new Chatbot();
        ?>
    </body>
    </html>
</body>
</html>