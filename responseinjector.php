<?php
require_once 'chatbotLearning.php';

class ResponseInjector {
    private $learningSystem;
    private $baseResponses;

   
    public function __construct() {
        $this->learningSystem = new LearningSystem();
        $this->baseResponses =[];
        $this->injectResponse();
    }

    public function getLearningSystem() {
        return $this->learningSystem;
    }

    public function getResponse($question) {
        $question = trim($question);
        
        // Buscar en todas las categorías
        foreach ($this->baseResponses as $category => $responses) {
            foreach ($responses as $key => $response) {
                echo "Looking for category: $category<br>";
                if (strcasecmp($key, $question) === 0) {
                    return $response;
                }
            }
        }
        
        return "Im sorry, I dont understand this question.";
    }

public function injectResponse() {
    $this->baseResponses = [
        "Salutations" => [
            "Hello" => "Hi there!",
            "Greetings" => "Hello! How can I assist you today?",
            "Hey" => "Hey! What can I do for you?",
            "Hi" => "Hi! How can I assist you today",
            "Good morning" => "Good morning! How can I help you today?",
            "Good afternoon" => "Good afternoon! How can I assist you today?",
            "Good evening" => "Good evening! How can I assist you today?",
            "Goodnight" => "Goodnight! How can I help you today?"
        ],
        
        "Farewells" => [
            "Goodbye" => "Goodbye! Have a great day!",
            "See you later" => "See you later! Take care!",
            "Bye" => "Bye! Have a great day!",
            "Take care" => "Take care! Have a great day!",
            "See you soon" => "See you soon! Take care!",
            "Catch you later" => "Catch you later! Have a great day!"
        ],

        "Common knowledge" => [
            "What is your name?" => "I am Ada, chatbot created to assist you.",
            "What is 2 + 2?" => "2 + 2 = 4",
            "What is the capital of France?" => "The capital of France is Paris.",
            "What is the capital of Germany?" => "The capital of Germany is Berlin.",
            "What is the capital of Italy?" => "The capital of Italy is Rome.",
            "What is the capital of Spain?" => "The capital of Spain is Madrid."
        ]
    ];
    
    $this->saveToFile();
    return $this->baseResponses;
}

private function saveToFile() {
    file_put_contents('base_responses.json', json_encode($this->baseResponses, JSON_PRETTY_PRINT));
}

public function injectFromFile($fileName) {
    if (file_exists($fileName)) {
        $content = file_get_contents($fileName);
        $this->baseResponses = json_decode($content, true);
        return $this->baseResponses;
    }
    return false;
}
}
?>