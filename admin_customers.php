<?php include 'admin_header.php'; ?>
<?php include 'db_connection.php'; ?>

<?php
// Get all customers from orders (since we don't have separate customers table)
$customers = $pdo->query("
    SELECT 
        customer_name,
        customer_phone,
        customer_address,
        COUNT(*) as total_orders,
        SUM(total_amount) as total_spent,
        MAX(order_date) as last_order
    FROM orders 
    GROUP BY customer_phone, customer_name
    ORDER BY last_order DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card">
    <div class="card-header">
        <h2>Customers</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Total Orders</th>
                <th>Total Spent</th>
                <th>Last Order</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($customers as $customer): ?>
            <tr>
                <td><?php echo htmlspecialchars($customer['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($customer['customer_phone']); ?></td>
                <td><?php echo htmlspecialchars($customer['customer_address']); ?></td>
                <td><?php echo $customer['total_orders']; ?></td>
                <td>₱<?php echo number_format($customer['total_spent'], 2); ?></td>
                <td><?php echo date('M d, Y', strtotime($customer['last_order'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'admin_footer.php'; ?>