<?php
include 'db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $product_id = $input['product_id'] ?? null;
    $new_stock = $input['new_stock'] ?? null;
    $change_type = $input['change_type'] ?? 'adjustment';
    $reason = $input['reason'] ?? 'API stock update';
    $user_id = $input['user_id'] ?? 1; // Default to admin user
    
    if ($product_id === null || $new_stock === null) {
        echo json_encode(['success' => false, 'error' => 'Missing required parameters']);
        exit;
    }
    
    try {
        $stmt = $pdo->prepare("CALL UpdateProductStock(?, ?, ?, ?, ?)");
        $success = $stmt->execute([$product_id, $new_stock, $change_type, $reason, $user_id]);
        
        echo json_encode(['success' => $success]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>