<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the request
    $json_data = file_get_contents('php://input');
    $orderData = json_decode($json_data, true);
    
    // Validate the data
    if ($orderData && isset($orderData['customer_name']) && isset($orderData['items'])) {
        
        // SKIP ALL STOCK VALIDATION - DIRECTLY SAVE ORDER
        $_SESSION['order_data'] = $orderData;
        echo json_encode(['success' => true, 'message' => 'Order saved without stock validation']);
        
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid order data']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>