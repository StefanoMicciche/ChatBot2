
<?php

error_log("Request recibido");
error_log("Datos: " . file_get_contents('php://input'));


header('Content-Type: application/json');
require_once 'chatbotConfig.php';
require_once 'chatbot.php';

try{
    $data = json_decode(file_get_contents('php://input'), true);
    $bot = new Chatbot();
    $response = $bot->getResponse($data['message']);

    echo json_encode($response);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
        ]);
    }
?>