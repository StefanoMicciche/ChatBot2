<?php
require_once 'chatbotConfig.php';

try {
    $chatbot = new Chatbot();
    
    $questions = [
        "Hello",
        "What is your name?",
        "What is 2 + 2?",
        "What is the capital of France?"
    ];

    foreach ($questions as $question) {
        echo "<strong>Q:</strong> " . htmlspecialchars($question) . "<br>";
        $response = $chatbot->getResponse($question);
        echo "<strong>A:</strong> " . htmlspecialchars(json_encode($response, JSON_PRETTY_PRINT)) . "<br><br>";
    }
    
} catch (Exception $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>