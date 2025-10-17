<?php
include 'db_connection.php';

// Test if database connection works
$stmt = $pdo->query("SELECT id, name, category, is_available FROM products LIMIT 5");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Current Products in Database:</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Name</th><th>Category</th><th>Available</th></tr>";
foreach($products as $product) {
    echo "<tr>";
    echo "<td>{$product['id']}</td>";
    echo "<td>{$product['name']}</td>";
    echo "<td>{$product['category']}</td>";
    echo "<td>{$product['is_available']}</td>";
    echo "</tr>";
}
echo "</table>";

// Test toggle
if (isset($_GET['test_toggle'])) {
    $product_id = $_GET['test_toggle'];
    $stmt = $pdo->prepare("UPDATE products SET is_available = NOT is_available WHERE id = ?");
    $stmt->execute([$product_id]);
    echo "<p>Toggled product ID: $product_id</p>";
}
?>

<p><a href="test_availability.php?test_toggle=1">Toggle Product ID 1</a></p>
<p><a href="admin_products.php">Go to Admin Products</a></p>