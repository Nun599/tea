<?php
// get_products.php
include 'db_connection.php';

header('Content-Type: application/json');

$category = $_GET['category'] ?? '';

try {
    if (!empty($category)) {
        $query = "SELECT * FROM products WHERE category = ? ORDER BY name";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$category]);
    } else {
        $query = "SELECT * FROM products ORDER BY category, name";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($products);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>