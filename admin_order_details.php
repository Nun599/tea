<?php include 'admin_header.php'; ?>
<?php include 'db_connection.php'; ?>

<?php
if (!isset($_GET['id'])) {
    header("Location: admin_orders.php");
    exit;
}

$order_id = $_GET['id'];

// Get order details
$order = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$order->execute([$order_id]);
$order = $order->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "Order not found";
    exit;
}

// Get order items
$order_items = $pdo->prepare("
    SELECT oi.*, 
           GROUP_CONCAT(CONCAT(oa.addon_name, ' (₱', oa.addon_price, ')') SEPARATOR ', ') as addons
    FROM order_items oi 
    LEFT JOIN order_item_addons oa ON oi.id = oa.order_item_id
    WHERE oi.order_id = ? 
    GROUP BY oi.id
");
$order_items->execute([$order_id]);
$order_items = $order_items->fetchAll(PDO::FETCH_ASSOC);
?>

<h3>Order Items</h3>
<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Size</th>
            <th>Add-ons</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($order_items as $item): ?>
        <tr>
            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
            <td><?php echo ucfirst($item['size']); ?></td>
            <td><?php echo $item['addons'] ? htmlspecialchars($item['addons']) : 'None'; ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td>₱<?php echo number_format($item['price'], 2); ?></td>
            <td>₱<?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="5" style="text-align: right; font-weight: bold;">Subtotal:</td>
            <td style="font-weight: bold;">₱<?php echo number_format($order['subtotal'], 2); ?></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right; font-weight: bold;">Grand Total:</td>
            <td style="font-weight: bold;">₱<?php echo number_format($order['total_amount'], 2); ?></td>
        </tr>
    </tbody>
</table>
</div>

<?php include 'admin_footer.php'; ?>