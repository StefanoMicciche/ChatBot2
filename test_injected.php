<?php
// Activar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'responseinjector.php';

try {
    $injector = new ResponseInjector();
    
    // Guardar y mostrar las respuestas
    $questions = [
        "Hello",
        "What is your name?",
        "What is 2 + 2?",
        "What is the capital of France?",

    ];
    
    foreach ($questions as $question) {
        echo "<strong>Pregunta:</strong> " . $question . "<br>";
        echo "<strong>Respuesta:</strong> " . $injector->getResponse($question) . "<br><br>";
    }

    // Obtener y mostrar el learning system
    $learning = $injector->getLearningSystem();
    echo "<pre>Learning System: ";
    print_r($learning);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>