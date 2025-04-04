// test_learning.php
<?php
require_once 'chatbot.php';
require_once 'chatbotconfig.php';

try {
    $bot = new Chatbot();
    
    // Prueba 1: Primera pregunta
    $response1 = $bot->getResponse("¿Qué es PHP?");
    echo "Respuesta 1: " . $response1['message'] . "\n";
    echo "Fuente: " . ($response1['source'] ?? 'api') . "\n\n";

    // Prueba 2: Misma pregunta (debería venir del sistema de aprendizaje)
    $response2 = $bot->getResponse("¿Qué es PHP?");
    echo "Respuesta 2: " . $response2['message'] . "\n";
    echo "Fuente: " . ($response2['source'] ?? 'api') . "\n\n";

    // Ver contenido aprendido
    echo "Contenido aprendido:\n";
    $jsonFile = 'data/learned_responses.json';
    if (file_exists($jsonFile)) {
        print_r(json_decode(file_get_contents($jsonFile), true));
    } else {
        echo "No hay respuestas aprendidas todavía.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}