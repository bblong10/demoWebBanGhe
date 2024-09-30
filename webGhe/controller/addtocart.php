<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_POST['id']) && isset($_POST['quantity'])) {
    $id = $_POST['id'];
    $quantity = intval($_POST['quantity']);

    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $quantity;
    } else {
        $_SESSION['cart'][$id] = $quantity;
    }

    $response = array('status' => 'success');
    echo json_encode($response);
} else {
    $response = array('status' => 'error');
    echo json_encode($response);
}
?>