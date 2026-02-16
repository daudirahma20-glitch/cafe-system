<?php
require_once 'config.php';

if (!isset($_SESSION['last_order'])) {
    header("Location: index.php");
    exit();
}

$order = $_SESSION['last_order'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Cafe Billing System</title>
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
            <div class="receipt-section">
                <div class="receipt" id="receipt">
                    <div class="receipt-header">
                        <h2>☕ CAFE BILLING SYSTEM</h2>
                        <p>Thank you for your visit!</p>
                        <hr>
                    </div>
                    
                    <div class="receipt-info">
                        <p><strong>Order ID:</strong> #<?php echo $order['order_id']; ?></p>
                        <p><strong>Customer:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                        <p><strong>Table:</strong> <?php echo $order['table_number']; ?></p>
                        <p><strong>Date:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
                        <p><strong>Payment:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
                        <hr>
                    </div>
                    
                    <div class="receipt-items">
                        <table>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order['items'] as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                                        <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <hr>
                    </div>
                    
                    <div class="receipt-total">
                        <p class="total-line"><strong>TOTAL:</strong> <strong>$<?php echo number_format($order['total'], 2); ?></strong></p>
                        <p class="paid-line">PAID - <?php echo htmlspecialchars($order['payment_method']); ?></p>
                        <hr>
                    </div>
                    
                    <div class="receipt-footer">
                        <p>Thank you for dining with us!</p>
                        <p>Please visit again</p>
                    </div>
                </div>
                
                <div class="receipt-actions">
                    <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
                    <button onclick="window.location.href='index.php'" class="btn">Back to Home</button>
                </div>
            </div>
        </main>

        <footer>
            <p>&copy; 2024 Cafe Billing System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>