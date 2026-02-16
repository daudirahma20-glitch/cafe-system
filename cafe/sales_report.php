<?php
require_once 'config.php';

$conn = getDBConnection();

// Get filter date (default to today)
$filter_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Get daily summary
$sql = "SELECT 
            COUNT(*) as total_orders,
            SUM(total_amount) as total_sales,
            AVG(total_amount) as avg_order
        FROM orders 
        WHERE DATE(order_date) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $filter_date);
$stmt->execute();
$summary = $stmt->get_result()->fetch_assoc();

// Get all orders for the date
$sql = "SELECT * FROM orders WHERE DATE(order_date) = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $filter_date);
$stmt->execute();
$orders = $stmt->get_result();

// Get top selling items
$sql = "SELECT 
            m.item_name,
            SUM(oi.quantity) as total_quantity,
            SUM(oi.subtotal) as total_revenue
        FROM order_items oi
        JOIN menu_items m ON oi.item_id = m.item_id
        JOIN orders o ON oi.order_id = o.order_id
        WHERE DATE(o.order_date) = ?
        GROUP BY m.item_id, m.item_name
        ORDER BY total_quantity DESC
        LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $filter_date);
$stmt->execute();
$top_items = $stmt->get_result();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report - Cafe Billing System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>☕ Cafe Billing System</h1>
            <nav>
                <a href="index.php" class="nav-btn">Home</a>
                <a href="menu.php" class="nav-btn">Menu & Order</a>
                <a href="sales_report.php" class="nav-btn active">Sales Report</a>
            </nav>
        </header>

        <main>
            <div class="sales-section">
                <h2>Sales Report</h2>
                
                <div class="filter-section">
                    <form method="GET" action="sales_report.php">
                        <label for="date">Select Date:</label>
                        <input type="date" id="date" name="date" value="<?php echo $filter_date; ?>">
                        <button type="submit" class="btn">Filter</button>
                    </form>
                </div>

                <div class="summary-cards">
                    <div class="summary-card">
                        <h3>Total Orders</h3>
                        <p class="stat"><?php echo $summary['total_orders'] ?: 0; ?></p>
                    </div>
                    <div class="summary-card">
                        <h3>Total Sales</h3>
                        <p class="stat">$<?php echo number_format($summary['total_sales'] ?: 0, 2); ?></p>
                    </div>
                    <div class="summary-card">
                        <h3>Average Order</h3>
                        <p class="stat">$<?php echo number_format($summary['avg_order'] ?: 0, 2); ?></p>
                    </div>
                </div>

                <div class="top-items-section">
                    <h3>Top Selling Items</h3>
                    <?php if ($top_items->num_rows > 0): ?>
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Quantity Sold</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($item = $top_items->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                        <td><?php echo $item['total_quantity']; ?></td>
                                        <td>$<?php echo number_format($item['total_revenue'], 2); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No sales data for this date.</p>
                    <?php endif; ?>
                </div>

                <div class="orders-section">
                    <h3>All Orders</h3>
                    <?php if ($orders->num_rows > 0): ?>
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Table</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($order = $orders->fetch_assoc()): ?>
                                    <tr>
                                        <td>#<?php echo $order['order_id']; ?></td>
                                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                        <td><?php echo $order['table_number']; ?></td>
                                        <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                        <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                                        <td><?php echo date('H:i:s', strtotime($order['order_date'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No orders for this date.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <footer>
            <p>&copy; 2024 Cafe Billing System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>