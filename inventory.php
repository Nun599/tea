<?php include 'header.php'; ?>
<?php include 'db_connection.php'; ?>

<?php
// Handle product actions
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $category = $_POST['category'];
    
    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, stock_quantity, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $stock_quantity, $category]);
    
    header("Location: inventory.php");
    exit;
}

if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $category = $_POST['category'];
    
    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock_quantity = ?, category = ? WHERE id = ?");
    $stmt->execute([$name, $description, $price, $stock_quantity, $category, $id]);
    
    header("Location: inventory.php");
    exit;
}

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    
    header("Location: inventory.php");
    exit;
}

// Get all products
$products = $pdo->query("SELECT * FROM products ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card">
    <div class="card-header">
        <h2>Product Inventory</h2>
        <button onclick="document.getElementById('addProductModal').style.display='block'" class="btn btn-primary">Add New Product</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['description']); ?></td>
                <td>$<?php echo number_format($product['price'], 2); ?></td>
                <td><?php echo $product['stock_quantity']; ?></td>
                <td><?php echo htmlspecialchars($product['category']); ?></td>
                <td>
                    <div class="action-buttons">
                        <button onclick="editProduct(<?php echo $product['id']; ?>)" class="btn btn-primary btn-sm">Edit</button>
                        <a href="inventory.php?delete_id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
    <div class="card" style="margin: 5% auto; width: 500px; max-width: 90%;">
        <div class="card-header">
            <h2>Add New Product</h2>
            <span onclick="document.getElementById('addProductModal').style.display='none'" style="cursor: pointer; font-size: 1.5rem;">&times;</span>
        </div>
        <form method="POST">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" step="0.01" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="stock_quantity" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <input type="text" name="category" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" name="add_product" class="btn btn-success">Add Product</button>
                <button type="button" onclick="document.getElementById('addProductModal').style.display='none'" class="btn btn-danger">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function editProduct(id) {
    // In a real application, you would fetch product data and populate a form
    // For this example, we'll just redirect to an edit page
    window.location.href = 'edit_product.php?id=' + id;
}
</script>

<?php include 'footer.php'; ?>