<?php
require_once 'config.php';

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$cartItems = $_SESSION['cart'];
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Cafe Billing System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>☕ Cafe Billing System</h1>
            <nav>
                <a href="index.php" class="nav-btn">Home</a>
                <a href="menu.php" class="nav-btn">Menu & Order</a>
                <a href="sales_report.php" class="nav-btn">Sales Report</a>
            </nav>
        </header>

        <main>
            <div class="cart-section">
                <h2>Your Order</h2>
                
                <?php if (empty($cartItems)): ?>
                    <p class="empty-cart">Your cart is empty. <a href="menu.php">Browse Menu</a></p>
                <?php else: ?>
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="cart-items">
                            <?php foreach ($cartItems as $id => $item): ?>
                                <?php 
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $total += $subtotal;
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                                    <td>
                                        <input type="number" 
                                               value="<?php echo $item['quantity']; ?>" 
                                               min="1" 
                                               onchange="updateQuantity(<?php echo $id; ?>, this.value)"
                                               class="qty-input">
                                    </td>
                                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                                    <td>
                                        <button onclick="removeItem(<?php echo $id; ?>)" class="btn-remove">Remove</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"><strong>Total:</strong></td>
                                <td colspan="2"><strong>$<?php echo number_format($total, 2); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="checkout-form">
                        <h3>Customer Details</h3>
                        <form action="process_order.php" method="POST">
                            <div class="form-group">
                                <label for="customer_name">Customer Name:</label>
                                <input type="text" id="customer_name" name="customer_name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="table_number">Table Number:</label>
                                <input type="number" id="table_number" name="table_number" min="1" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="payment_method">Payment Method:</label>
                                <select id="payment_method" name="payment_method" required>
                                    <option value="">Select Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Debit Card">Debit Card</option>
                                    <option value="Mobile Payment">Mobile Payment</option>
                                </select>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Complete Order</button>
                                <button type="button" onclick="window.location.href='menu.php'" class="btn">Continue Shopping</button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <footer>
            <p>&copy; 2024 Cafe Billing System. All rights reserved.</p>
        </footer>
    </div>

    <script src="script.js"></script>
</body>
</html>