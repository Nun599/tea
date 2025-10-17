<?php
ob_start();
include 'db_connection.php';

// Get filter parameters
$product_id = $_GET['product_id'] ?? '';
$change_type = $_GET['change_type'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';

// Build query with filters
$query = "
    SELECT il.*, p.name as product_name, u.first_name, u.last_name 
    FROM inventory_logs il
    LEFT JOIN products p ON il.product_id = p.id
    LEFT JOIN users u ON il.changed_by = u.id
    WHERE 1=1
";

$params = [];

if (!empty($product_id)) {
    $query .= " AND il.product_id = ?";
    $params[] = $product_id;
}

if (!empty($change_type)) {
    $query .= " AND il.change_type = ?";
    $params[] = $change_type;
}

if (!empty($date_from)) {
    $query .= " AND DATE(il.changed_at) >= ?";
    $params[] = $date_from;
}

if (!empty($date_to)) {
    $query .= " AND DATE(il.changed_at) <= ?";
    $params[] = $date_to;
}

$query .= " ORDER BY il.changed_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$stock_history = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get products for filter
$products = $pdo->query("SELECT id, name FROM products ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

include 'admin_header.php';
?>

<div class="card">
    <div class="card-header">
        <h2>Stock History</h2>
        <div class="header-actions">
            <a href="admin_stock_management.php" class="btn btn-secondary">Back to Stock Management</a>
            <a href="admin_products.php" class="btn btn-info">View Products</a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card">
        <div class="card-header">
            <h3>Filters</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="">
                <div class="filter-row">
                    <div class="form-group">
                        <label for="product_id">Product:</label>
                        <select name="product_id" id="product_id" class="form-control">
                            <option value="">All Products</option>
                            <?php foreach($products as $product): ?>
                            <option value="<?php echo $product['id']; ?>" 
                                <?php echo $product_id == $product['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($product['name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="change_type">Change Type:</label>
                        <select name="change_type" id="change_type" class="form-control">
                            <option value="">All Types</option>
                            <option value="stock_in" <?php echo $change_type == 'stock_in' ? 'selected' : ''; ?>>Stock In</option>
                            <option value="stock_out" <?php echo $change_type == 'stock_out' ? 'selected' : ''; ?>>Stock Out</option>
                            <option value="adjustment" <?php echo $change_type == 'adjustment' ? 'selected' : ''; ?>>Adjustment</option>
                            <option value="initial" <?php echo $change_type == 'initial' ? 'selected' : ''; ?>>Initial</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="date_from">Date From:</label>
                        <input type="date" name="date_from" id="date_from" 
                               value="<?php echo $date_from; ?>" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="date_to">Date To:</label>
                        <input type="date" name="date_to" id="date_to" 
                               value="<?php echo $date_to; ?>" class="form-control">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="admin_stock_history.php" class="btn btn-secondary">Clear Filters</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stock History Table -->
    <div class="card">
        <div class="card-header">
            <h3>Stock Changes History</h3>
        </div>
        <div class="card-body">
            <?php if (count($stock_history) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Product</th>
                        <th>Change Type</th>
                        <th>Old Stock</th>
                        <th>New Stock</th>
                        <th>Difference</th>
                        <th>Reason</th>
                        <th>Changed By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($stock_history as $log): 
                        $difference = $log['new_stock'] - $log['old_stock'];
                        $difference_class = $difference > 0 ? 'text-success' : ($difference < 0 ? 'text-danger' : '');
                        $change_type_class = '';
                        switch($log['change_type']) {
                            case 'stock_in': $change_type_class = 'status-completed'; break;
                            case 'stock_out': $change_type_class = 'status-cancelled'; break;
                            case 'adjustment': $change_type_class = 'status-pending'; break;
                            default: $change_type_class = 'status-info';
                        }
                    ?>
                    <tr>
                        <td><?php echo date('M j, Y g:i A', strtotime($log['changed_at'])); ?></td>
                        <td><?php echo htmlspecialchars($log['product_name']); ?></td>
                        <td>
                            <span class="status-badge <?php echo $change_type_class; ?>">
                                <?php echo ucfirst(str_replace('_', ' ', $log['change_type'])); ?>
                            </span>
                        </td>
                        <td><?php echo $log['old_stock']; ?></td>
                        <td><?php echo $log['new_stock']; ?></td>
                        <td class="<?php echo $difference_class; ?>">
                            <?php echo $difference > 0 ? '+' : ''; ?><?php echo $difference; ?>
                        </td>
                        <td><?php echo htmlspecialchars($log['reason']); ?></td>
                        <td><?php echo $log['first_name'] . ' ' . $log['last_name']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p class="no-data">No stock history found matching your filters.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.filter-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.form-actions {
    text-align: center;
    margin-top: 20px;
}

.text-success {
    color: #28a745;
    font-weight: bold;
}

.text-danger {
    color: #dc3545;
    font-weight: bold;
}

.status-info {
    background-color: #17a2b8;
    color: white;
}

.no-data {
    text-align: center;
    padding: 40px;
    color: #6c757d;
    font-style: italic;
}
</style>

<?php 
include 'admin_footer.php'; 
ob_end_flush();
?>