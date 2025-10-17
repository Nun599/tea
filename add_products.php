<?php
include 'db_connection.php';

$products = [
    // Milktea
    ['Okinawa', 'milktea', 28.00, 38.00, 'img_milktea/okinawa.png'],
    ['Winter Melon', 'milktea', 28.00, 38.00, 'img_milktea/wintermelon.png'],
    ['Red Velvet', 'milktea', 28.00, 38.00, 'img_milktea/redvelvet.png'],
    ['Taro', 'milktea', 28.00, 38.00, 'img_milktea/taro.png'],
    ['Salted Caramel', 'milktea', 28.00, 38.00, 'img_milktea/saltedcaramel.png'],
    ['Matcha', 'milktea', 28.00, 38.00, 'img_milktea/matcha.png'],
    ['Choco Strawberry', 'milktea', 28.00, 38.00, 'img_milktea/chocostrawberry.png'],
    ['Cookies & Cream', 'milktea', 28.00, 38.00, 'img_milktea/cookies&cream.png'],
    
    // Cheesecake
    ['Okinawa', 'cheesecake', 43.00, 53.00, 'img_cheesecake/okinawa.jpeg'],
    ['Matcha', 'cheesecake', 43.00, 53.00, 'img_cheesecake/matcha.jpeg'],
    ['Dark Choco', 'cheesecake', 43.00, 53.00, 'img_cheesecake/dark_choco.jpeg'],
    ['Red Velvet', 'cheesecake', 43.00, 53.00, 'img_cheesecake/red_velvet.jpeg'],
    ['Cookies & Cream', 'cheesecake', 43.00, 53.00, 'img_cheesecake/cookies_and_cream.jpeg'],
    ['Salted Caramel', 'cheesecake', 43.00, 53.00, 'img_cheesecake/salted_caramel.jpeg'],
    ['Wintermelon', 'cheesecake', 43.00, 53.00, 'img_cheesecake/wintemelon.jpeg'],
    ['Double Oreo', 'cheesecake', 43.00, 53.00, 'img_cheesecake/double_oreo.jpeg'],
    
    // Frappe
    ['Java Chip', 'frappe', 55.00, 65.00, 'img_frappe/javachip.png'],
    ['Dark Mocha', 'frappe', 55.00, 65.00, 'img_frappe/darkmocha.png'],
    ['Mix Berries', 'frappe', 55.00, 65.00, 'img_frappe/mixberries.png'],
    ['Triple Chocolate', 'frappe', 55.00, 65.00, 'img_frappe/triplechocolate.png'],
    ['Matcha', 'frappe', 55.00, 65.00, 'img_frappe/matcha.png'],
    ['Dark Chocoberry', 'frappe', 55.00, 65.00, 'img_frappe/darkchocoberry.png'],
    ['Strawberry & Cream', 'frappe', 55.00, 65.00, 'img_frappe/strawberry&cream.png'],
    ['Dark Caramel', 'frappe', 55.00, 65.00, 'img_frappe/darkcaramel.png'],
    ['Blue Berries & Cream', 'frappe', 55.00, 65.00, 'img_frappe/blueberries&cream.png'],
    
    // Premium Frappe
    ['Almond Matcha', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/almondmatcha.png'],
    ['Dark Choco Creamcheese', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/darkchococreamcheese.png'],
    ['Dark Choco Lava', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/darkchocolava.png'],
    ['Dark Forest', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/darkforest.png'],
    ['Kopi Caramel', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/kopicaramel.png'],
    ['Lava Cheesecake', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/lavacheesecake.png'],
    ['Mango Cheesecake', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/mangocheesecake.png'],
    ['Oreo Cheesecake', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/oreocheesecake.png'],
    ['Red Velvet Creamcheese', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/redvelveltcreamcheese.png'],
    ['Strawberry Cheesecake', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/strawberrycheesecake.png'],
    ['Ube Creamcheese', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/ubecreamcheese.png'],
    ['White Choco Mocha', 'premiumfrappe', 88.00, NULL, 'img_premiumfrappe/whitechocomocha.png'],
    
    // Iced Coffee
    ['Americano', 'icecoffee', 50.00, 60.00, 'img_icecoffee/americano.png'],
    ['Caramel Machiatto', 'icecoffee', 50.00, 60.00, 'img_icecoffee/caramelmachiatto.png'],
    ['Dirty Matcha', 'icecoffee', 50.00, 60.00, 'img_icecoffee/dirtymatcha.png'],
    ['French Vanilla', 'icecoffee', 50.00, 60.00, 'img_icecoffee/frenchvanilla.png'],
    ['Mocha Latte', 'icecoffee', 50.00, 60.00, 'img_icecoffee/mochalatte.png'],
    ['Salted Caramel Latte', 'icecoffee', 50.00, 60.00, 'img_icecoffee/saltedcaramellatte.png'],
    ['Spanish Latte', 'icecoffee', 50.00, 60.00, 'img_icecoffee/spanishlatte.png'],
    ['White Chocolate', 'icecoffee', 50.00, 60.00, 'img_icecoffee/whitechocolate.png'],
    ['White Mocha', 'icecoffee', 50.00, 60.00, 'img_icecoffee/whitemocha.png'],
    
    // Hot Drinks
    ['Caramel Machiatto', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png'],
    ['Salted Caramel Latte', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png'],
    ['Spanish Latte', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png'],
    ['White Chocolate', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png'],
    ['Mocha Latte', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png'],
    ['French Vanilla', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png'],
    ['White Mocha', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png'],
    ['Hot Chocolate', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png'],
    ['Hot Americano', 'hotdrinks', 45.00, NULL, 'img_HotDrinks/hotdrinks.png'],
    
    // Milk Series
    ['Blue Berries & Milk', 'milkseries', 55.00, 65.00, 'img_milkseries/blueberries&milk.png'],
    ['Chocolate Latte', 'milkseries', 55.00, 65.00, 'img_milkseries/chocolatelatte.png'],
    ['Mango & Milk', 'milkseries', 55.00, 65.00, 'img_milkseries/mango&milk.png'],
    ['Matcha Latte', 'milkseries', 55.00, 65.00, 'img_milkseries/matchalatte.png'],
    ['Strawberry & Milk', 'milkseries', 55.00, 65.00, 'img_milkseries/strawberry&milk.png'],
    ['Ube Latte', 'milkseries', 55.00, 65.00, 'img_milkseries/ubelatte.png'],
    ['Ube Matcha Latte', 'milkseries', 55.00, 65.00, 'img_milkseries/ubematchalatte.png'],
    
    // Fruit Tea
    ['Blue Berry', 'fruittea', 28.00, 38.00, 'img_fruittea/blueberry.jpg'],
    ['Green Apple Tea', 'fruittea', 28.00, 38.00, 'img_fruittea/greenapple.jpg'],
    ['Lemon', 'fruittea', 28.00, 38.00, 'img_fruittea/lemon.jpg'],
    ['Strawberry', 'fruittea', 28.00, 38.00, 'img_fruittea/strawberry.jpg'],
    
    // Soda Refresher
    ['Blue Apple', 'soda', 28.00, 38.00, 'img_sodarefresher/blueapple.png'],
    ['Blue Lemonade', 'soda', 28.00, 38.00, 'img_sodarefresher/bluelemonade.png'],
    ['Mint Strawberry', 'soda', 28.00, 38.00, 'img_sodarefresher/mintstrrawberry.png'],
    ['Pink Mango', 'soda', 28.00, 38.00, 'img_sodarefresher/pinkmango.png']
];

$added = 0;
$errors = 0;

foreach ($products as $product) {
    // Check if product already exists
    $check_stmt = $pdo->prepare("SELECT id FROM products WHERE name = ? AND category = ?");
    $check_stmt->execute([$product[0], $product[1]]);
    
    if (!$check_stmt->fetch()) {
        // Product doesn't exist, insert it
        $stmt = $pdo->prepare("INSERT INTO products (name, category, price_regular, price_large, image_path, is_available) VALUES (?, ?, ?, ?, ?, 1)");
        if ($stmt->execute($product)) {
            $added++;
        } else {
            $errors++;
        }
    }
}

echo "<h2>Products Added Successfully!</h2>";
echo "<p>Added: $added products</p>";
echo "<p>Errors: $errors</p>";
echo "<p><a href='admin_products.php'>View Products</a></p>";
?>