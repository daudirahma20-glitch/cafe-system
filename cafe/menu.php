<?php
require_once 'config.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Get menu items
$conn = getDBConnection();
$sql = "SELECT * FROM menu_items WHERE available = 1 ORDER BY category, item_name";
$result = $conn->query($sql);

$menu = array();
while ($row = $result->fetch_assoc()) {
    $menu[$row['category']][] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Cafe Billing System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>☕ Cafe Billing System</h1>
            <nav>
                <a href="index.php" class="nav-btn">Home</a>
                <a href="menu.php" class="nav-btn active">Menu & Order</a>
                <a href="sales_report.php" class="nav-btn">Sales Report</a>
            </nav>
        </header>

        <main>
            <div class="menu-section">
                <h2>Our Menu</h2>
                
                <div class="cart-summary">
                    <span>Items in Cart: <strong id="cart-count">0</strong></span>
                    <button onclick="window.location.href='cart.php'" class="btn">View Cart</button>
                </div>

                <?php foreach ($menu as $category => $items): ?>
                    <div class="category-section">
                        <h3><?php echo htmlspecialchars($category); ?></h3>
                        <div class="menu-grid">
                            <?php foreach ($items as $item): ?>
                                <div class="menu-item">
                                    <div class="item-info">
                                        <h4><?php echo htmlspecialchars($item['item_name']); ?></h4>
                                        <p><?php echo htmlspecialchars($item['description']); ?></p>
                                        <p class="price">$<?php echo number_format($item['price'], 2); ?></p>
                                    </div>
                                    <button onclick="addToCart(<?php echo $item['item_id']; ?>, '<?php echo htmlspecialchars($item['item_name']); ?>', <?php echo $item['price']; ?>)" class="btn-add">Add to Cart</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>

        <footer>
            <p>&copy; 2024 Cafe Billing System. All rights reserved.</p>
        </footer>
    </div>

    <script src="script.js"></script>
</body>
</html>