<?php
header('content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

//simulate POST request\
$testMessage = "Hello";
$testInput = json_encode(['message' => $testMessage]);

// log test parameters
echo json_encode([
    'test_started' => true,
    'test_message' => $testMessage,
    ]) . "\n";

echo json_encode(['testing_request' => true]) . "\n";
try {
    require_once 'chatbotConfig.php';
    echo json_encode(['chatbotConfig_loaded' => true]) . "\n";

    require_once 'responseinjector.php';
    echo json_encode(['responseinjector_loaded' => true]) . "\n";
} catch (Exception $e) {
    echo json_encode([
        'error_occurred' => true,
        'error_message' => $e->getMessage()
        ]) . "\n";
        exit;
}

echo json_encode(['testing_chatbot_class' => true]) . "\n";
try {
    $chatbot = new Chatbot();
    echo json_encode(['chatbot_initialized' => true]) . "\n";
} catch (Exception $e) {
    echo json_encode([
        'chatbot_init_error' => true,
        'error_message' => $e->getMessage()
    ]) . "\n";
    exit;
}

echo json_encode(['testing_response' => true]) . "\n";
try {
echo json_encode([
    'response_generated' => true,
    'response' => $response
    ]) . "\n";
} catch (Exception $e) {
    echo json_encode([
        'error_occurred' => true,
        'error_message' => $e->getMessage()
        ]) . "\n";
        exit;
}

?>
