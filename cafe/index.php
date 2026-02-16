<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Billing System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>☕ Cafe Billing System</h1>
            <nav>
                <a href="index.php" class="nav-btn active">Home</a>
                <a href="menu.php" class="nav-btn">Menu & Order</a>
                <a href="sales_report.php" class="nav-btn">Sales Report</a>
            </nav>
        </header>

        <main>
            <div class="welcome-section">
                <h2>Welcome to Our Cafe</h2>
                <p>Enjoy delicious food and beverages in a cozy atmosphere</p>
                
                <div class="feature-cards">
                    <div class="card">
                        <h3>📋 View Menu</h3>
                        <p>Browse our extensive menu of coffees, teas, pastries, and meals</p>
                        <a href="menu.php" class="btn">View Menu</a>
                    </div>
                    
                    <div class="card">
                        <h3>🛒 Place Order</h3>
                        <p>Select items and place your order easily</p>
                        <a href="menu.php" class="btn">Order Now</a>
                    </div>
                    
                    <div class="card">
                        <h3>📊 Sales Reports</h3>
                        <p>View daily sales and transaction history</p>
                        <a href="sales_report.php" class="btn">View Reports</a>
                    </div>
                </div>
            </div>
        </main>

        <footer>
            <p>&copy; 2024 Cafe Billing System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>