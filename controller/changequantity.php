<?php
session_start();
if (!isset($_SESSION['cart'])) {
    echo json_encode(['status' => 'error', 'message' => 'No cart found.']);
    exit;
}

if (!isset($_POST['id']) || !isset($_POST['quantity'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit;
}

$id = intval($_POST['id']);
$quantity = intval($_POST['quantity']);

if ($quantity < 0) {
    // Remove item from cart if quantity is zero
    if (isset($_SESSION['cart'][$id])) {
        if ($_SESSION['cart'][$id] + $quantity <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id] += $quantity;
        }
    }
} else {
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $quantity;
    } else {
        $_SESSION['cart'][$id] = $quantity;
    }
}

echo json_encode(['status' => 'success']);
?>
