<?php
include 'db_connection.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    
    $sql = "SELECT is_available FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode(['available' => $product['is_available'] == 1]);
    } else {
        echo json_encode(['available' => false]);
    }
    
    $stmt->close();
} else {
    echo json_encode(['available' => false]);
}

$conn->close();
?>