<?php
require_once 'chatbotConfig.php';
require_once 'chatbotLearning.php';

try {
    // 1. Crear instancia del bot
    $bot = new Chatbot();

    // 2. Probar diferentes temperaturas
    $responses = [];

    // Respuesta conservadora
    $responses[] = $bot->getResponse("Hello", [
        'temperature' => 0.3,
        'max_length' => 200
    ]);

    // Respuesta balanceada
    $responses[] = $bot->getResponse("¿How are you?", [
        'temperature' => 0.7,
        'max_length' => 200
    ]);

    // Respuesta creativa
    $responses[] = $bot->getResponse("Tell me a story", [
        'temperature' => 1.0,
        'max_length' => 300
    ]);
// 3. Mostrar todas las respuestas
foreach ($responses as $index => $response) {
    echo "\nPrueba " . ($index + 1) . ":\n";
    if ($response['status'] === 'success') {
        echo "Bot: " . $response['message'] . "\n";
        if (isset($response['confidence'])) {
            echo "Confidence: " . $response['confidence'] . "\n";
        }
    } else {
        echo "Error: " . $response['message'] . "\n";
    }
    echo "------------------------\n";
}

// 4. Probar manejo de contexto
echo "\nContext test:\n";
$contextTest = [
    "My name is Tralalero Tralala",
    "I have 26 years old",
    "I live in Alicante"
];

foreach ($contextTest as $message) {
    $response = $bot->getResponse($message);
    echo "Usuario: $message\n";
    echo "Bot: " . ($response['status'] === 'success' ? $response['message'] : $response['message']) . "\n";
}

// 5. Probar manejo de errores
echo "\nError tests:\n";
try {
    $response = $bot->getResponse("");  // Mensaje vacío
    echo "Answer empty messsage: " . $response['message'] . "\n";
} catch (Exception $e) {
    echo "Controlled error: " . $e->getMessage() . "\n";
}

// 6. Probar diferentes formatos de respuesta
echo "\nFormat tests:\n";
$testMessages = [
    "¿What time is it?",
    "I don't know the answer",  // Probará improveResponse
    "Tell me a joke"
];

foreach ($testMessages as $message) {
    $response = $bot->getResponse($message);
    echo "Question: $message\n";
    echo "Answer: " . $response['message'] . "\n";
    echo "------------------------\n";
}

} catch (Exception $e) {
echo "General error: " . $e->getMessage() . "\n";
    
}


