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
            $pdo->beginTransaction();

            // Insert order with pending status for cash, paid for GCash
            $order_status = ($payment_method === 'gcash') ? 'paid' : 'pending';
            
            $order_stmt = $pdo->prepare("
                INSERT INTO orders (customer_name, customer_phone, customer_email, payment_method, total_amount, status) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $order_stmt->execute([
                $customer_name, 
                $customer_phone, 
                $customer_email, 
                $payment_method, 
                $total_amount, 
                $order_status
            ]);
            $order_id = $pdo->lastInsertId();

            // Process each item and deduct stock
            foreach ($items as $item) {
                // Get product details including stock
                $product_stmt = $pdo->prepare("
                    SELECT id, stock_quantity, name 
                    FROM products 
                    WHERE name = ?
                ");
                $product_stmt->execute([$item['name']]);
                $product = $product_stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$product) {
                    throw new Exception("Product not found: " . $item['name']);
                }

                // Check if product is available
                $availability_stmt = $pdo->prepare("SELECT is_available FROM products WHERE id = ?");
                $availability_stmt->execute([$product['id']]);
                $is_available = $availability_stmt->fetchColumn();
                
                if (!$is_available) {
                    throw new Exception("Product not available: " . $item['name']);
                }

                // Check stock availability if stock management is enabled
                if (isset($product['stock_quantity'])) {
                    if ($product['stock_quantity'] < $item['quantity']) {
                        throw new Exception("Insufficient stock for: " . $item['name'] . ". Available: " . $product['stock_quantity'] . ", Requested: " . $item['quantity']);
                    }
                }

                // Calculate item total
                $item_total = $item['price'] * $item['quantity'];
                
                // Insert order item
                $item_stmt = $pdo->prepare("
                    INSERT INTO order_items (order_id, product_name, size, quantity, price, sweetness_level, addons) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                
                $addons_text = '';
                if (isset($item['addons']) && is_array($item['addons'])) {
                    $addons_text = implode(', ', $item['addons']);
                }
                
                $sweetness = $item['sweetness'] ?? '100% Sweet';
                
                $item_stmt->execute([
                    $order_id, 
                    $item['name'], 
                    $item['size'], 
                    $item['quantity'], 
                    $item_total,
                    $sweetness,
                    $addons_text
                ]);

                // Update stock if stock management is enabled
                if (isset($product['stock_quantity'])) {
                    $new_stock = $product['stock_quantity'] - $item['quantity'];
                    
                    $update_stmt = $pdo->prepare("UPDATE products SET stock_quantity = ? WHERE id = ?");
                    $update_stmt->execute([$new_stock, $product['id']]);
                    
                    // Log stock change if inventory_logs table exists
                    try {
                        $log_stmt = $pdo->prepare("
                            INSERT INTO inventory_logs (product_id, old_stock, new_stock, change_type, reason, changed_by) 
                            VALUES (?, ?, ?, 'stock_out', ?, 1)
                        ");
                        $log_stmt->execute([
                            $product['id'],
                            $product['stock_quantity'],
                            $new_stock,
                            'Order #' . $order_id
                        ]);
                    } catch (Exception $e) {
                        // Ignore logging errors, continue with order
                        error_log("Stock logging failed: " . $e->getMessage());
                    }
                }
            }

            $pdo->commit();
            
            echo json_encode([
                'success' => true, 
                'order_id' => $order_id,
                'message' => 'Order created successfully',
                'status' => $order_status
            ]);

        } catch (Exception $e) {
            $pdo->rollBack();
            error_log("Order processing error: " . $e->getMessage());
            echo json_encode([
                'success' => false, 
                'error' => 'Order processing failed: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false, 
            'error' => 'Missing required fields: customer name, phone, or items'
        ]);
    }
} else {
    echo json_encode([
        'success' => false, 
        'error' => 'Invalid request method'
    ]);
}
?>