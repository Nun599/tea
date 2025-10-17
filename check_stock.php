<?php
// check_stock.php
include 'db_connection.php';

header('Content-Type: application/json');

$product_name = $_GET['product'] ?? '';
$quantity = intval($_GET['quantity'] ?? 1);
$category = $_GET['category'] ?? '';

try {
    if (empty($product_name)) {
        echo json_encode(['error' => 'Product name is required']);
        exit;
    }
    
    // Build query
    $query = "SELECT stock_quantity, is_available FROM products WHERE name = ?";
    $params = [$product_name];
    
    if (!empty($category)) {
        $query .= " AND category = ?";
        $params[] = $category;
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        echo json_encode(['error' => 'Product not found', 'available' => false]);
        exit;
    }
    
    $stock_quantity = intval($product['stock_quantity']);
    $is_available = boolval($product['is_available']);
    
    // Check if product is available and has sufficient stock
    $available = $is_available && ($stock_quantity >= $quantity);
    
    echo json_encode([
        'available' => $available,
        'stock_quantity' => $stock_quantity,
        'is_available' => $is_available,
        'requested_quantity' => $quantity
    ]);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage(), 'available' => true]); // Default to available on error
}
?>