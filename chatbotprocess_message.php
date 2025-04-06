<?php
// Inicia el buffer de salida
ob_start();

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'chatbotConfig.php';
require_once 'responseinjector.php';

try {
    // Log incoming request
    error_log("Received request: " . file_get_contents('php://input'));

    // Parse input
    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON: ' . json_last_error_msg());
    }

    // Validate message
    $message = $input['message'] ?? '';
    if (empty($message)) {
        throw new Exception('No message provided');
    }

    // Initialize chatbot and get response
    $chatbot = new Chatbot();
    $response = $chatbot->getResponse($message);

    // Validate response
    if (!is_array($response) || !isset($response['status'])) {
        throw new Exception('Invalid response format from chatbot');
    }

    // Verificar si hay algún contenido en el buffer
    $output_buffer = ob_get_contents();
    if (!empty($output_buffer)) {
        error_log("Unwanted output detected: " . $output_buffer);
    }
    
    // Limpia el buffer
    ob_clean();
    
    // Log response
    error_log("Sending response: " . json_encode($response));
    
    // Envía la respuesta JSON
    echo json_encode($response);

} catch (Exception $e) {
    // Limpiar el buffer
    ob_clean();
    
    error_log("Error in chatbot: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

// Finaliza y envía el buffer
ob_end_flush();
?>