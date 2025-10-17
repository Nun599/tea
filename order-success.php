<?php
// order-success.php
session_start();
include 'db_connection.php';

// Kunin ang order data mula sa session
if(isset($_SESSION['current_order_id'])) {
    $order_id = $_SESSION['current_order_id'];
    
    // I-update ang status ng order to 'completed'
    $stmt = $pdo->prepare("UPDATE orders SET status = 'completed' WHERE id = ?");
    $stmt->execute([$order_id]);
    
    // Clear the session
    unset($_SESSION['current_order_id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Successful</title>
  <style>
    /* Your existing CSS styles */
    body {
      font-family: "Poppins", sans-serif;
      background-color: #f6f9fc;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .success-box {
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
      padding: 40px;
      width: 350px;
      animation: fadeIn 0.8s ease;
    }

    .checkmark {
      font-size: 60px;
      color: #28a745;
      margin-bottom: 20px;
      animation: pop 0.6s ease;
    }

    h2 {
      margin: 0;
      color: #28a745;
      font-size: 24px;
    }

    p {
      color: #555;
      font-size: 16px;
      margin-top: 10px;
    }

    .redirect {
      margin-top: 20px;
      font-size: 14px;
      color: #888;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pop {
      0% { transform: scale(0.5); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }
  </style>
</head>
<body>

  <div class="success-box">
  <div class="checkmark">✅</div>
  <h2>Payment Successful!</h2>
  <p>Thank you for your purchase.<br>Your payment  successfully.</p>
  <p class="redirect">Redirecting to main in <span id="countdown">3</span> seconds...</p>
</div>

<script>
  // Set localStorage to indicate we should go to menu
  localStorage.setItem('redirectToMenu', 'true');

  // Countdown timer for redirect
  let seconds = 3; // Binago mula 5 to 3 seconds
  const countdown = document.getElementById("countdown");

  const timer = setInterval(() => {
    seconds--;
    countdown.textContent = seconds;
    if (seconds <= 0) {
      clearInterval(timer);
      window.location.href = "main.php";
    }
  }, 1000);
</script>

</body>
</html>