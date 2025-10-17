<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Menu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f5f0;
            color: #5a4a42;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0d6cc;
        }
        
        h1 {
            font-size: 2.5rem;
            color: #8b5a2b;
            margin-bottom: 10px;
        }
        
        .subtitle {
            font-size: 1.2rem;
            color: #a0866f;
        }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .menu-item {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        
        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        
        .product-image {
            width: 100%;
            height: 180px;
            background-color: #e0d6cc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8b5a2b;
            font-weight: bold;
            font-size: 1.1rem;
        }
        
        .product-info {
            padding: 15px;
        }
        
        .product-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: #5a4a42;
        }
        
        .product-description {
            font-size: 0.9rem;
            color: #a0866f;
            margin-bottom: 10px;
        }
        
        .product-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #8b5a2b;
        }
        
        .flavors-section {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        
        .flavors-section h2 {
            color: #8b5a2b;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .flavors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .flavor-item {
            background-color: #f8f5f0;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        
        .flavor-item:hover {
            background-color: #e9e1d6;
        }
        
        .flavor-name {
            font-weight: 600;
            color: #5a4a42;
        }
        
        @media (max-width: 768px) {
            .menu-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
            
            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>MILK TEA</h1>
        </header>
        
        <div class="menu-grid">
            <!-- Product Image -->
            <div class="menu-item">
                <div class="product-image">Product Image</div>
                <div class="product-info">
                    <div class="product-name">Product Image</div>
                    <div class="product-description">Click to view product images</div>
                </div>
            </div>
            
            <!-- Hot Drinks -->
            <div class="menu-item">
                <div class="product-image">Hot Drinks</div>
                <div class="product-info">
                    <div class="product-name">Hot Drinks</div>
                    <div class="product-description">Warm and comforting beverages</div>
                </div>
            </div>
            
            <!-- Frappe -->
            <div class="menu-item">
                <div class="product-image">Frappe</div>
                <div class="product-info">
                    <div class="product-name">Frappe</div>
                    <div class="product-description">Icy blended delights</div>
                </div>
            </div>
            
            <!-- Milk Tea -->
            <div class="menu-item" onclick="showMilkTeaFlavors()">
                <div class="product-image">Milk Tea</div>
                <div class="product-info">
                    <div class="product-name">Milk Tea</div>
                    <div class="product-description">28 | 38</div>
                    <div class="product-price">$4.00</div>
                </div>
            </div>
            
            <!-- Cheesecake -->
            <div class="menu-item">
                <div class="product-image">Cheesecake</div>
                <div class="product-info">
                    <div class="product-name">Cheesecake</div>
                    <div class="product-description">Rich and creamy dessert</div>
                    <div class="product-price">$2.50</div>
                </div>
            </div>
            
            <!-- Green Tea -->
            <div class="menu-item">
                <div class="product-image">Green Tea</div>
                <div class="product-info">
                    <div class="product-name">Green Tea</div>
                    <div class="product-description">Refreshing and healthy</div>
                    <div class="product-price">$5.00</div>
                </div>
            </div>
            
            <!-- Chocolate Cake -->
            <div class="menu-item">
                <div class="product-image">Chocolate Cake</div>
                <div class="product-info">
                    <div class="product-name">Chocolate Cake</div>
                    <div class="product-description">Decadent chocolate treat</div>
                    <div class="product-price">$5.00</div>
                </div>
            </div>
            
            <!-- Iced Coffee -->
            <div class="menu-item">
                <div class="product-image">Iced Coffee</div>
                <div class="product-info">
                    <div class="product-name">Iced Coffee</div>
                    <div class="product-description">Chilled coffee perfection</div>
                </div>
            </div>
            
            <!-- Premium Frappe -->
            <div class="menu-item">
                <div class="product-image">Premium Frappe</div>
                <div class="product-info">
                    <div class="product-name">Premium Frappe</div>
                    <div class="product-description">Specialty blended drinks</div>
                </div>
            </div>
            
            <!-- Milk Series -->
            <div class="menu-item">
                <div class="product-image">Milk Series</div>
                <div class="product-info">
                    <div class="product-name">Milk Series</div>
                    <div class="product-description">Creamy milk-based drinks</div>
                </div>
            </div>
            
            <!-- Fruit Tea -->
            <div class="menu-item">
                <div class="product-image">Fruit Tea</div>
                <div class="product-info">
                    <div class="product-name">Fruit Tea</div>
                    <div class="product-description">Fruity and refreshing</div>
                </div>
            </div>
        </div>
        
        <div id="milkTeaFlavors" class="flavors-section" style="display: none;">
            <h2>Milk Tea Flavors</h2>
            <div class="flavors-grid">
                <div class="flavor-item">
                    <div class="flavor-name">Classic Milk Tea</div>
                </div>
                <div class="flavor-item">
                    <div class="flavor-name">Taro Milk Tea</div>
                </div>
                <div class="flavor-item">
                    <div class="flavor-name">Wintermelon Milk Tea</div>
                </div>
                <div class="flavor-item">
                    <div class="flavor-name">Thai Milk Tea</div>
                </div>
                <div class="flavor-item">
                    <div class="flavor-name">Honeydew Milk Tea</div>
                </div>
                <div class="flavor-item">
                    <div class="flavor-name">Matcha Milk Tea</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showMilkTeaFlavors() {
            const flavorsSection = document.getElementById('milkTeaFlavors');
            flavorsSection.style.display = 'block';
            
            // Scroll to the flavors section
            flavorsSection.scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>