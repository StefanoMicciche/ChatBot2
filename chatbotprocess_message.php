<?php
header('Content-Type: application/json');
require_once 'chatbotConfig.php';

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $message = $input['message'] ?? '';

    if (empty($message)) {
        throw new Exception('No message provided');
    }

    $chatbot = new Chatbot();
    $response = $chatbot->getResponse($message);

    echo json_encode($response);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>