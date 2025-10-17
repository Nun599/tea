<?php
ob_start();
include 'db_connection.php';    

// Handle stock update
if (isset($_POST['update_stock'])) {
    $product_id = $_POST['product_id'];
    $new_stock = $_POST['stock_quantity'];
    $reason = $_POST['reason'] ?? 'Manual stock update';
    $current_category = $_POST['current_category'] ?? '';
    
    // Validate stock quantity
    if ($new_stock >= 0) {
        try {
            // Determine product availability based on stock
            $is_available = $new_stock > 0 ? 1 : 0;
            
            // Use stored procedure to update stock and log changes
            $stmt = $pdo->prepare("CALL UpdateProductStock(?, ?, 'adjustment', ?, 1)");
            if ($stmt->execute([$product_id, $new_stock, $reason])) {
                // Update product availability status
                $update_availability = $pdo->prepare("UPDATE products SET is_available = ? WHERE id = ?");
                $update_availability->execute([$is_available, $product_id]);
                
                ob_end_clean();
                $redirect_url = "admin_products.php?success=1";
                if (!empty($current_category)) {
                    $redirect_url .= "&category=" . urlencode($current_category);
                }
                header("Location: " . $redirect_url);
                exit;
            }
        } catch (Exception $e) {
            error_log("Stock update error: " . $e->getMessage());
            // Fallback to direct update if stored procedure fails
            $is_available = $new_stock > 0 ? 1 : 0;
            
            $stmt = $pdo->prepare("UPDATE products SET stock_quantity = ?, is_available = ? WHERE id = ?");
            $stmt->execute([$new_stock, $is_available, $product_id]);
            
            ob_end_clean();
            $redirect_url = "admin_products.php?success=1";
            if (!empty($current_category)) {
                $redirect_url .= "&category=" . urlencode($current_category);
            }
            header("Location: " . $redirect_url);
            exit;
        }
    }
}

include 'admin_header.php'; 

// Get category filter
$category_filter = $_GET['category'] ?? '';

// Build query with filter
$query = "
    SELECT p.*, 
           CASE 
               WHEN p.stock_quantity = 0 THEN 'out-of-stock'
               WHEN p.stock_quantity <= p.low_stock_threshold THEN 'low-stock'
               ELSE 'in-stock'
           END as stock_status
    FROM products p
    WHERE 1=1
";

$params = [];

if (!empty($category_filter)) {
    $query .= " AND p.category = ?";
    $params[] = $category_filter;
}

$query .= " ORDER BY 
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
        name";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get unique categories for filter dropdown
$categories = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category")->fetchAll(PDO::FETCH_ASSOC);

// Show success message
if (isset($_GET['success'])) {
    echo '<div class="alert alert-success">Stock updated successfully!</div>';
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Product Inventory</h2>
                    <div class="header-actions">
                        <a href="admin_stock_management.php" class="btn btn-primary">Manage Stock</a>
                        <a href="admin_stock_history.php" class="btn btn-secondary">Stock History</a>
                        <a href="admin_add_product.php" class="btn btn-success">Add New Product</a>
                    </div>
                </div>
            </div>

            <!-- Category Filter Section -->
            <div class="card">
                <div class="card-header">
                    <h3>Filter Products by Category</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="">
                        <div class="filter-row">
                            <div class="form-group">
                                <label for="category">Select Category:</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">All Categories</option>
                                    <?php foreach($categories as $cat): ?>
                                    <option value="<?php echo $cat['category']; ?>" 
                                        <?php echo $category_filter == $cat['category'] ? 'selected' : ''; ?>>
                                        <?php echo ucfirst($cat['category']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Apply Filter</button>
                            <a href="admin_products.php" class="btn btn-secondary">Show All</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Table -->
            <div class="card">
                <div class="card-header">
                    <h3>
                        <?php 
                        if (!empty($category_filter)) {
                            echo ucfirst($category_filter) . " Products";
                        } else {
                            echo "All Products";
                        }
                        ?> 
                        (<?php echo count($products); ?> products)
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (count($products) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Flavors</th>
                                    <th>Category</th>
                                    <th>Regular Price</th>
                                    <th>Large Price</th>
                                    <th>Stock Quantity</th>
                                    <th>Low Stock Threshold</th>
                                    <th>Stock Status</th>
                                    <th>Product Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($products as $product): 
                                    $stock_class = '';
                                    $stock_text = '';
                                    $availability_class = '';
                                    $availability_text = '';
                                    
                                    switch($product['stock_status']) {
                                        case 'out-of-stock':
                                            $stock_class = 'status-cancelled';
                                            $stock_text = 'Out of Stock ('.$product['stock_quantity'].')';
                                            $availability_class = 'status-cancelled';
                                            $availability_text = 'Not Available';
                                            break;
                                        case 'low-stock':
                                            $stock_class = 'status-pending';
                                            $stock_text = 'Low Stock ('.$product['stock_quantity'].')';
                                            $availability_class = 'status-completed';
                                            $availability_text = 'Available';
                                            break;
                                        default:
                                            $stock_class = 'status-completed';
                                            $stock_text = 'In Stock ('.$product['stock_quantity'].')';
                                            $availability_class = 'status-completed';
                                            $availability_text = 'Available';
                                    }
                                ?>
                                <tr>
                                    <td><?php echo $product['id']; ?></td>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo ucfirst($product['category']); ?></td>
                                    <td>₱<?php echo number_format($product['price_regular'], 2); ?></td>
                                    <td>₱<?php echo $product['price_large'] ? number_format($product['price_large'], 2) : 'N/A'; ?></td>
                                    <td>
                                        <input type="number" 
                                               name="stock_updates[<?php echo $product['id']; ?>]" 
                                               value="<?php echo $product['stock_quantity']; ?>"
                                               min="0" 
                                               class="form-control" 
                                               style="width: 80px;"
                                               onchange="updateStock(<?php echo $product['id']; ?>, this.value)">
                                    </td>
                                    <td><?php echo $product['low_stock_threshold']; ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $stock_class; ?>">
                                            <?php echo $stock_text; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge <?php echo $availability_class; ?>">
                                            <?php echo $availability_text; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-sm" onclick="openStockModal(<?php echo $product['id']; ?>, '<?php echo htmlspecialchars($product['name']); ?>', <?php echo $product['stock_quantity']; ?>, '<?php echo $category_filter; ?>')">
                                            Update Stock
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <p class="no-data">No products found in this category.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stock Update Modal -->
<div id="stockModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h3>Update Stock</h3>
        <form method="POST" action="">
            <input type="hidden" name="product_id" id="modal_product_id">
            <input type="hidden" name="current_category" id="modal_current_category">
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
            <div class="form-group">
                <div class="alert alert-info">
                    <strong>Note:</strong> Product status will automatically update:<br>
                    - <strong>Available</strong> when stock is greater than 0<br>
                    - <strong>Not Available</strong> when stock is 0
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" name="update_stock" class="btn btn-primary">Update Stock</button>
                <button type="button" class="btn btn-secondary" onclick="closeStockModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openStockModal(productId, productName, currentStock, currentCategory) {
    document.getElementById('modal_product_id').value = productId;
    document.getElementById('modal_product_name').value = productName;
    document.getElementById('modal_current_stock').value = currentStock;
    document.getElementById('stock_quantity').value = currentStock;
    document.getElementById('modal_current_category').value = currentCategory;
    document.getElementById('stockModal').style.display = 'block';
}

function closeStockModal() {
    document.getElementById('stockModal').style.display = 'none';
}

function updateStock(productId, newStock) {
    if (confirm('Are you sure you want to update the stock quantity?')) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '';
        
        const productIdInput = document.createElement('input');
        productIdInput.type = 'hidden';
        productIdInput.name = 'product_id';
        productIdInput.value = productId;
        
        const stockInput = document.createElement('input');
        stockInput.type = 'hidden';
        stockInput.name = 'stock_quantity';
        stockInput.value = newStock;
        
        const reasonInput = document.createElement('input');
        reasonInput.type = 'hidden';
        reasonInput.name = 'reason';
        reasonInput.value = 'Quick Update';
        
        const updateStockInput = document.createElement('input');
        updateStockInput.type = 'hidden';
        updateStockInput.name = 'update_stock';
        updateStockInput.value = '1';
        
        form.appendChild(productIdInput);
        form.appendChild(stockInput);
        form.appendChild(reasonInput);
        form.appendChild(updateStockInput);
        
        document.body.appendChild(form);
        form.submit();
    } else {
        // Reload the page to reset the input value
        location.reload();
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('stockModal');
    if (event.target === modal) {
        closeStockModal();
    }
}

document.querySelector('.close-modal').onclick = closeStockModal;

// Auto-submit category filter when category is selected
document.getElementById('category').addEventListener('change', function() {
    this.form.submit();
});
</script>

<style>
.filter-row {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 20px;
}

.form-actions {
    text-align: center;
    margin-top: 20px;
}

.header-actions {
    display: flex;
    gap: 10px;
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

.status-completed {
    background-color: #28a745;
    color: white;
}

.status-cancelled {
    background-color: #dc3545;
    color: white;
}

.status-pending {
    background-color: #ffc107;
    color: #212529;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
}

.no-data {
    text-align: center;
    padding: 40px;
    color: #6c757d;
    font-style: italic;
}

.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.table th {
    background-color: #f8f9fa;
    font-weight: bold;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0,0,0,.05);
}

.btn {
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-success {
    background-color: #28a745;
    color: white;
}

.btn-info {
    background-color: #17a2b8;
    color: white;
}

.btn-sm {
    padding: 4px 8px;
    font-size: 12px;
}

.alert {
    padding: 12px;
    border-radius: 4px;
    margin-bottom: 15px;
}

.alert-info {
    background-color: #d1ecf1;
    border: 1px solid #bee5eb;
    color: #0c5460;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

/* Stock quantity styling */
.stock-quantity.out-of-stock {
    color: #dc3545;
    font-weight: bold;
}

.stock-quantity.low-stock {
    color: #ffc107;
    font-weight: bold;
}

.stock-quantity.in-stock {
    color: #28a745;
    font-weight: bold;
}

/* Input field styling for stock quantities */
input[type="number"].form-control {
    text-align: center;
}
</style>

<?php 
include 'admin_footer.php'; 
ob_end_flush();
?>