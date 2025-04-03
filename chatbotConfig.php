<?php
require_once 'chatbot.php';

class Chatbot {
    private $token;
    private $url;
    private $context = [];

public function __construct() {
    $this->token = API_TOKEN;
    $this->url = API_URL;
}

public function getResponse($message, $options = []) {
    $processedMessage = $this -> preprocessMessage($message);
    $this->updatedContext($processedMessage);

    $parameters = [
        'max_length' => $options['max_length'] ?? 200,
        'temperature' => $options['temperature'] ?? 1.0,
        'top_p' => $options['top_p'] ?? 0.9,
        'do_sample => true,'
    ];

    $data = json_encode([
        'inputs' => $message,
        'parameters' => $parameters
    ]);

        $ch = curl_init($this->url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json'
            ]
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
?>

<?php
require_once 'Chatbot.php';

try {
    // Crear instancia del chatbot
    $bot = new Chatbot();

    // Probar con un mensaje
    $response = $bot->getResponse("What day is it?");

    // Mostrar respuesta
    echo "Respuesta del bot:\n";
    print_r($response);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>