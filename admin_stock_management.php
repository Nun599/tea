<?php
ob_start();
include 'db_connection.php';    

// Handle availability toggle
if (isset($_GET['toggle_availability'])) {
    $product_id = $_GET['toggle_availability'];
    
    // Get current availability status and stock
    $stmt = $pdo->prepare("SELECT is_available, stock_quantity FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $current_status = $product_data['is_available'];
    $stock_quantity = $product_data['stock_quantity'];
    
    // If product has no stock, don't allow making it available
    if ($stock_quantity <= 0 && !$current_status) {
        ob_end_clean();
        header("Location: admin_products.php?error=1");
        exit;
    }
    
    // Toggle availability
    $new_status = $current_status ? 0 : 1;
    
    $stmt = $pdo->prepare("UPDATE products SET is_available = ? WHERE id = ?");
    if ($stmt->execute([$new_status, $product_id])) {
        ob_end_clean();
        header("Location: admin_products.php?success=1");
        exit;
    }
}

// Handle stock update - FIXED VERSION
if (isset($_POST['update_stock'])) {
    $product_id = $_POST['product_id'];
    $new_stock = $_POST['stock_quantity'];
    $reason = $_POST['reason'] ?? 'Manual stock update';
    
    // Validate stock quantity
    if ($new_stock >= 0) {
        try {
            $pdo->beginTransaction();
            
            // Get current stock
            $stmt = $pdo->prepare("SELECT COALESCE(stock_quantity, 0) FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $current_stock = $stmt->fetchColumn();
            
            // Update product stock
            $stmt = $pdo->prepare("UPDATE products SET stock_quantity = ? WHERE id = ?");
            $stmt->execute([$new_stock, $product_id]);
            
            // Insert into inventory_logs
            $stmt = $pdo->prepare("
                INSERT INTO inventory_logs 
                (product_id, old_stock, new_stock, change_type, reason, changed_by) 
                VALUES (?, ?, ?, 'adjustment', ?, 1)
            ");
            $stmt->execute([$product_id, $current_stock, $new_stock, $reason]);
            
            $pdo->commit();
            
            ob_end_clean();
            header("Location: admin_products.php?success=2");
            exit;
            
        } catch (Exception $e) {
            $pdo->rollBack();
            error_log("Stock update error: " . $e->getMessage());
            header("Location: admin_products.php?error=2");
            exit;
        }
    }
}

include 'admin_header.php'; 

// Get all products with categories ordered properly
$products = $pdo->query("
    SELECT p.*, 
           CASE 
               WHEN p.stock_quantity = 0 THEN 'out-of-stock'
               WHEN p.stock_quantity <= COALESCE(p.low_stock_threshold, 10) THEN 'low-stock'
               ELSE 'in-stock'
           END as stock_status
    FROM products p
    ORDER BY 
        CASE category 
            WHEN 'milktea' THEN 1
            WHEN 'cheesecake' THEN 2
            WHEN 'frappe' THEN 3
            WHEN 'premiumfrappe' THEN 4
            WHEN 'icecoffee' THEN 5
            WHEN 'hotdrinks' THEN 6
            WHEN 'milkseries' THEN 7
            WHEN 'fruittea' THEN 8
            WHEN 'soda' THEN 9
            ELSE 10
        END,
        name
")->fetchAll(PDO::FETCH_ASSOC);

// Show success message
if (isset($_GET['success'])) {
    $message = $_GET['success'] == 2 ? 'Stock updated successfully!' : 'Product availability updated successfully!';
    echo '<div class="alert alert-success">'.$message.'</div>';
}

// Show error message
if (isset($_GET['error'])) {
    if ($_GET['error'] == 1) {
        echo '<div class="alert alert-danger">Cannot make product available when stock is zero.</div>';
    } else {
        echo '<div class="alert alert-danger">Error updating stock. Please try again.</div>';
    }
}
?>

<div class="card">
    <div class="card-header">
        <h2>Product Inventory</h2>
        <div class="header-actions">
            <a href="admin_stock_management.php" class="btn btn-primary">Manage Stock</a>
            <a href="admin_stock_history.php" class="btn btn-secondary">Stock History</a>
        </div>
    </div>
    
    <div class="card-body">
        <?php if (count($products) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Flavors</th>
                    <th>Category</th>
                    <th>Regular Price</th>
                    <th>Large Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $product): 
                    $stock_class = '';
                    $stock_text = '';
                    switch($product['stock_status']) {
                        case 'out-of-stock':
                            $stock_class = 'status-cancelled';
                            $stock_text = 'Out of Stock';
                            break;
                        case 'low-stock':
                            $stock_class = 'status-pending';
                            $stock_text = 'Low Stock ('.$product['stock_quantity'].')';
                            break;
                        default:
                            $stock_class = 'status-completed';
                            $stock_text = 'In Stock ('.$product['stock_quantity'].')';
                    }
                ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo ucfirst($product['category']); ?></td>
                    <td>₱<?php echo number_format($product['price_regular'], 2); ?></td>
                    <td>₱<?php echo $product['price_large'] ? number_format($product['price_large'], 2) : 'N/A'; ?></td>
                    <td>
                        <span class="status-badge <?php echo $stock_class; ?>">
                            <?php echo $stock_text; ?>
                        </span>
                    </td>
                    <td>
                        <span class="status-badge <?php echo $product['is_available'] ? 'status-completed' : 'status-cancelled'; ?>">
                            <?php echo $product['is_available'] ? 'Available' : 'Not Available'; ?>
                        </span>
                    </td>
                    <td>
                        <a href="admin_products.php?toggle_availability=<?php echo $product['id']; ?>" 
                           class="btn <?php echo $product['is_available'] ? 'btn-warning' : 'btn-success'; ?> btn-sm"
                           onclick="return confirm('Are you sure you want to make this product <?php echo $product['is_available'] ? 'unavailable' : 'available'; ?>?')">
                            <?php echo $product['is_available'] ? 'Make Unavailable' : 'Make Available'; ?>
                        </a>
                        <button class="btn btn-info btn-sm" onclick="openStockModal(<?php echo $product['id']; ?>, '<?php echo htmlspecialchars($product['name']); ?>', <?php echo $product['stock_quantity']; ?>)">
                            Update Stock
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="no-data">No products found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Stock Update Modal -->
<div id="stockModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h3>Update Stock</h3>
        <form method="POST" action="">
            <input type="hidden" name="product_id" id="modal_product_id">
            <div class="form-group">
                <label>Product:</label>
                <input type="text" id="modal_product_name" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Current Stock:</label>
                <input type="text" id="modal_current_stock" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="stock_quantity">New Stock Quantity:</label>
                <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" min="0" required>
            </div>
            <div class="form-group">
                <label for="reason">Reason for Update:</label>
                <select name="reason" id="reason" class="form-control" required>
                    <option value="Restock">Restock</option>
                    <option value="Manual Adjustment">Manual Adjustment</option>
                    <option value="Correction">Correction</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" name="update_stock" class="btn btn-primary">Update Stock</button>
                <button type="button" class="btn btn-secondary" onclick="closeStockModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openStockModal(productId, productName, currentStock) {
    document.getElementById('modal_product_id').value = productId;
    document.getElementById('modal_product_name').value = productName;
    document.getElementById('modal_current_stock').value = currentStock;
    document.getElementById('stock_quantity').value = currentStock;
    document.getElementById('stockModal').style.display = 'block';
}

function closeStockModal() {
    document.getElementById('stockModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('stockModal');
    if (event.target === modal) {
        closeStockModal();
    }
}

document.querySelector('.close-modal').onclick = closeStockModal;
</script>

<style>
.header-actions {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: white;
    margin: 5% auto;
    padding: 20px;
    border-radius: 8px;
    width: 50%;
    max-width: 500px;
}

.close-modal {
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.form-actions {
    text-align: right;
    margin-top: 20px;
}

.status-pending {
    background-color: #ffc107;
    color: #212529;
}

.status-cancelled {
    background-color: #dc3545;
    color: white;
}

.status-completed {
    background-color: #28a745;
    color: white;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.85rem;
    font-weight: bold;
}

.no-data {
    text-align: center;
    padding: 40px;
    color: #6c757d;
    font-style: italic;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th, table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #f8f9fa;
    font-weight: bold;
}
</style>

<?php 
include 'admin_footer.php'; 
ob_end_flush();
?>