<?php
session_start();
include 'db_connection.php';

// Process GCash payment
if(isset($_POST['process_gcash'])) {
    $order_id = $_POST['order_id'] ?? 0;
    
    if($order_id > 0) {
        try {
            // Update order status to paid
            $stmt = $pdo->prepare("UPDATE orders SET status = 'paid' WHERE id = ?");
            $stmt->execute([$order_id]);
            
            // Store order ID in session for success page
            $_SESSION['current_order_id'] = $order_id;
            
            echo json_encode(['success' => true, 'order_id' => $order_id]);
            exit;
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }
}

$total = isset($_GET['total']) ? floatval($_GET['total']) : 0.00;
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

// Better validation with error message
if ($total <= 0) {
    die("Invalid total amount");
}

if ($order_id <= 0) {
    die("Invalid order ID");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GCash Payment</title>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background-color: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .gcash-container {
      background-color: #ffffff;
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      width: 380px;
      padding: 30px;
      text-align: center;
      position: relative;
    }

    .gcash-logo {
      width: 120px;
      margin-bottom: 10px;
    }

    h2 {
      color: #0072CE;
      margin-bottom: 10px;
    }

    .amount {
      font-size: 20px;
      font-weight: bold;
      color: #333;
      margin-bottom: 20px;
    }

    input[type="number"], input[type="password"] {
      width: 90%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      box-sizing: border-box;
    }

    button {
      background-color: #0072CE;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 10px;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
      transition: 0.3s;
      margin-top: 10px;
    }

    button:hover {
      background-color: #005fa3;
    }

    .success-message {
      display: none;
      color: #28a745;
      font-weight: bold;
      margin-top: 15px;
    }

    .fail-message {
      display: none;
      color: #dc3545;
      font-weight: bold;
      margin-top: 15px;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      color: #0072CE;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="gcash-container">
    <img src="gcash.png" class="gcash-logo" alt="GCash Logo">
    <h2>GCash Payment</h2>

    <p class="amount" id="total-amount">Amount: ₱<?php echo number_format($total, 2); ?></p>

    <input type="number" id="mobile-number" placeholder="Enter GCash number" maxlength="11">
    <input type="password" id="mpin" placeholder="Enter MPIN" maxlength="6">
    
    <button id="pay-btn">Pay Now</button>

    <p class="success-message" id="success">✅ Payment Successful!</p>
    <p class="fail-message" id="failed">❌ Invalid number or MPIN</p>

    <a href="main.php" class="back-link">← Back to Home</a>
  </div>

<script>
    const total = <?php echo $total; ?>;
    const orderId = <?php echo $order_id; ?>;
    
    document.getElementById("total-amount").textContent = `Amount: ₱${parseFloat(total).toFixed(2)}`;

    const payBtn = document.getElementById("pay-btn");
    const success = document.getElementById("success");
    const failed = document.getElementById("failed");

    payBtn.addEventListener("click", function() {
        const mobile = document.getElementById("mobile-number").value;
        const mpin = document.getElementById("mpin").value;

        success.style.display = "none";
        failed.style.display = "none";

        // Simple validation
        if (mobile === "" || mpin === "") {
            failed.style.display = "block";
            failed.textContent = "❌ Please enter both mobile number and MPIN";
            return;
        }

        if (mobile === "09946832063" && mpin === "1234") {
            success.style.display = "block";
            success.innerHTML = "✅ Payment Successful! Processing order...";
            
            // Process the GCash payment
            fetch('payment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'process_gcash=1&order_id=' + orderId
            })
            .then(response => response.json())
            .then(result => {
                if(result.success) {
                    success.innerHTML = "✅ Payment Successful! Redirecting...";
                    setTimeout(() => {
                        window.location.href = "order-success.php";
                    }, 2000);
                } else {
                    success.style.display = "none";
                    failed.style.display = "block";
                    failed.textContent = "❌ Payment processing failed: " + result.error;
                }
            })
            .catch(error => {
                success.style.display = "none";
                failed.style.display = "block";
                failed.textContent = "❌ Network error: " + error.message;
            });
            
        } else {
            failed.style.display = "block";
            failed.textContent = "❌ Invalid mobile number or MPIN";
        }
    });
</script>

</body>
</html>