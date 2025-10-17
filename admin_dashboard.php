<?php include 'admin_header.php'; ?>
<?php include 'db_connection.php'; ?>

<?php
// Get stats
$total_orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$pending_orders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn();
$today_orders = $pdo->query("SELECT COUNT(*) FROM orders WHERE DATE(order_date) = CURDATE()")->fetchColumn();
$total_revenue = $pdo->query("SELECT SUM(total_amount) FROM orders WHERE status = 'completed'")->fetchColumn();
$total_revenue = $total_revenue ? $total_revenue : 0;

// Get recent orders
$recent_orders = $pdo->query("
    SELECT o.*, 
           (SELECT COUNT(*) FROM order_items WHERE order_id = o.id) as item_count
    FROM orders o 
    ORDER BY o.order_date DESC 
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="stats-container">
    <div class="stat-card">
        <h3>Total Orders</h3>
        <div class="value"><?php echo $total_orders; ?></div>
    </div>
    <div class="stat-card">
        <h3>Pending Orders</h3>
        <div class="value"><?php echo $pending_orders; ?></div>
    </div>
    <div class="stat-card">
        <h3>Today's Orders</h3>
        <div class="value"><?php echo $today_orders; ?></div>
    </div>
    <div class="stat-card">
        <h3>Total Revenue</h3>
        <div class="value">₱<?php echo number_format($total_revenue, 2); ?></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Recent Orders</h2>
        <a href="admin_orders.php" class="btn btn-primary">View All Orders</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Items</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($recent_orders as $order): ?>
            <tr>
                <td>#<?php echo $order['id']; ?></td>
                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                <td><?php echo $order['item_count']; ?> items</td>
                <td>₱<?php echo number_format($order['total_amount'], 2); ?></td>
                <td>
                    <span class="status-badge status-<?php echo $order['status']; ?>">
                        <?php echo ucfirst($order['status']); ?>
                    </span>
                </td>
                <td>
                    <a href="admin_order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-primary btn-sm">View</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'admin_footer.php'; ?>