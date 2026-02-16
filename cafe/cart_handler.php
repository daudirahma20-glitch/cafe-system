<?php
require_once 'config.php';

header('Content-Type: application/json');

$action = isset($_POST['action']) ? $_POST['action'] : '';

switch ($action) {
    case 'add':
        $item_id = $_POST['item_id'];
        $item_name = $_POST['item_name'];
        $item_price = $_POST['item_price'];
        
        if (!isset($_SESSION['cart'][$item_id])) {
            $_SESSION['cart'][$item_id] = array(
                'name' => $item_name,
                'price' => $item_price,
                'quantity' => 1
            );
        } else {
            $_SESSION['cart'][$item_id]['quantity']++;
        }
        
        echo json_encode(array(
            'success' => true,
            'cart_count' => array_sum(array_column($_SESSION['cart'], 'quantity'))
        ));
        break;
        
    case 'update':
        $item_id = $_POST['item_id'];
        $quantity = intval($_POST['quantity']);
        
        if (isset($_SESSION['cart'][$item_id])) {
            if ($quantity > 0) {
                $_SESSION['cart'][$item_id]['quantity'] = $quantity;
            } else {
                unset($_SESSION['cart'][$item_id]);
            }
        }
        
        echo json_encode(array('success' => true));
        header("Location: cart.php");
        break;
        
    case 'remove':
        $item_id = $_POST['item_id'];
        
        if (isset($_SESSION['cart'][$item_id])) {
            unset($_SESSION['cart'][$item_id]);
        }
        
        echo json_encode(array('success' => true));
        header("Location: cart.php");
        break;
        
    case 'get_count':
        $count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
        echo json_encode(array('cart_count' => $count));
        break;
        
    default:
        echo json_encode(array('success' => false, 'message' => 'Invalid action'));
}
?>