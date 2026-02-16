<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['cart'])) {
    $customer_name = $_POST['customer_name'];
    $table_number = $_POST['table_number'];
    $payment_method = $_POST['payment_method'];
    
    $conn = getDBConnection();
    
    // Calculate total
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    
    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, table_number, total_amount, payment_status, payment_method) VALUES (?, ?, ?, 'paid', ?)");
    $stmt->bind_param("sids", $customer_name, $table_number, $total, $payment_method);
    $stmt->execute();
    
    $order_id = $conn->insert_id;
    
    // Insert order items
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, item_id, quantity, item_price, subtotal) VALUES (?, ?, ?, ?, ?)");
    
    foreach ($_SESSION['cart'] as $item_id => $item) {
        $quantity = $item['quantity'];
        $price = $item['price'];
        $subtotal = $price * $quantity;
        
        $stmt->bind_param("iiidd", $order_id, $item_id, $quantity, $price, $subtotal);
        $stmt->execute();
    }
    
    $stmt->close();
    $conn->close();
    
    // Store order details for receipt
    $_SESSION['last_order'] = array(
        'order_id' => $order_id,
        'customer_name' => $customer_name,
        'table_number' => $table_number,
        'payment_method' => $payment_method,
        'total' => $total,
        'items' => $_SESSION['cart']
    );
    
    // Clear cart
    unset($_SESSION['cart']);
    
    // Redirect to receipt
    header("Location: receipt.php");
    exit();
} else {
    header("Location: menu.php");
    exit();
}
?>