<?php
include 'db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $customer_name = $input['customer_name'] ?? '';
    $customer_phone = $input['customer_phone'] ?? '';
    $customer_email = $input['customer_email'] ?? '';
    $payment_method = $input['payment_method'] ?? '';
    $total_amount = $input['total_amount'] ?? 0;
    $items = $input['items'] ?? [];

    if (!empty($customer_name) && !empty($customer_phone) && !empty($items)) {
        try {
            // Start transaction
            $pdo->beginTransaction();

            // Insert order
            $order_stmt = $pdo->prepare("
                INSERT INTO orders (customer_name, customer_phone, customer_email, payment_method, total_amount, status) 
                VALUES (?, ?, ?, ?, ?, 'pending')
            ");
            $order_stmt->execute([$customer_name, $customer_phone, $customer_email, $payment_method, $total_amount]);
            $order_id = $pdo->lastInsertId();

            // Process each item
            foreach ($items as $item) {
                // Get product ID first
                $product_stmt = $pdo->prepare("SELECT id, stock_quantity FROM products WHERE name = ?");
                $product_stmt->execute([$item['name']]);
                $product = $product_stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$product) {
                    throw new Exception("Product not found: " . $item['name']);
                }
                
                $product_id = $product['id'];
                $current_stock = $product['stock_quantity'];
                
                // Check stock availability
                if ($current_stock < $item['quantity']) {
                    throw new Exception("Insufficient stock for: " . $item['name'] . ". Available: " . $current_stock . ", Requested: " . $item['quantity']);
                }

                // Insert order item
                $item_stmt = $pdo->prepare("
                    INSERT INTO order_items (order_id, product_name, size, quantity, price, sweetness, addons) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $addons_text = !empty($item['addons']) ? implode(', ', $item['addons']) : '';
                $item_stmt->execute([
                    $order_id, 
                    $item['name'], 
                    $item['size'], 
                    $item['quantity'], 
                    $item['price'],
                    $item['sweetness'] ?? '100% Sweet',
                    $addons_text
                ]);

                // Calculate new stock
                $new_stock = $current_stock - $item['quantity'];
                
                // Update product stock
                $update_stmt = $pdo->prepare("UPDATE products SET stock_quantity = ? WHERE id = ?");
                $update_stmt->execute([$new_stock, $product_id]);
                
                // Log stock change
                $log_stmt = $pdo->prepare("
                    INSERT INTO inventory_logs (product_id, old_stock, new_stock, change_type, reason, changed_by) 
                    VALUES (?, ?, ?, 'stock_out', ?, 1)
                ");
                $log_stmt->execute([
                    $product_id, 
                    $current_stock, 
                    $new_stock, 
                    'Order #' . $order_id . ' - ' . $item['quantity'] . 'x ' . $item['name']
                ]);
            }

            $pdo->commit();
            echo json_encode(['success' => true, 'order_id' => $order_id]);

        } catch (Exception $e) {
            $pdo->rollBack();
            error_log("Order Error: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>