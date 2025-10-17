<?php
include 'db_connection.php';

// Test the system
echo "<h2>Product Availability Test</h2>";

// Test Okinawa milktea
$stmt = $pdo->prepare("SELECT * FROM products WHERE name = 'Okinawa' AND category = 'milktea'");
$stmt->execute();
$okinawa = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h3>Okinawa Milk Tea Status:</h3>";
echo "<pre>";
print_r($okinawa);
echo "</pre>";

// Test API endpoint
echo "<h3>Test API Endpoint:</h3>";
$api_url = "get_products.php?category=milktea";
echo "<p>API URL: <a href='$api_url' target='_blank'>$api_url</a></p>";

// Test toggle
echo "<h3>Test Toggle:</h3>";
echo "<p><a href='admin_products.php?toggle_availability={$okinawa['id']}'>Toggle Okinawa Availability</a></p>";
?>

<p><a href="menu.php" target="_blank">Test Menu Page</a></p>
<p><a href="admin_products.php">Go to Admin Products</a></p>