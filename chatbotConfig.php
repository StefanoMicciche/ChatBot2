<?php
require_once 'chatbot.php';
require_once 'chatbotLearning.php';
require_once 'responseinjector.php';

class Chatbot {
    private $token;
    private $url;
    private $context = [];
    private $responseInjector;

    public function __construct() {
        $this->token = API_TOKEN;
        $this->url = API_URL;
        $this->context =[];
        $this->responseInjector = new ResponseInjector();
    }

    public function getResponse($message, $options = []) {
        try {
            $processedMessage = $this->preprocessMessage($message);
            $this->updatedContext($processedMessage);
    
            // Get predefined response first
            $predefinedResponse = $this->responseInjector->getResponse($processedMessage);
            if ($predefinedResponse !== "Im sorry, I dont understand this question.") {
                return [
                    'status' => 'success',
                    'message' => $predefinedResponse,
                    'confidence' => 1.0,
                    'source' => 'predefined'
                ];
            }
    
            // If no predefined response, try API
            $parameters = [
                'max_length' => $options['max_length'] ?? 200,
                'temperature' => $options['temperature'] ?? 1.0,
                'top_p' => $options['top_p'] ?? 0.9,
                'do_sample' => true,
            ];
    
            $data = json_encode([
                'inputs' => $this->formatPrompt($processedMessage),
                'parameters' => $parameters
            ]);
    
            $apiResponse = $this->makeApiRequest($data);
            
            if (!$apiResponse || !isset($apiResponse[0]['generated_text'])) {
                throw new Exception('Invalid API response');
            }
            
            return [
                'status' => 'success',
                'message' => $this->improveResponse($apiResponse[0]['generated_text']),
                'confidence' => $apiResponse[0]['score'] ?? 0.8,
                'source' => 'api'
            ];
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'confidence' => null,
                'source' => null
            ];
        }
    }
    

    private function preprocessMessage($message) {
        $message = trim($message);
        $message = strtolower($message);
        return $message;
    }

    private function updatedContext($message) {
        $this->context[] = $message;
        if (count($this->context) > 5) {
            array_shift($this->context);
        }
    }

    private function formatPrompt($message) {
        $prompt = "Context: Previous messages - " . implode(", ", $this->context) . "\n";
        $prompt .= "Current message: " . $message . "\n";
        $prompt .= "Please provide a helpful response.";
        return $prompt;
    }

    private function makeApiRequest($data) {
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
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception('Error making API request: ' . $error);
        }

        return json_decode($response, true);
    }

    private function formatResponse($response) {

// Si es una respuesta inválida
if (!$response || !is_array($response)) {
    return [
        'status' => 'error',
        'message' => 'Invalid response from API',
        'confidence' => null
    ];
}

// Si es una respuesta de la API
if (isset($response[0]['generated_text'])) {
    $text = $response[0]['generated_text'];
    $text = $this->improveResponse($text);
    
    return [
        'status' => 'success',
        'message' => $text,
        'confidence' => $response[0]['score'] ?? 0.8
    ];
}

return [
    'status' => 'error',
    'message' => 'No response generated',
    'confidence' => null
];
    }

private function improveResponse($text) {
    if (!preg_match('/[.!?]$/', $text)) {
        $text .= '.';
    }

    $genericResponses = [
        "I don't know" => "I'm not sure about that, but I can help you find the information.",
        "I can't help" => "While this might be beyond my current capabilities, I can suggest alternatives."
    ];

    foreach ($genericResponses as $generic => $better) {
        if (stripos($text, $generic) !== false) {
            $text = $better;
        }
    }

    return $text;
}
}
?>
