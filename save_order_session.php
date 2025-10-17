<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Save order data to session for GCash payment
    $_SESSION['pending_order'] = $input;
    $_SESSION['pending_order']['timestamp'] = time();
    
    echo json_encode([
        'success' => true, 
        'message' => 'Order data saved to session'
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'error' => 'Invalid request method'
    ]);
}
?>