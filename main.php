<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>1128 TEA & CAFE</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* All your existing styles remain the same */
    
    /* Loading Modal Styles */
    .loading-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 1001;
      justify-content: center;
      align-items: center;
    }
    
    .loading-content {
      background-color: white;
      border-radius: 15px;
      padding: 40px;
      text-align: center;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
      max-width: 300px;
      width: 80%;
    }
    
    .loading-circle {
      width: 80px;
      height: 80px;
      border: 5px solid #f3f3f3;
      border-top: 5px solid #8B4513;
      border-radius: 50%;
      margin: 0 auto 20px;
      animation: spin 1s linear infinite;
    }
    
    .check-mark {
      width: 80px;
      height: 80px;
      margin: 0 auto 20px;
      display: none;
    }
    
    .check-mark::after {
      content: "✓";
      font-size: 50px;
      color: #5cb85c;
      display: block;
      line-height: 80px;
    }
    
    .loading-text {
      font-size: 18px;
      color: #333;
      margin-bottom: 10px;
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    
    /* Payment Modal Styles */
    .payment-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      justify-content: center;
      align-items: center;
    }
    
    .payment-modal-content {
      background-color: white;
      border-radius: 10px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
      overflow: hidden;
    }
    
    .payment-modal-header {
      background-color: #8B4513;
      color: white;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .payment-modal-header h3 {
      margin: 0;
      font-size: 1.3rem;
    }
    
    .close-payment-modal {
      background: none;
      border: none;
      color: white;
      font-size: 1.5rem;
      cursor: pointer;
    }
    
    .payment-modal-body {
      padding: 20px;
    }
    
    .payment-option {
      margin-bottom: 20px;
    }
    
    .payment-option h4 {
      margin-bottom: 10px;
      color: #333;
    }
    
    .cash-payment {
      text-align: center;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      margin-bottom: 20px;
    }
    
    .cash-icon {
      font-size: 3rem;
      margin-bottom: 15px;
      color: #8B4513;
    }
    
    .cash-instructions {
      margin-bottom: 20px;
      color: #666;
    }
    
    .payment-actions {
      display: flex;
      justify-content: space-between;
      gap: 10px;
    }
    
    .payment-btn {
      flex: 1;
      padding: 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      transition: all 0.3s ease;
    }
    
    .confirm-payment {
      background-color: #8B4513;
      color: white;
    }
    
    .confirm-payment:hover {
      background-color: #449d44;
    }
    
    .cancel-payment {
      background-color: #8B4513;
      color: white;
    }
    
    .cancel-payment:hover {
      background-color: #c9302c;
    }
    
    .payment-success {
      text-align: center;
      padding: 30px 20px;
    }
    
    .success-icon {
      font-size: 4rem;
      color: #5cb85c;
      margin-bottom: 20px;
    }
    
    .payment-success h4 {
      color: #333;
      margin-bottom: 10px;
    }
    
    .payment-success p {
      color: #666;
      margin-bottom: 20px;
    }
    
    .order-details-summary {
      background-color: #f9f9f9;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      text-align: left;
    }
    
    .order-details-summary h5 {
      margin-top: 0;
      margin-bottom: 10px;
      color: #333;
    }
    
    .order-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 5px;
      font-size: 0.9rem;
    }
    
    .order-total {
      border-top: 1px solid #ddd;
      padding-top: 10px;
      margin-top: 10px;
      font-weight: bold;
    }

    /* Success Message Styles */
    .success-message {
      background-color: #d4edda;
      border: 1px solid #c3e6cb;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      text-align: center;
    }
    
    .success-message h4 {
      color: #155724;
      margin-bottom: 10px;
    }
    
    .success-message p {
      color: #155724;
      margin-bottom: 5px;
    }

    /* Additional styles for logout confirmation */
    .logout-confirmation {
      max-width: 400px;
      margin: 50px auto;
      padding: 30px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    
    .logout-confirmation h3 {
      margin-bottom: 15px;
      color: #333;
    }
    
    .logout-confirmation p {
      margin-bottom: 25px;
      color: #666;
    }
    
    .logout-buttons {
      display: flex;
      justify-content: center;
      gap: 15px;
    }
    
    .logout-btn {
      padding: 10px 25px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
      transition: all 0.3s ease;
    }
    
    .logout-yes {
      background-color: #422C22;
      color: white;
    }
    
    .logout-yes:hover {
      background-color: #c9302c;
    }
    
    .logout-no {
      background-color: #AA8B7E;
      color: white;
    }
    
    .logout-no:hover {
      background-color: #449d44;
    }

    /* About Us Social Media Styles */
    .about-content {
      max-width: 800px;
      margin: 0 auto;
    }

    .about-description {
      margin-bottom: 30px;
      line-height: 1.6;
    }

    .social-media-section {
      margin-top: 40px;
      text-align: center;
    }

    .social-media-section h4 {
      margin-bottom: 20px;
      color: #333;
      font-size: 1.5rem;
    }

    .social-icons {
      display: flex;
      justify-content: center;
      gap: 25px;
      flex-wrap: wrap;
    }

    .social-icon {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-decoration: none;
      color: #333;
      transition: transform 0.3s ease, color 0.3s ease;
    }

    .social-icon:hover {
      transform: translateY(-5px);
    }

    .icon-circle {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 8px;
      font-size: 24px;
    }

    .facebook .icon-circle {
      background-color: #3b5998;
      color: white;
    }

    .tiktok .icon-circle {
      background-color: #000000;
      color: white;
    }

    .instagram .icon-circle {
      background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
      color: white;
    }

    .email .icon-circle {
      background-color: #d44638;
      color: white;
    }

    .address .icon-circle {
      background-color: #34a853;
      color: white;
    }

    .social-icon span {
      font-size: 0.9rem;
      font-weight: 500;
    }

    .note {
      margin-top: 30px;
      padding: 15px;
      background-color: #f8f9fa;
      border-radius: 8px;
      font-size: 0.9rem;
      color: #666;
    }

    .note strong {
      color: #333;
    }

    /* Home Section Advertisement Styles - UPDATED */
    .advertisement-section {
      margin: 30px 0;
      text-align: center;
    }

    .advertisement-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin-top: 20px;
      justify-items: center;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
    }

    .ad-item {
      position: relative;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
      height: 200px;
      width: 100%;
      max-width: 350px;
    }

    .ad-item:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .ad-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .ad-item:hover .ad-image {
      transform: scale(1.05);
    }

    .ad-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(transparent, rgba(0,0,0,0.7));
      padding: 20px;
      color: white;
      transform: translateY(10px);
      opacity: 0;
      transition: all 0.3s ease;
    }

    .ad-item:hover .ad-overlay {
      transform: translateY(0);
      opacity: 1;
    }

    .ad-title {
      font-size: 1.2rem;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .ad-description {
      font-size: 0.9rem;
      opacity: 0.9;
    }

    /* Responsive design for ads */
    @media (max-width: 768px) {
      .advertisement-grid {
        grid-template-columns: 1fr;
        max-width: 400px;
      }
      
      .ad-item {
        height: 180px;
        max-width: 100%;
      }
    }

    @media (max-width: 480px) {
      .advertisement-grid {
        gap: 15px;
      }
      
      .ad-item {
        height: 160px;
      }
    }
     /* Unavailable product styles */
    .product-card.unavailable {
      opacity: 0.6;
      cursor: not-allowed;
      position: relative;
    }

    .product-card.unavailable * {
      pointer-events: none !important;
    }

    .product-card.unavailable:hover {
      transform: none !important;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
    }

    .unavailable-overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.7);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 1.1rem;
      border-radius: 8px;
      z-index: 10;
    }

    .product-image {
      position: relative;
    }

    /* Validation styles */
    .error-message {
      color: #d9534f;
      font-size: 0.85rem;
      margin-top: 5px;
      display: none;
    }

    .form-group.error input {
      border-color: #d9534f;
    }

    .form-group.success input {
      border-color: #5cb85c;
    }
    /* Unavailable product styles */
.product-card.unavailable {
    opacity: 0.6;
    cursor: not-allowed;
    position: relative;
}

.product-card.unavailable * {
    pointer-events: none !important;
}

.product-card.unavailable:hover {
    transform: none !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
}

.unavailable-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.1rem;
    border-radius: 8px;
    z-index: 10;
    text-align: center;
    line-height: 1.3;
    padding: 10px;
}

.product-image {
    position: relative;
}
/* Unavailable product styles */
.product-card.unavailable {
    opacity: 0.6;
    cursor: not-allowed;
    position: relative;
}

.product-card.unavailable * {
    pointer-events: none !important;
}

.product-card.unavailable:hover {
    transform: none !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
}

.unavailable-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.1rem;
    border-radius: 8px;
    z-index: 10;
    text-align: center;
    line-height: 1.3;
    padding: 10px;
}

.product-image {
    position: relative;
}

/* Payment Loading Modal */
#payment-loading-modal {
    z-index: 1002;
}

/* Enhanced Loading Animation - STEP 3 */
.progress-circle {
    width: 80px;
    height: 80px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #8B4513;
    border-radius: 50%;
    margin: 0 auto 20px;
    animation: spin 1s linear infinite;
    position: relative;
}

.progress-fill {
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    border: 5px solid transparent;
    border-top: 5px solid #8B4513;
    border-radius: 50%;
    animation: fill 5s linear forwards;
}

@keyframes fill {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.success-checkmark {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    position: relative;
    display: none;
}

.success-checkmark::after {
    content: "✓";
    font-size: 50px;
    color: #5cb85c;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation: checkmark 0.5s ease-in-out;
}

@keyframes checkmark {
    0% { transform: translate(-50%, -50%) scale(0); }
    50% { transform: translate(-50%, -50%) scale(1.2); }
    100% { transform: translate(-50%, -50%) scale(1); }
}
/* Ensure cheesecake products are always clickable */
.product-card[data-type="cheesecake"] {
    pointer-events: auto !important;
    cursor: pointer !important;
    opacity: 1 !important;
}

.product-card[data-type="cheesecake"].unavailable {
    opacity: 1 !important;
}

.product-card[data-type="cheesecake"] .unavailable-overlay {
    display: none !important;
}
/* Ensure cheesecake products are always clickable */
.product-card[data-type="cheesecake"] {
    pointer-events: auto !important;
    cursor: pointer !important;
    opacity: 1 !important;
}

.product-card[data-type="cheesecake"].unavailable {
    opacity: 1 !important;
}

.product-card[data-type="cheesecake"] .unavailable-overlay {
    display: none !important;
}
/* Ensure cheesecake products are always clickable */
.product-card[data-type="cheesecake"] {
    pointer-events: auto !important;
    cursor: pointer !important;
    opacity: 1 !important;
}

.product-card[data-type="cheesecake"].unavailable {
    opacity: 1 !important;
}

.product-card[data-type="cheesecake"] .unavailable-overlay {
    display: none !important;
}
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="nav-container">
      <div class="logo">
        <img src="menu_img/logo.jpg" alt="Logo" class="logo-img">
        <span>Tea & Cafe</span>
      </div>
      <ul class="nav-links">
        <li><a href="#" class="nav-link active" data-target="dashboard">Home</a></li>
        <li><a href="#" class="nav-link" data-target="menu">Menu</a></li>
        <li><a href="#" class="nav-link" data-target="orders">My Orders</a></li>
        <li><a href="#" class="nav-link" data-target="about">About Us</a></li>
        <li><a href="#" class="nav-link" data-target="logout">Log Out</a></li>
        <li class="cart-icon">
          <a href="#" class="nav-link" data-target="cart">
            🛒 <span id="cart-count">0</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Dashboard -->
    <div id="dashboard" class="content-section active-section">
      <h3>Welcome to 1128 Tea and Cafe!</h3>
      <b><p>Welcome to 1128 Tea and Cafe!
        We're delighted to have you here. Whether you're in the mood for a warm cup of tea, a refreshing iced coffee, or just a cozy place to relax, you've come to the right spot. 
      </p></b>
      <b><p>Take your time, enjoy the ambiance, and let our drinks bring comfort to your day. Thank you for choosing us — your perfect break starts here.</p></b>
      
      <!-- Advertisement Section - UPDATED WITH CENTERED LAYOUT -->
      <div class="advertisement-section">
        <h3 style="text-align: center; margin-bottom: 20px; color: #8B4513;">Special Offers</h3>
        <div class="advertisement-grid">
          <!-- Ad 1 -->
          <div class="ad-item">
            <img src="adver.jpg" alt="Buy 1 Take 1 Promotion" class="ad-image">
            <div class="ad-overlay">
              <div class="ad-title">Every Monday on all Milk Tea flavors!</div>
              <div class="ad-description"></div>
            </div>
          </div>
          
          <!-- Ad 2 -->
          <div class="ad-item">
            <img src="adver1.jpg" alt="New Frappe Collection" class="ad-image">
            <div class="ad-overlay">
              <div class="ad-title">Try our premium frappe flavors now!</div>
              <div class="ad-description"></div>
            </div>
          </div>
          
          <!-- Ad 3 -->
          <div class="ad-item">
            <img src="adver2.jpg" alt="Loyalty Program" class="ad-image">
            <div class="ad-overlay">
              <div class="ad-title">Earn points with every purchase!</div>
              <div class="ad-description"></div>
            </div>
          </div>
          
          <!-- Ad 4 -->
          <div class="ad-item">
            <img src="adver3.jpg" alt="Free Delivery" class="ad-image">
            <div class="ad-overlay">
              <div class="ad-title">Order now!</div>
              <div class="ad-description"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Menu -->
    <div id="menu" class="content-section">
      <h3>Menu</h3>
      <p>Click on the menu items to view our products.</p>
      <div class="products-container" id="products-container">
        <!-- Categories will be loaded here by JavaScript -->
      </div>
      <button id="backToMenu" class="back-btn hidden">← Back to Menu</button>
    </div>

    <!-- Shopping Cart -->
    <div id="cart" class="content-section">
      <h3>🛒 Shopping Cart</h3>
      <div class="cart-container">
        <div class="cart-items" id="cart-items">
          <p class="empty-cart-message">Your cart is empty</p>
        </div>
        <div class="cart-summary">
          <div class="cart-total">
            <h4>Order Summary</h4>
            <div class="total-line">
              <span>Subtotal:</span>
              <span id="subtotal">₱0.00</span>
            </div>
            <div class="total-line">
              <span> </span>
              <span id="tax"></span>
            </div>
            <div class="total-line grand-total">
              <span>Total:</span>
              <span id="grand-total">₱0.00</span>
            </div>
            <button id="checkout-btn" class="checkout-btn" disabled>Proceed to Checkout</button>
            <button id="continue-shopping" class="continue-shopping-btn">Continue Shopping</button>
          </div>
        </div>
      </div>
    </div>

<!-- Orders Section - UPDATED FORM -->
<div id="orders" class="content-section">
    <h3>My Orders</h3>
    <div id="order-success-message" class="success-message" style="display: none;"></div>
    
    <div class="checkout-container">
        <div class="customer-info">
            <h4>Customer Information</h4>
            <form id="customer-form">
                <div class="form-group">
                    <label for="customer-name">Nickname:</label>
                    <input type="text" id="customer-name" required maxlength="50" 
                           onkeypress="return validateNameInput(event)" oninput="validateNameRealTime()">
                    <div class="error-message" id="name-error">Name must contain only letters and spaces</div>
                </div>
                <div class="form-group">
                    <label for="customer-phone">Phone Number:</label>
                    <input type="tel" id="customer-phone" required maxlength="11" 
                           onkeypress="return validatePhoneInput(event)" oninput="validatePhoneRealTime()">
                    <div class="error-message" id="phone-error">Phone number must be exactly 11 digits</div>
                </div>
                <div class="form-group">
                  <label for="customer-email">Email Address:</label>
                  <input type="email" id="customer-email" required>
                  <div class="error-message" id="email-error">Please enter a valid email address</div>
                </div>
                <div class="form-group">
                    <label for="payment-method">Payment Method:</label>
                    <select id="payment-method" required>
                        <option value="">Select Payment</option>
                        <option value="cash">Cash</option>
                        <option value="gcash">GCash</option>
                    </select>
                </div>
            </form>
        </div>
        
        <div class="order-summary">
            <h4>Order Summary</h4>
            <div id="order-items">
                <!-- Order items will be displayed here -->
            </div>
            <div class="order-total">
                <div class="total-line">
                    <span>Subtotal:</span>
                    <span id="order-subtotal">₱0.00</span>
                </div>
                <div class="total-line">
                    <span>Tax (12%):</span>
                    <span id="order-tax">₱0.00</span>
                </div>
                <div class="total-line grand-total">
                    <span>Total:</span>
                    <span id="order-grand-total">₱0.00</span>
                </div>
            </div>
            <button id="place-order-btn" class="place-order-btn">Place Order</button>
        </div>
    </div>
</div>

    <!-- About -->
    <div id="about" class="content-section">
      <div class="about-content">
        <h3>About Us</h3>
        <div class="about-description">
          <p>Welcome to TEA & CAFE, where we serve the finest selection of teas and coffees in a cozy and welcoming atmosphere. Our passion for quality ingredients and exceptional service ensures every visit is a memorable experience.</p>
        </div>
        
        <div class="social-media-section">
          <h4>Connect With Us</h4>
          <div class="social-icons">
            <a href="https://web.facebook.com/profile.php?id=100095211663272#" class="social-icon facebook" target="_blank">
              <div class="icon-circle">f</div>
              <span>Facebook</span>
            </a>
          
            <a href="https://instagram.com/yourcompany" class="social-icon instagram" target="_blank">
              <div class="icon-circle">📷</div>
              <span>Instagram</span>
            </a>
            
            <a href="https://www.google.com/maps/place/1128+Tea+And+Cafe+Pampano+Malabon/@14.6531239,120.9598262,21z/data=!4m15!1m8!3m7!1s0x3397b5b48d92e62b:0x249d9842daf7f7!2sAlvilex+Barber+Shop!8m2!3d14.6531681!4d120.9601213!10e5!16s%2Fg%2F11jzw7v5xl!3m5!1s0x3397b542a006a771:0x66c8c795fde15893!8m2!3d14.6531663!4d120.9600477!16s%2Fg%2F11m9q29dw3?entry=ttu&g_ep=EgoyMDI5MTAwNi4wIKXMDSoASAFQAw%3D%3D" class="social-icon address" target="_blank">
              <div class="icon-circle">📍</div>
              <span>Address</span>
            </a>
          </div>
        </div>
        
      
      </div>
    </div>

    <!-- Logout -->
    <div id="logout" class="content-section">
      <div class="logout-confirmation">
        <h3>Log Out</h3>
        <p>Are you sure you want to log out?</p>
        <div class="logout-buttons">
          <button id="logout-yes" class="logout-btn logout-yes">Yes</button>
          <button id="logout-no" class="logout-btn logout-no">No</button>
        </div>
      </div>
    </div>
  </div>

 <!-- Product Modal -->
<div id="product-modal" class="modal">
  <div class="modal-content">
    <span class="close-modal">&times;</span>
    <div class="modal-body">
      <div class="modal-image">
        <img id="modal-product-image" src="" alt="">
      </div>
      <div class="modal-details">
        <h3 id="modal-product-name"></h3>
        <p class="modal-price" id="modal-product-price"></p>
        
        <!-- Size Selection -->
        <div class="size-selection">
          <label><strong>Size:</strong></label>
          <div class="size-options">
            <button class="size-btn" data-size="regular">Regular</button>
            <button class="size-btn" data-size="large">Large</button>
          </div>
        </div>

        <!-- Add-ons Selection -->
        <div class="addons-selection" id="addons-selection" style="display: ;">
          <label><strong>Add-ons (₱10 each):</strong></label>
          <div class="addons-options">
            <label class="addon-option">
              <input type="checkbox" name="addons" value="Pearl">
              <span>Pearl</span>
            </label>
            <label class="addon-option">
              <input type="checkbox" name="addons" value="Nata">
              <span>Nata</span>
            </label>
            <label class="addon-option">
              <input type="checkbox" name="addons" value="Cream Cheese">
              <span>Cream Cheese</span>
            </label>
            <label class="addon-option">
              <input type="checkbox" name="addons" value="Coffee Jelly">
              <span>Coffee Jelly</span>
            </label>
          </div>
        </div>

        <!-- Sweetness Level -->
        <div class="sweetness-selection">
          <label><strong>Sweetness Level:</strong></label>
          <select id="sweetness-level" class="sweetness-select">
            <option value="100% Sweet">100% Sweet</option>
            <option value="75% Sweet">75% Sweet</option>
            <option value="50% Sweet">50% Sweet</option>
            <option value="25% Sweet">25% Sweet</option>
            <option value="No Sugar">No Sugar</option>
          </select>
        </div>

        <!-- Quantity Selection -->
        <div class="quantity-selection">
          <label><strong>Quantity:</strong></label>
          <div class="quantity-controls">
            <button class="quantity-btn" id="decrease-qty">-</button>
            <span id="quantity-display">1</span>
            <button class="quantity-btn" id="increase-qty">+</button>
          </div>
        </div>

        <div class="modal-actions">
          <button id="add-to-cart-modal" class="add-to-cart-btn">Add to Cart</button>
        </div>
      </div>
    </div>
  </div>
</div>

  <!-- Loading Modal -->
  <div id="loading-modal" class="loading-modal">
    <div class="loading-content">
      <div class="loading-circle" id="loading-circle"></div>
      <div class="check-mark" id="check-mark"></div>
      <p class="loading-text" id="loading-text">Processing your order...</p>
    </div>
  </div>

  <!-- Payment Loading Modal -->
<div id="payment-loading-modal" class="loading-modal">
  <div class="loading-content">
    <div class="progress-circle" id="payment-loading-circle">
      <div class="progress-fill"></div>
    </div>
    <div class="success-checkmark" id="payment-check-mark"></div>
    <p class="loading-text" id="payment-loading-text">Processing Payment...</p>
  </div>
</div>

  <!-- In main.php - update the payment modal section -->
<div id="payment-modal" class="payment-modal">
    <div class="payment-modal-content">
        <div class="payment-modal-header">
            <h3>Complete Your Payment</h3>
            <button class="close-payment-modal">&times;</button>
        </div>
        <div class="payment-modal-body">
            <div id="payment-content">
                <!-- Cash Payment Option -->
                <div class="cash-payment">
                    <div class="cash-icon">💵</div>
                    <p class="cash-instructions">Please proceed to the cashier to complete your payment.</p>
                    
                    <div class="order-details-summary">
                        <h5>Order Summary</h5>
                        <div id="payment-order-items">
                            <!-- Order items will be dynamically inserted here -->
                        </div>
                        <div class="order-total">
                            <div class="order-item">
                                <span><strong>Total Amount:</strong></span>
                                <span><strong id="payment-total-amount">₱0.00</strong></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="payment-actions">
                        <button id="confirm-payment" class="payment-btn confirm-payment">Confirm Order</button>
                        <button id="cancel-payment" class="payment-btn cancel-payment">Cancel</button>
                    </div>
                </div>
            </div>
            
            <!-- Payment Success Message -->
            <div id="payment-success" class="payment-success" style="display: none;">
                <div class="success-icon">✓</div>
                <h4>Order Placed Successfully!</h4>
                <p>Your order has been received and is being processed.</p>
                <p><strong>Please proceed to cashier for payment.</strong></p>
                <button id="continue-shopping-btn" class="payment-btn confirm-payment">Continue Shopping</button>
            </div>
        </div>
    </div>
</div>

  <footer><p>&copy; Tea & Cafe. All rights reserved.</p></footer>
  
  <script src="main.js"></script>
  <script>
    // Input Validation Functions
    function validateNameInput(event) {
      const charCode = event.which ? event.which : event.keyCode;
      const char = String.fromCharCode(charCode);
      
      // Allow only letters, spaces, and backspace
      if (!/[a-zA-Z\s]/.test(char) && charCode !== 8) {
        event.preventDefault();
        return false;
      }
      return true;
    }

    function validatePhoneInput(event) {
      const charCode = event.which ? event.which : event.keyCode;
      const char = String.fromCharCode(charCode);
      const phoneInput = document.getElementById('customer-phone');
      
      // Allow only numbers and backspace
      if (!/[0-9]/.test(char) && charCode !== 8) {
        event.preventDefault();
        return false;
      }
      
      // Prevent input if already reached 11 digits (unless backspace)
      if (phoneInput.value.length >= 11 && charCode !== 8) {
        event.preventDefault();
        return false;
      }
      
      return true;
    }

    function validateNameRealTime() {
      const nameInput = document.getElementById('customer-name');
      // Remove any numbers or special characters that might have been pasted
      nameInput.value = nameInput.value.replace(/[^a-zA-Z\s]/g, '');
    }

    function validatePhoneRealTime() {
      const phoneInput = document.getElementById('customer-phone');
      // Remove any non-numeric characters that might have been pasted
      phoneInput.value = phoneInput.value.replace(/\D/g, '');
      
      // Limit to 11 digits
      if (phoneInput.value.length > 11) {
        phoneInput.value = phoneInput.value.slice(0, 11);
      }
    }

    // Payment Loading Functions
    function showPaymentLoading() {
        const paymentLoadingModal = document.getElementById('payment-loading-modal');
        const paymentLoadingCircle = document.getElementById('payment-loading-circle');
        const paymentCheckMark = document.getElementById('payment-check-mark');
        const paymentLoadingText = document.getElementById('payment-loading-text');
        
        paymentLoadingModal.style.display = 'flex';
        paymentLoadingCircle.style.display = 'block';
        paymentCheckMark.style.display = 'none';
        paymentLoadingText.textContent = 'Processing Payment...';
    }

    function showPaymentSuccess() {
        const paymentLoadingCircle = document.getElementById('payment-loading-circle');
        const paymentCheckMark = document.getElementById('payment-check-mark');
        const paymentLoadingText = document.getElementById('payment-loading-text');
        
        paymentLoadingCircle.style.display = 'none';
        paymentCheckMark.style.display = 'block';
        paymentLoadingText.textContent = 'Place ordered!';
    }

    function hidePaymentLoading() {
        const paymentLoadingModal = document.getElementById('payment-loading-modal');
        paymentLoadingModal.style.display = 'none';
    }

    // Function to reset cart count to 0
    function resetCartCount() {
        const cartCount = document.getElementById('cart-count');
        cartCount.textContent = '0';
        
        // Also clear the cart array if it exists in the global scope
        if (typeof cart !== 'undefined') {
            cart = [];
        }
        
        // Update cart display if the function exists
        if (typeof updateCartDisplay !== 'undefined') {
            updateCartDisplay();
        }
        
        // Update order summary if the function exists
        if (typeof updateOrderSummary !== 'undefined') {
            updateOrderSummary();
        }
    }

    // Function to show loading animation with progress circle
    function showPaymentLoadingWithProgress() {
        const paymentLoadingModal = document.getElementById('payment-loading-modal');
        const paymentLoadingCircle = document.getElementById('payment-loading-circle');
        const paymentCheckMark = document.getElementById('payment-check-mark');
        const paymentLoadingText = document.getElementById('payment-loading-text');
        
        // Update the loading circle to use progress animation
        paymentLoadingCircle.innerHTML = '<div class="progress-fill"></div>';
        paymentLoadingCircle.className = 'progress-circle';
        
        paymentLoadingModal.style.display = 'flex';
        paymentLoadingCircle.style.display = 'block';
        paymentCheckMark.style.display = 'none';
        paymentLoadingText.textContent = 'Processing Payment...';
        
        // Simulate progress animation (5 seconds)
        let progress = 3;
        const progressInterval = setInterval(() => {
            progress += 20;
            if (progress >= 100) {
                clearInterval(progressInterval);
                showPaymentSuccess();
                
                // After showing success, proceed with order processing
                setTimeout(() => {
                    processOrderAfterPayment();
                }, 1000);
            }
        }, 1000); // 5 seconds total for realistic feel
    }

    // Function to process order after payment animation - FIXED VERSION
    function processOrderAfterPayment() {
        // Get the latest order data
        const customerName = document.getElementById('customer-name').value;
        const customerPhone = document.getElementById('customer-phone').value;
        const customerEmail = document.getElementById('customer-email').value;
        const totalAmount = document.getElementById('payment-total-amount').textContent.replace('₱', '');
        
        // Prepare order data from cart
        const orderData = {
            customer_name: customerName,
            customer_phone: customerPhone,
            customer_email: customerEmail,
            payment_method: 'cash',
            total_amount: parseFloat(totalAmount),
            items: cart.map(item => ({
                name: item.name,
                size: item.size,
                quantity: item.quantity,
                price: item.price,
                sweetness: item.sweetness,
                addons: item.addons
            }))
        };
        
        console.log('Processing cash order:', orderData);
        
        // For cash payment, save order directly
        fetch('process_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(orderData)
        })
        .then(response => response.json())
        .then(result => {
            if(result.success) {
                hidePaymentLoading();
                
                // Show success message in payment modal
                const paymentContent = document.getElementById('payment-content');
                const paymentSuccess = document.getElementById('payment-success');
                
                paymentContent.style.display = 'none';
                paymentSuccess.style.display = 'block';
                
                // Display success message in orders section
                const orderSuccessMessage = document.getElementById('order-success-message');
                orderSuccessMessage.innerHTML = `
                    <h4>Order Placed Successfully!</h4>
                    <p>Your order has been placed successfully. Please proceed to cashier for payment.</p>
                    <p>Total: ₱${totalAmount}</p>
                    <p>Thank you, ${customerName}!</p>
                `;
                orderSuccessMessage.style.display = 'block';
                
                // RESET CART COUNT TO 0
                resetCartCount();
                
            } else {
                hidePaymentLoading();
                alert('Error processing order: ' + result.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            hidePaymentLoading();
            alert('Error processing order');
        });
    }

    // Function to update payment order summary - FIXED VERSION
    function updatePaymentOrderSummary() {
        const orderItemsContainer = document.getElementById('payment-order-items');
        
        // Clear previous items
        orderItemsContainer.innerHTML = '';
        
        // Get cart items directly
        if (typeof cart !== 'undefined' && cart.length > 0) {
            let totalAmount = 0;
            
            // Generate order items from cart
            cart.forEach(item => {
                const itemTotal = (item.price * item.quantity) + (item.addonsTotal * item.quantity);
                totalAmount += itemTotal;
                
                const addonsText = item.addons.length > 0 ? 
                    ` + ${item.addons.map(a => a.name).join(', ')}` : '';
                
                const orderItem = document.createElement('div');
                orderItem.className = 'order-item';
                orderItem.innerHTML = `
                    <span>${item.quantity}x ${item.name} (${item.size})${addonsText}</span>
                    <span>₱${itemTotal.toFixed(2)}</span>
                `;
                orderItemsContainer.appendChild(orderItem);
            });
            
            // Update total amount
            document.getElementById('payment-total-amount').textContent = `₱${totalAmount.toFixed(2)}`;
        } else {
            orderItemsContainer.innerHTML = '<p>No items in order</p>';
            document.getElementById('payment-total-amount').textContent = '₱0.00';
        }
        
        // Update confirm payment button state
        validateForm();
    }

    // Updated cash payment confirmation with loading animation and cart reset
    function handlePaymentSuccess() {
        // First, ensure we have the latest order data
        updatePaymentOrderSummary();
        
        const totalAmount = document.getElementById('payment-total-amount').textContent;
        if (totalAmount === '₱0.00') {
            alert('Cannot process order with zero amount. Please add items to your cart.');
            return;
        }
        
        showPaymentLoadingWithProgress();
    }

    // Add logout functionality
    document.addEventListener('DOMContentLoaded', function() {
      const logoutYesBtn = document.getElementById('logout-yes');
      const logoutNoBtn = document.getElementById('logout-no');
      
      if (logoutYesBtn) {
        logoutYesBtn.addEventListener('click', function() {
          // Redirect to login.php
          window.location.href = 'index.php';
        });
      }
      
      if (logoutNoBtn) {
        logoutNoBtn.addEventListener('click', function() {
          // Navigate back to dashboard
          const dashboardLink = document.querySelector('[data-target="dashboard"]');
          if (dashboardLink) {
            dashboardLink.click();
          }
        });
      }
      
      // Loading Modal Functionality
      const loadingModal = document.getElementById('loading-modal');
      const loadingCircle = document.getElementById('loading-circle');
      const checkMark = document.getElementById('check-mark');
      const loadingText = document.getElementById('loading-text');
      
      // Payment Modal Functionality
      const paymentModal = document.getElementById('payment-modal');
      const closePaymentModalBtn = document.querySelector('.close-payment-modal');
      const cancelPaymentBtn = document.getElementById('cancel-payment');
      const confirmPaymentBtn = document.getElementById('confirm-payment');
      const continueShoppingBtn = document.getElementById('continue-shopping-btn');
      const paymentContent = document.getElementById('payment-content');
      const paymentSuccess = document.getElementById('payment-success');
      const placeOrderBtn = document.getElementById('place-order-btn');
      const orderSuccessMessage = document.getElementById('order-success-message');
      
      // Customer form validation elements
      const customerNameInput = document.getElementById('customer-name');
      const customerPhoneInput = document.getElementById('customer-phone');
      const customerEmailInput = document.getElementById('customer-email');
      const nameError = document.getElementById('name-error');
      const phoneError = document.getElementById('phone-error');
      const emailError = document.getElementById('email-error');
      
      // Validation functions
      function validateName() {
        const name = customerNameInput.value.trim();
        const lettersOnly = /^[A-Za-z\s]+$/;
        
        if (name === '') {
          nameError.style.display = 'none';
          customerNameInput.parentElement.classList.remove('error', 'success');
          return false;
        }
        
        if (!lettersOnly.test(name)) {
          nameError.style.display = 'block';
          customerNameInput.parentElement.classList.add('error');
          customerNameInput.parentElement.classList.remove('success');
          return false;
        } else {
          nameError.style.display = 'none';
          customerNameInput.parentElement.classList.remove('error');
          customerNameInput.parentElement.classList.add('success');
          return true;
        }
      }
      
      function validatePhone() {
        const phone = customerPhoneInput.value.trim();
        const digitsOnly = /^\d+$/;
        
        if (phone === '') {
          phoneError.style.display = 'none';
          customerPhoneInput.parentElement.classList.remove('error', 'success');
          return false;
        }
        
        if (!digitsOnly.test(phone) || phone.length !== 11) {
          phoneError.style.display = 'block';
          customerPhoneInput.parentElement.classList.add('error');
          customerPhoneInput.parentElement.classList.remove('success');
          return false;
        } else {
          phoneError.style.display = 'none';
          customerPhoneInput.parentElement.classList.remove('error');
          customerPhoneInput.parentElement.classList.add('success');
          return true;
        }
      }

      function validateEmail() {
        const email = customerEmailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email === '') {
          emailError.style.display = 'none';
          customerEmailInput.parentElement.classList.remove('error', 'success');
          return false;
        }
        
        if (!emailRegex.test(email)) {
          emailError.style.display = 'block';
          customerEmailInput.parentElement.classList.add('error');
          customerEmailInput.parentElement.classList.remove('success');
          return false;
        } else {
          emailError.style.display = 'none';
          customerEmailInput.parentElement.classList.remove('error');
          customerEmailInput.parentElement.classList.add('success');
          return true;
        }
      }
      
      function validateForm() {
        const isNameValid = validateName();
        const isPhoneValid = validatePhone();
        const isEmailValid = validateEmail();
        const hasCartItems = document.querySelectorAll('#order-items .order-item').length > 0;
        
        // Enable/disable confirm payment button
        if (hasCartItems) {
          confirmPaymentBtn.disabled = false;
        } else {
          confirmPaymentBtn.disabled = true;
        }
        
        return isNameValid && isPhoneValid && isEmailValid && hasCartItems;
      }
      
      // Function to close payment modal
      function closePaymentModal() {
        paymentModal.style.display = 'none';
        // Reset to payment content view
        paymentContent.style.display = 'block';
        paymentSuccess.style.display = 'none';
      }
      
      // Add event listeners for validation
      customerNameInput.addEventListener('input', validateForm);
      customerPhoneInput.addEventListener('input', validateForm);
      customerEmailInput.addEventListener('input', validateForm);
      
      // Updated place order button event listener with loading animation and cart reset
      if (placeOrderBtn) {
        placeOrderBtn.addEventListener('click', function() {
          console.log('Place Order button clicked');
          
          // Basic validation
          if (!validateName()) {
            alert('Please enter a valid name (letters only)');
            return;
          }
          if (!validatePhone()) {
            alert('Please enter a valid 11-digit phone number');
            return;
          }
          if (!validateEmail()) {
            alert('Please enter a valid email address');
            return;
          }
          
          // Check if cart has items
          if (typeof cart === 'undefined' || cart.length === 0) {
            alert('Your cart is empty. Please add items to your cart before placing an order.');
            return;
          }

          const paymentMethod = document.getElementById('payment-method').value;
          if (!paymentMethod) {
            alert('Please select a payment method');
            return;
          }
          
          // Update order summary first to ensure data is current
          if (typeof updateOrderSummary !== 'undefined') {
            updateOrderSummary();
          }
          
          // Show loading animation
          showPaymentLoading();
          
          // Get customer information
          const customerName = document.getElementById('customer-name').value;
          const customerPhone = document.getElementById('customer-phone').value;
          const customerEmail = document.getElementById('customer-email').value;
          
          // Get cart items
          const cartItems = [];
          document.querySelectorAll('#order-items .order-item').forEach(item => {
            const itemText = item.querySelector('span:first-child').textContent;
            const itemPrice = parseFloat(item.querySelector('span:last-child').textContent.replace('₱', ''));
            
            // Parse item details from text
            const match = itemText.match(/(\d+)x\s+(.+?)\s+\((\w+)\)/);
            if (match) {
              cartItems.push({
                quantity: parseInt(match[1]),
                name: match[2].trim(),
                size: match[3],
                price: itemPrice
              });
            }
          });
          
          // Get totals
          const subtotal = parseFloat(document.getElementById('order-subtotal').textContent.replace('₱', ''));
          const tax = parseFloat(document.getElementById('order-tax').textContent.replace('₱', ''));
          const total = parseFloat(document.getElementById('order-grand-total').textContent.replace('₱', ''));
          
          // Prepare order data
          const orderData = {
            customer_name: customerName,
            customer_phone: customerPhone,
            customer_email: customerEmail,
            payment_method: paymentMethod,
            subtotal: subtotal,
            tax: tax,
            total_amount: total,
            items: cartItems
          };
          
          // Save order data to session via AJAX
          fetch('save_order_session.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(orderData)
          })
          .then(response => response.json())
          .then(result => {
            if (result.success) {
              // Show success animation before redirect
              showPaymentSuccess();
              
              setTimeout(() => {
                  hidePaymentLoading();
                  
                  // RESET CART COUNT TO 0 BEFORE REDIRECT
                  resetCartCount();
                  
                  // Redirect to payment page based on payment method
                  if (paymentMethod === 'gcash') {
                      window.location.href = `payment.php?total=${total}`;
                  } else if (paymentMethod === 'cash') {
                      // For cash payment, show payment modal
                      updatePaymentOrderSummary();
                      paymentModal.style.display = 'flex';
                  }
              }, 2000); // Increased to 2 seconds for better user experience
              
            } else {
              hidePaymentLoading();
              alert('Error saving order: ' + result.error);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            hidePaymentLoading();
            alert('Error saving order');
          });
        });
      }
      
      // Function to navigate to menu
      function goToMenu() {
        closePaymentModal();
        // Navigate to menu section
        const menuLink = document.querySelector('[data-target="menu"]');
        if (menuLink) {
          menuLink.click();
        }
      }
      
      // Event Listeners
      if (closePaymentModalBtn) {
        closePaymentModalBtn.addEventListener('click', closePaymentModal);
      }
      
      if (cancelPaymentBtn) {
        cancelPaymentBtn.addEventListener('click', closePaymentModal);
      }
      
      if (confirmPaymentBtn) {
        confirmPaymentBtn.addEventListener('click', handlePaymentSuccess);
      }
      
      if (continueShoppingBtn) {
        continueShoppingBtn.addEventListener('click', goToMenu);
      }
      
      // Close modal when clicking outside
      window.addEventListener('click', function(event) {
        if (event.target === paymentModal) {
          closePaymentModal();
        }
        if (event.target === loadingModal) {
          // Don't allow closing loading modal by clicking outside
          event.preventDefault();
        }
        if (event.target === document.getElementById('payment-loading-modal')) {
          // Don't allow closing payment loading modal by clicking outside
          event.preventDefault();
        }
      });
      
      // Initial validation
      validateForm();
    });

    // Additional utility functions
function forceCheesecakeAvailability() {
    const cheesecakeProducts = document.querySelectorAll('.product-card[data-type="cheesecake"]');
    cheesecakeProducts.forEach(product => {
        product.classList.remove('unavailable');
        const overlay = product.querySelector('.unavailable-overlay');
        if (overlay) {
            overlay.remove();
        }
        product.style.pointerEvents = 'auto';
        product.style.cursor = 'pointer';
        product.style.opacity = '1';
    });
}

// Call this after loading products
setTimeout(forceCheesecakeAvailability, 1000);

  </script>
</body>
</html>