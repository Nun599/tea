// main.js

document.addEventListener('DOMContentLoaded', function() {
  const navLinks = document.querySelectorAll('.nav-link');
  const sections = document.querySelectorAll('.content-section');
  const productsContainer = document.getElementById('products-container');
  const backToMenuBtn = document.getElementById('backToMenu');
  const cartCount = document.getElementById('cart-count');
  
  // Cart state
  let cart = [];
  let currentProduct = null;

  // Category data
  const categoryData = [
    { type: 'milktea', name: 'MILKTEA', price: '28 | 38', image: 'menu_img/milktea.png' },
    { type: 'cheesecake', name: 'Cheesecake', price: '43 | 53', image: 'menu_img/cheesecake.jpg' },
    { type: 'frappe', name: 'Frappe', price: '55 | 65', image: 'menu_img/frappe.jpg' },
    { type: 'premiumfrappe', name: 'Premium Frappe', price: '88', image: 'menu_img/premiumfrappe.jpg' },
    { type: 'icecoffee', name: 'Iced Coffee', price: '50 | 60', image: 'menu_img/icecoffee.jpg' },
    { type: 'hotdrinks', name: 'Hot Drinks', price: '45', image: 'menu_img/hot.jpg' },
    { type: 'milkseries', name: 'Milk Series', price: '55 | 65', image: 'menu_img/milkseries.jpg' },
    { type: 'fruittea', name: 'Fruit Tea', price: '28 | 38', image: 'menu_img/fruittea.jpg' },
    { type: 'soda', name: 'Soda Refresher', price: '28 | 38', image: 'menu_img/soda.jpg' }
  ];

  // Product data
  const productData = {
    milktea: [
      { name: 'Okinawa', price: { regular: 28, large: 38 }, image: 'img_milktea/okinawa.png' },
      { name: 'Winter Melon', price: { regular: 28, large: 38 }, image: 'img_milktea/wintermelon.png' },
      { name: 'Redvelvet', price: { regular: 28, large: 38 }, image: 'img_milktea/redvelvet.png' },
      { name: 'Taro', price: { regular: 28, large: 38 }, image: 'img_milktea/taro.png' },
      { name: 'Salted Caramel', price: { regular: 28, large: 38 }, image: 'img_milktea/saltedcaramel.png' },
      { name: 'Matcha', price: { regular: 28, large: 38 }, image: 'img_milktea/matcha.png' },
      { name: 'Choco Strawberry', price: { regular: 28, large: 38 }, image: 'img_milktea/chocostrawberry.png' },
      { name: 'Cookies & Cream', price: { regular: 28, large: 38 }, image: 'img_milktea/cookies&cream.png' }
    ],
    cheesecake: [
      { name: 'Dark Choco', price: { regular: 43, large: 53 }, image: 'img_cheesecake/dark_choco.jpeg' },
      { name: 'Red Velvet', price: { regular: 43, large: 53 }, image: 'img_cheesecake/red_velvet.jpeg' },
      { name: 'Cookies & Cream', price: { regular: 43, large: 53 }, image: 'img_cheesecake/cookies_and_cream.jpeg' },
      { name: 'Salted Caramel', price: { regular: 43, large: 53 }, image: 'img_cheesecake/salted_caramel.jpeg' },
      { name: 'Wintermelon', price: { regular: 43, large: 53 }, image: 'img_cheesecake/wintemelon.jpeg' },
      { name: 'Double Oreo', price: { regular: 43, large: 53 }, image: 'img_cheesecake/double_oreo.jpeg' },
      { name: 'Matcha', price: { regular: 43, large: 53 }, image: 'img_cheesecake/matcha.jpeg' }
    ],
    frappe: [
      { name: 'Java Chip', price: { regular: 55, large: 65 }, image: 'img_frappe/javachip.png' },
      { name: 'Dark Mocha', price: { regular: 55, large: 65 }, image: 'img_frappe/darkmocha.png' },
      { name: 'Mix Berries', price: { regular: 55, large: 65 }, image: 'img_frappe/mixberries.png' },
      { name: 'Triple Chocolate', price: { regular: 55, large: 65 }, image: 'img_frappe/triplechocolate.png' },
      { name: 'Dark Chocoberry', price: { regular: 55, large: 65 }, image: 'img_frappe/darkchocoberry.png' },
      { name: 'Strawberry & Cream', price: { regular: 55, large: 65 }, image: 'img_frappe/strawberry&cream.png' },
      { name: 'Dark Caramel', price: { regular: 55, large: 65 }, image: 'img_frappe/darkcaramel.png' },
      { name: 'Blue Berries & Cream', price: { regular: 55, large: 65 }, image: 'img_frappe/blueberries&cream.png' }
    ],
    premiumfrappe: [
      { name: 'Almond Matcha', price: { regular: 88 }, image: 'img_premiumfrappe/almondmatcha.png' },
      { name: 'Dark Choco Creamcheese', price: { regular: 88 }, image: 'img_premiumfrappe/darkchococreamcheese.png' },
      { name: 'Dark Choco Lava', price: { regular: 88 }, image: 'img_premiumfrappe/darkchocolava.png' },
      { name: 'Dark Forest', price: { regular: 88 }, image: 'img_premiumfrappe/darkforest.png' },
      { name: 'Kopi Caramel', price: { regular: 88 }, image: 'img_premiumfrappe/kopicaramel.png' },
      { name: 'Lava Cheesecake', price: { regular: 88 }, image: 'img_premiumfrappe/lavacheesecake.png' },
      { name: 'Mango Cheesecake', price: { regular: 88 }, image: 'img_premiumfrappe/mangocheesecake.png' },
      { name: 'Oreo Cheesecake', price: { regular: 88 }, image: 'img_premiumfrappe/oreocheesecake.png' },
      { name: 'Red Velvet Creamcheese', price: { regular: 88 }, image: 'img_premiumfrappe/redvelveltcreamcheese.png' },
      { name: 'Strawberry Cheesecake', price: { regular: 88 }, image: 'img_premiumfrappe/strawberrycheesecake.png' },
      { name: 'Ube Creamcheese', price: { regular: 88 }, image: 'img_premiumfrappe/ubecreamcheese.png' },
      { name: 'White Choco Mocha', price: { regular: 88 }, image: 'img_premiumfrappe/whitechocomocha.png' }
    ],
    icecoffee: [
      { name: 'Americano', price: { regular: 50, large: 60 }, image: 'img_icecoffee/americano.png' },
      { name: 'Caramel Machiatto', price: { regular: 50, large: 60 }, image: 'img_icecoffee/caramelmachiatto.png' },
      { name: 'Dirty Matcha', price: { regular: 50, large: 60 }, image: 'img_icecoffee/dirtymatcha.png' },
      { name: 'French Vanilla', price: { regular: 50, large: 60 }, image: 'img_icecoffee/frenchvanilla.png' },
      { name: 'Mocha Latte', price: { regular: 50, large: 60 }, image: 'img_icecoffee/mochalatte.png' },
      { name: 'Salted Caramel Latte', price: { regular: 50, large: 60 }, image: 'img_icecoffee/saltedcaramellatte.png' },
      { name: 'Spanish Latte', price: { regular: 50, large: 60 }, image: 'img_icecoffee/spanishlatte.png' },
      { name: 'White Chocolate', price: { regular: 50, large: 60 }, image: 'img_icecoffee/whitechocolate.png' },
      { name: 'White Mocha', price: { regular: 50, large: 60 }, image: 'img_icecoffee/whitemocha.png' }
    ],
    hotdrinks: [
      { name: 'Caramel Machiatto', price: { regular: 45 }, image: 'img_HotDrinks/hotdrinks.png' },
      { name: 'Salted Caramel Latte', price: { regular: 45 }, image: 'img_HotDrinks/hotdrinks.png' },
      { name: 'Spanish Latte', price: { regular: 45 }, image: 'img_HotDrinks/hotdrinks.png' },
      { name: 'White Chocolate', price: { regular: 45 }, image: 'img_HotDrinks/hotdrinks.png' },
      { name: 'Mocha Latte', price: { regular: 45 }, image: 'img_HotDrinks/hotdrinks.png' },
      { name: 'French Vanilla', price: { regular: 45 }, image: 'img_HotDrinks/hotdrinks.png' },
      { name: 'White Mocha', price: { regular: 45 }, image: 'img_HotDrinks/hotdrinks.png' },
      { name: 'Hot Chocolate', price: { regular: 45 }, image: 'img_HotDrinks/hotdrinks.png' },
      { name: 'Hot Americano', price: { regular: 45 }, image: 'img_HotDrinks/hotdrinks.png' }
    ],
    milkseries: [
      { name: 'Blueberries & Milk', price: { regular: 55, large: 65 }, image: 'img_milkseries/blueberries&milk.png' },
      { name: 'Chocolate Latte', price: { regular: 55, large: 65 }, image: 'img_milkseries/chocolatelatte.png' },
      { name: 'Mango & Milk', price: { regular: 55, large: 65 }, image: 'img_milkseries/mango&milk.png' },
      { name: 'Strawberry & Milk', price: { regular: 55, large: 65 }, image: 'img_milkseries/strawberry&milk.png' },
      { name: 'Ube Latte', price: { regular: 55, large: 65 }, image: 'img_milkseries/ubelatte.png' },
      { name: 'Ube Matcha Latte', price: { regular: 55, large: 65 }, image: 'img_milkseries/ubematchalatte.png' }
    ],
    fruittea: [
      { name: 'Blueberry', price: { regular: 28, large: 38 }, image: 'img_fruittea/blueberry.jpg' },
      { name: 'Green Apple Tea', price: { regular: 28, large: 38 }, image: 'img_fruittea/greenapple.jpg' },
      { name: 'Lemon', price: { regular: 28, large: 38 }, image: 'img_fruittea/lemon.jpg' },
      { name: 'Strawberry', price: { regular: 28, large: 38 }, image: 'img_fruittea/strawberry.jpg' }
    ],
    soda: [
      { name: 'Blue Apple', price: { regular: 28, large: 38 }, image: 'img_sodarefresher/blueapple.png' },
      { name: 'Blue Lemonade', price: { regular: 28, large: 38 }, image: 'img_sodarefresher/bluelemonade.png' },
      { name: 'Mint Strawberry', price: { regular: 28, large: 38 }, image: 'img_sodarefresher/mintstrrawberry.png' },
      { name: 'Pink Mango', price: { regular: 28, large: 38 }, image: 'img_sodarefresher/pinkmango.png' }
    ]
  };

  // ENHANCED: Override cheesecake availability - make sure it always works
  function overrideCheesecakeAvailability() {
    const cheesecakeProducts = document.querySelectorAll('.product-card[data-type="cheesecake"]');
    
    cheesecakeProducts.forEach(product => {
        // Remove unavailable class and overlay for cheesecake products
        product.classList.remove('unavailable');
        const overlay = product.querySelector('.unavailable-overlay');
        if (overlay) {
            overlay.remove();
        }
        
        // Make sure cheesecake products are clickable
        product.style.pointerEvents = 'auto';
        product.style.cursor = 'pointer';
        product.style.opacity = '1';
        
        // Add click event directly to ensure it works
        product.addEventListener('click', function(e) {
            const productName = this.querySelector('.product-name').textContent;
            openProductModal('cheesecake', productName);
        });
    });
    
    console.log('Cheesecake availability override applied to', cheesecakeProducts.length, 'products');
  }

  // UPDATED: Check product availability with proper error handling and debugging
  function checkProductAvailability(productName, quantity, category = '') {
    console.log('Checking stock for:', productName, 'Quantity:', quantity, 'Category:', category);
    
    // FORCE CHEESECAKE PRODUCTS TO BE ALWAYS AVAILABLE
    if (category === 'cheesecake') {
        console.log('Cheesecake product - automatically available');
        return Promise.resolve(true);
    }
    
    return fetch('check_stock.php?product=' + encodeURIComponent(productName) + '&quantity=' + quantity + '&category=' + encodeURIComponent(category))
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Stock check response for', productName, ':', data);
            
            if (data.error) {
                console.error('Stock check error:', data.error);
                // If there's an error, assume product is available to prevent blocking orders
                return true;
            }
            
            // Check if available property exists and is true
            const isAvailable = data.available === true;
            console.log('Product availability result:', isAvailable, 'Stock:', data.stock_quantity);
            return isAvailable;
        })
        .catch(error => {
            console.error('Error checking stock:', error);
            // If stock check fails, allow the order to proceed
            return true;
        });
  }

  // Initialize the app
  function init() {
    document.getElementById('dashboard').classList.add('active-section');
    productsContainer.innerHTML = generateMenuHTML();
    updateCartCount();
    setupEventListeners();
  }

  // Setup event listeners
  function setupEventListeners() {
    // Navigation
    navLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        handleNavigation(this);
      });
    });

    // Products container events
    productsContainer.addEventListener('click', function(e) {
      const unavailableProduct = e.target.closest('.product-card.unavailable:not([data-type="cheesecake"])');
      if (unavailableProduct) {
        e.preventDefault();
        e.stopImmediatePropagation();
        e.stopPropagation();
        alert('❌ This product is currently unavailable. Please choose another product.');
        return false;
      }
      
      const categoryCard = e.target.closest('.category-card');
      const productCard = e.target.closest('.product-card');
      
      if (categoryCard) {
        const categoryType = categoryCard.getAttribute('data-type');
        displayProducts(categoryType);
        backToMenuBtn.classList.remove('hidden');
        return;
      } 
      
      if (productCard) {
        const productType = productCard.getAttribute('data-type');
        const productName = productCard.querySelector('.product-name').textContent;
        openProductModal(productType, productName);
      }
    });

    // Back to menu
    backToMenuBtn.addEventListener('click', () => {
      productsContainer.innerHTML = generateMenuHTML();
      productsContainer.style.display = 'grid';
      backToMenuBtn.classList.add('hidden');
    });

    // Modal events
    setupModalEvents();
    
    // Cart and checkout events
    setupCartEvents();

    // Place order button event listener
    document.getElementById('place-order-btn').addEventListener('click', function() {
        if (validateOrderForm()) {
            const paymentMethod = document.getElementById('payment-method').value;
            
            if (paymentMethod === 'gcash') {
                processGCashPayment();
            } else if (paymentMethod === 'cash') {
                processCashPayment();
            } else {
                alert('Please select a payment method');
            }
        } else {
            alert('Please fill all required fields correctly');
        }
    });
  }

  // Navigation handler
  function handleNavigation(link) {
    navLinks.forEach(nav => nav.classList.remove('active'));
    sections.forEach(section => section.classList.remove('active-section'));

    link.classList.add('active');
    const target = link.getAttribute('data-target');
    document.getElementById(target).classList.add('active-section');

    if (target === 'menu') {
      productsContainer.style.display = 'grid';
      productsContainer.innerHTML = generateMenuHTML();
      backToMenuBtn.classList.add('hidden');
    } else if (target === 'cart') {
      updateCartDisplay();
    } else if (target === 'orders') {
      updateOrderSummary();
    }
  }

  // Generate menu HTML
  function generateMenuHTML() {
    return categoryData.map(category => `
      <div class="category-card" data-type="${category.type}">
        <div class="category-image"><img src="${category.image}" alt="${category.name}"></div>
        <div class="category-name">${category.name}</div>
        <div class="product-price">${category.price}</div>
      </div>
    `).join('');
  }

  // UPDATED: Display products with better error handling
  function displayProducts(category) {
    console.log('Loading products for category:', category);
    
    fetch('get_products.php?category=' + category + '&t=' + new Date().getTime())
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(products => {
            console.log('Received products from server:', products);
            
            if (products.length === 0) {
                console.log('No products from server, using client data');
                useClientData(category);
                return;
            }

            const productsHTML = products.map(product => {
                const priceText = product.price_large ? 
                    `₱${product.price_regular} | ₱${product.price_large}` : 
                    `₱${product.price_regular}`;
                
                // FIXED: Better stock and availability checking with fallbacks
                const stockQty = parseInt(product.stock_quantity) || 0;
                const isAvailable = (product.is_available == 1 || product.is_available == '1') && stockQty > 0;
                
                console.log(`Product: ${product.name}, Stock: ${stockQty}, Available: ${isAvailable}`);
                
                // Always make cheesecake products available
                const finalAvailability = category === 'cheesecake' ? true : isAvailable;
                
                return `
                    <div class="product-card ${!finalAvailability ? 'unavailable' : ''}" 
                         data-type="${category}" 
                         data-available="${finalAvailability}">
                        <div class="product-image">
                            <img src="${product.image_path}" alt="${product.name}" 
                                 onerror="this.src='placeholder.jpg'">
                            ${!finalAvailability ? '<div class="unavailable-overlay">OUT OF STOCK<br>NOT AVAILABLE</div>' : ''}
                        </div>
                        <div class="product-name">${product.name}</div>
                        <div class="product-price">${priceText}</div>
                    </div>
                `;
            }).join('');

            productsContainer.innerHTML = productsHTML;
            
            // OVERRIDE CHEESECAKE AVAILABILITY
            if (category === 'cheesecake') {
                overrideCheesecakeAvailability();
            }
            
            addUnavailableProductHandlers();
        })
        .catch(error => {
            console.error('Error fetching products:', error);
            useClientData(category);
        });
  }

  // UPDATED: Strict click prevention for unavailable products (exclude cheesecake)
  function addUnavailableProductHandlers() {
    const unavailableProducts = document.querySelectorAll('.product-card.unavailable:not([data-type="cheesecake"])');
    
    unavailableProducts.forEach(product => {
        product.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            alert('❌ This product is currently unavailable. Please choose another product.');
            return false;
        });
        
        // Additional styling to make it clear it's unavailable
        product.style.cursor = 'not-allowed';
        product.style.opacity = '0.6';
    });
  }

  // UPDATED: Fallback function
  function useClientData(category) {
    const products = productData[category];
    if (!products) return;

    const productsHTML = products.map(product => {
        const priceText = product.price.large ? 
            `₱${product.price.regular} | ₱${product.price.large}` : 
            `₱${product.price.regular}`;
        
        // FORCE CHEESECAKE PRODUCTS TO BE AVAILABLE IN CLIENT DATA TOO
        const isAvailable = category === 'cheesecake' ? true : true;
        
        return `
            <div class="product-card ${!isAvailable ? 'unavailable' : ''}" data-type="${category}">
                <div class="product-image">
                    <img src="${product.image}" alt="${product.name}">
                    ${!isAvailable ? '<div class="unavailable-overlay">OUT OF STOCK<br>NOT AVAILABLE</div>' : ''}
                </div>
                <div class="product-name">${product.name}</div>
                <div class="product-price">${priceText}</div>
            </div>
        `;
    }).join('');

    productsContainer.innerHTML = productsHTML;
    
    // OVERRIDE CHEESECAKE AVAILABILITY FOR CLIENT DATA
    if (category === 'cheesecake') {
        overrideCheesecakeAvailability();
    }
  }

  // Modal functionality
  function setupModalEvents() {
    const modal = document.getElementById('product-modal');
    const closeModal = document.querySelector('.close-modal');
    const sizeButtons = document.querySelectorAll('.size-btn');
    const decreaseQty = document.getElementById('decrease-qty');
    const increaseQty = document.getElementById('increase-qty');
    const addToCartModal = document.getElementById('add-to-cart-modal');

    closeModal.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    sizeButtons.forEach(button => {
      button.addEventListener('click', () => {
        sizeButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
      });
    });

    let quantity = 1;
    const quantityDisplay = document.getElementById('quantity-display');

    decreaseQty.addEventListener('click', () => {
      if (quantity > 1) {
        quantity--;
        quantityDisplay.textContent = quantity;
      }
    });

    increaseQty.addEventListener('click', () => {
      quantity++;
      quantityDisplay.textContent = quantity;
    });

    // UPDATED: Add to cart with improved stock validation and fallback
    addToCartModal.addEventListener('click', () => {
      const selectedSize = document.querySelector('.size-btn.active')?.dataset.size || 'regular';
      const sweetness = document.getElementById('sweetness-level').value;
      
      const selectedAddons = [];
      document.querySelectorAll('input[name="addons"]:checked').forEach(checkbox => {
        selectedAddons.push({
          name: checkbox.value,
          price: 10
        });
      });

      console.log('Adding to cart:', currentProduct.name, 'Quantity:', quantity, 'Category:', currentProduct.category);
      
      // For cheesecake category, skip stock check entirely
      if (currentProduct.category === 'cheesecake') {
        console.log('Cheesecake product - skipping stock check');
        addToCart(currentProduct, selectedSize, quantity, selectedAddons, sweetness);
        modal.style.display = 'none';
        quantity = 1;
        quantityDisplay.textContent = quantity;
        return;
      }
      
      checkProductAvailability(currentProduct.name, quantity, currentProduct.category).then(isAvailable => {
        console.log('Stock check final result:', isAvailable);
        
        if (!isAvailable) {
          alert('❌ Sorry, this product is out of stock or has insufficient quantity.');
          return;
        }

        addToCart(currentProduct, selectedSize, quantity, selectedAddons, sweetness);
        modal.style.display = 'none';
        quantity = 1;
        quantityDisplay.textContent = quantity;
      });
    });

    window.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });
  }

  // Open product modal
  function openProductModal(category, productName) {
    const product = productData[category].find(p => p.name === productName);
    if (!product) return;

    currentProduct = { ...product, category };
    
    const modal = document.getElementById('product-modal');
    const modalImage = document.getElementById('modal-product-image');
    const modalName = document.getElementById('modal-product-name');
    const modalPrice = document.getElementById('modal-product-price');
    const addonsSelection = document.getElementById('addons-selection');

    modalImage.src = product.image;
    modalImage.alt = product.name;
    modalName.textContent = product.name;
    
    if (product.price.large) {
      modalPrice.textContent = `Regular: ₱${product.price.regular} | Large: ₱${product.price.large}`;
    } else {
      modalPrice.textContent = `Price: ₱${product.price.regular}`;
    }

    const showAddons = ['milktea', 'cheesecake', 'milkseries'].includes(category);
    addonsSelection.style.display = showAddons ? 'block' : 'none';

    const sizeButtons = document.querySelectorAll('.size-btn');
    if (product.price.large) {
      sizeButtons.forEach(btn => {
        btn.style.display = 'inline-block';
        btn.classList.remove('active');
      });
      sizeButtons[0].classList.add('active');
    } else {
      sizeButtons.forEach(btn => {
        btn.style.display = 'none';
      });
    }

    document.querySelectorAll('input[name="addons"]').forEach(checkbox => {
      checkbox.checked = false;
    });
    document.getElementById('sweetness-level').value = '100% Sweet';
    document.getElementById('quantity-display').textContent = '1';

    modal.style.display = 'block';
  }

  // Cart functionality
  function setupCartEvents() {
    const checkoutBtn = document.getElementById('checkout-btn');
    const continueShoppingBtn = document.getElementById('continue-shopping');

    checkoutBtn.addEventListener('click', () => {
      handleNavigation(document.querySelector('[data-target="orders"]'));
    });

    continueShoppingBtn.addEventListener('click', () => {
      handleNavigation(document.querySelector('[data-target="menu"]'));
    });
  }

  // Add item to cart
  function addToCart(product, size, quantity, addons = [], sweetness = '100% Sweet') {
    const price = product.price[size] || product.price.regular;
    
    let addonsTotal = 0;
    addons.forEach(addon => {
      addonsTotal += addon.price;
    });

    const totalPrice = price + addonsTotal;
    
    const cartItem = {
      name: product.name,
      size: size,
      price: price,
      quantity: quantity,
      image: product.image,
      category: product.category,
      addons: addons,
      sweetness: sweetness,
      addonsTotal: addonsTotal,
      totalPrice: totalPrice * quantity
    };

    cart.push(cartItem);
    updateCartCount();
    showNotification(`${product.name} added to cart!`);
  }

  // Update cart count
  function updateCartCount() {
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = totalItems;
  }

  // Update cart display
  function updateCartDisplay() {
    const cartItems = document.getElementById('cart-items');
    const subtotalElement = document.getElementById('subtotal');
    const grandTotalElement = document.getElementById('grand-total');
    const checkoutBtn = document.getElementById('checkout-btn');

    if (cart.length === 0) {
      cartItems.innerHTML = '<p class="empty-cart-message">Your cart is empty</p>';
      subtotalElement.textContent = '₱0.00';
      grandTotalElement.textContent = '₱0.00';
      checkoutBtn.disabled = true;
      return;
    }

    let subtotal = 0;
    const cartHTML = cart.map((item, index) => {
      const itemSubtotal = item.price * item.quantity;
      const itemAddonsTotal = item.addonsTotal * item.quantity;
      const itemTotal = itemSubtotal + itemAddonsTotal;
      subtotal += itemTotal;

      const addonsHTML = item.addons.length > 0 ? 
        `<div class="cart-item-addons">
           <small>Add-ons: ${item.addons.map(a => a.name).join(', ')}</small><br>
           <small>Sweetness: ${item.sweetness}</small>
         </div>` : 
        `<div class="cart-item-addons">
           <small>Sweetness: ${item.sweetness}</small>
         </div>`;

      return `
        <div class="cart-item">
          <div class="cart-item-info">
            <img src="${item.image}" alt="${item.name}" class="cart-item-image">
            <div class="cart-item-details">
              <h4>${item.name}</h4>
              <p>Size: ${item.size.charAt(0).toUpperCase() + item.size.slice(1)}</p>
              <p>₱${item.price} each</p>
              ${addonsHTML}
            </div>
          </div>
          <div class="cart-item-controls">
            <div class="quantity-controls">
              <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
              <span>${item.quantity}</span>
              <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
            </div>
            <div class="item-total">₱${itemTotal.toFixed(2)}</div>
            <button class="remove-item" onclick="removeFromCart(${index})">Remove</button>
          </div>
        </div>
      `;
    }).join('');

    const grandTotal = subtotal;

    cartItems.innerHTML = cartHTML;
    subtotalElement.textContent = `₱${subtotal.toFixed(2)}`;
    grandTotalElement.textContent = `₱${grandTotal.toFixed(2)}`;
    checkoutBtn.disabled = false;
  }

  // Update quantity
  window.updateQuantity = function(index, change) {
    cart[index].quantity += change;
    
    if (cart[index].quantity <= 0) {
      cart.splice(index, 1);
    }
    
    updateCartCount();
    updateCartDisplay();
  };

  // Remove from cart
  window.removeFromCart = function(index) {
    cart.splice(index, 1);
    updateCartCount();
    updateCartDisplay();
  };

  // Update order summary
  function updateOrderSummary() {
    const orderItems = document.getElementById('order-items');
    const orderSubtotal = document.getElementById('order-subtotal');
    const orderGrandTotal = document.getElementById('order-grand-total');

    if (cart.length === 0) {
      orderItems.innerHTML = '<p>No items in cart</p>';
      orderSubtotal.textContent = '₱0.00';
      orderGrandTotal.textContent = '₱0.00';
      return;
    }

    let subtotal = 0;
    const orderHTML = cart.map(item => {
      const itemSubtotal = item.price * item.quantity;
      const itemAddonsTotal = item.addonsTotal * item.quantity;
      const itemTotal = itemSubtotal + itemAddonsTotal;
      subtotal += itemTotal;

      const addonsText = item.addons.length > 0 ? 
        ` + ${item.addons.map(a => a.name).join(', ')}` : '';

      return `
        <div class="order-item">
          <div class="order-item-details">
            <span>${item.quantity}x ${item.name} (${item.size})${addonsText}<br>
            <small>Sweetness: ${item.sweetness}</small></span>
            <span>₱${itemTotal.toFixed(2)}</span>
          </div>
        </div>
      `;
    }).join('');

    const grandTotal = subtotal;

    orderItems.innerHTML = orderHTML;
    orderSubtotal.textContent = `₱${subtotal.toFixed(2)}`;
    orderGrandTotal.textContent = `₱${grandTotal.toFixed(2)}`;
  }

  // Show notification
  function showNotification(message) {
    const notification = document.createElement('div');
    notification.style.cssText = `
      position: fixed;
      top: 100px;
      right: 20px;
      background: #28a745;
      color: white;
      padding: 15px 20px;
      border-radius: 4px;
      z-index: 1002;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    `;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
      notification.remove();
    }, 3000);
  }

  // NEW: Validate order form
  function validateOrderForm() {
    const customerName = document.getElementById('customer-name').value.trim();
    const customerPhone = document.getElementById('customer-phone').value.trim();
    const customerEmail = document.getElementById('customer-email').value.trim();
    const paymentMethod = document.getElementById('payment-method').value;

    if (!customerName) {
      alert('Please enter your name');
      return false;
    }

    if (!customerPhone) {
      alert('Please enter your phone number');
      return false;
    }

    if (!customerEmail) {
      alert('Please enter your email');
      return false;
    }

    // Basic email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(customerEmail)) {
      alert('Please enter a valid email address');
      return false;
    }

    if (!paymentMethod) {
      alert('Please select a payment method');
      return false;
    }

    if (cart.length === 0) {
      alert('Your cart is empty');
      return false;
    }

    return true;
  }

  // UPDATED: Process GCash payment
function processGCashPayment() {
    const customerName = document.getElementById('customer-name').value;
    const customerPhone = document.getElementById('customer-phone').value;
    const customerEmail = document.getElementById('customer-email').value;
    const paymentMethod = document.getElementById('payment-method').value;
    const totalAmount = parseFloat(document.getElementById('order-grand-total').textContent.replace('₱', ''));
    
    if (!customerName || !customerPhone || !customerEmail || !paymentMethod || !cart || cart.length === 0) {
        alert('Please complete all fields and add items to cart');
        return;
    }

    const orderData = {
        customer_name: customerName,
        customer_phone: customerPhone,
        customer_email: customerEmail,
        payment_method: paymentMethod,
        total_amount: totalAmount,
        items: cart.map(item => ({
            name: item.name,
            size: item.size,
            quantity: item.quantity,
            price: item.price,
            sweetness: item.sweetness,
            addons: item.addons.map(addon => addon.name)
        }))
    };

    console.log('Processing GCash payment with order:', orderData);

    // Show loading animation for GCash
    showPaymentLoadingWithProgress();

    // First, create the order
    fetch('process_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(orderData)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            // After order is created, redirect to GCash payment
            setTimeout(() => {
                window.location.href = `payment.php?total=${totalAmount}&order_id=${result.order_id}`;
            }, 2000);
        } else {
            hidePaymentLoading();
            alert('Error creating order: ' + result.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        hidePaymentLoading();
        alert('Network error: ' + error.message);
    });
}

  // NEW: Process Cash Payment
  function processCashPayment() {
    const customerName = document.getElementById('customer-name').value;
    const customerPhone = document.getElementById('customer-phone').value;
    const customerEmail = document.getElementById('customer-email').value;
    const paymentMethod = document.getElementById('payment-method').value;
    const totalAmount = parseFloat(document.getElementById('order-grand-total').textContent.replace('₱', ''));
    
    if (!customerName || !customerPhone || !customerEmail || !paymentMethod || !cart || cart.length === 0) {
        alert('Please complete all fields and add items to cart');
        return;
    }

    const orderData = {
        customer_name: customerName,
        customer_phone: customerPhone,
        customer_email: customerEmail,
        payment_method: paymentMethod,
        total_amount: totalAmount,
        items: cart.map(item => ({
            name: item.name,
            size: item.size,
            quantity: item.quantity,
            price: item.price,
            sweetness: item.sweetness,
            addons: item.addons.map(addon => addon.name)
        }))
    };

    console.log('Processing cash payment with order:', orderData);

    // Show loading animation
    showPaymentLoadingWithProgress();

    // Send order to server
    fetch('process_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(orderData)
    })
    .then(response => response.json())
    .then(result => {
        console.log('Server response:', result);
        if (result.success) {
            // Show success
            showPaymentSuccess();
            
            // Reset cart and show success message
            setTimeout(() => {
                hidePaymentLoading();
                showOrderSuccess(result.order_id, customerName, totalAmount);
                resetCart();
            }, 1500);
            
        } else {
            hidePaymentLoading();
            alert('Error: ' + result.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        hidePaymentLoading();
        alert('Network error: ' + error.message);
    });
  }

  // NEW: Show order success message
  function showOrderSuccess(orderId, customerName, totalAmount) {
    const orderSuccessMessage = document.getElementById('order-success-message');
    if (orderSuccessMessage) {
        orderSuccessMessage.innerHTML = `
            <h4>✅ Order Placed Successfully!</h4>
            <p><strong>Order ID:</strong> #${orderId}</p>
            <p><strong>Total Amount:</strong> ₱${totalAmount.toFixed(2)}</p>
            <p><strong>Payment Method:</strong> Cash (Pay at counter)</p>
            <p>Thank you, ${customerName}! Your order has been received.</p>
        `;
        orderSuccessMessage.style.display = 'block';
    }
    
    // Scroll to success message
    orderSuccessMessage.scrollIntoView({ behavior: 'smooth' });
  }

  // NEW: Reset cart after successful order
  function resetCart() {
    cart = [];
    updateCartCount();
    updateCartDisplay();
    updateOrderSummary();
  }

  // NEW: Show payment loading animation
  function showPaymentLoadingWithProgress() {
    // Create loading overlay if it doesn't exist
    let loadingOverlay = document.getElementById('payment-loading-overlay');
    if (!loadingOverlay) {
        loadingOverlay = document.createElement('div');
        loadingOverlay.id = 'payment-loading-overlay';
        loadingOverlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            color: white;
            font-size: 18px;
        `;
        loadingOverlay.innerHTML = `
            <div style="text-align: center;">
                <div style="margin-bottom: 20px;">Processing Payment...</div>
                <div style="width: 50px; height: 50px; border: 5px solid #f3f3f3; border-top: 5px solid #3498db; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto;"></div>
            </div>
        `;
        document.body.appendChild(loadingOverlay);
    } else {
        loadingOverlay.style.display = 'flex';
    }
  }

  // NEW: Hide payment loading
  function hidePaymentLoading() {
    const loadingOverlay = document.getElementById('payment-loading-overlay');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'none';
    }
  }

  // NEW: Show payment success
  function showPaymentSuccess() {
    // You can implement a success animation here
    console.log('Payment successful!');
  }

  // Initialize the application
  init();
});