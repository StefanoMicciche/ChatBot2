<?php
header('content-type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

//simulate POST request\
$testMessage = "Hello, Ada";
$testInput = json_encode(['message' => $testMessage]);

// log test parameters
echo json_encode([
    'test_started' => true,
    'test_message' => $testMessage,
    ]) . "\n";


?>