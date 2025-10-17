<?php
include 'db_connection.php';

header('Content-Type: application/json');

if (isset($_GET['category']) && isset($_GET['name'])) {
    $category = $_GET['category'];
    $name = $_GET['name'];
    
    $stmt = $pdo->prepare("
        SELECT p.*, 
               (p.is_available = 1 AND p.stock_quantity > 0) as can_order
        FROM products p 
        WHERE p.category = ? AND p.name = ?
    ");
    $stmt->execute([$category, $name]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product) {
        echo json_encode([
            'available' => $product['can_order'],
            'stock_quantity' => $product['stock_quantity'],
            'is_available' => $product['is_available']
        ]);
    } else {
        echo json_encode([
            'available' => false,
            'stock_quantity' => 0,
            'is_available' => false
        ]);
    }
} else {
    echo json_encode([
        'available' => false,
        'stock_quantity' => 0,
        'is_available' => false
    ]);
}
?>