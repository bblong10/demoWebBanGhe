<?php
session_start();
header('Content-Type: application/json');

// Kiểm tra nếu giỏ hàng đã được tạo
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Lấy thông tin sản phẩm từ giỏ hàng
$cartItems = $_SESSION['cart'];

// Kết nối cơ sở dữ liệu và lấy thông tin sản phẩm (giả sử dùng MySQL)
$mysqli = new mysqli('localhost', 'root', '', 'website');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$cart_items = array();
if (!empty($cartItems)) {
    // Chuyển đổi mảng ID sản phẩm thành chuỗi cho câu lệnh SQL
    $itemIds = implode(',', array_keys($cartItems));

    // Lấy thông tin sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT id, name, image, price, description FROM products WHERE id IN ($itemIds)";
    $result = $mysqli->query($sql);

    while ($row = $result->fetch_assoc()) {
        // Thêm số lượng vào thông tin sản phẩm
        $row['quantity'] = $cartItems[$row['id']];
        $cart_items[] = $row;
    }
}

$mysqli->close();

// Trả về thông tin sản phẩm trong giỏ hàng dưới dạng JSON
echo json_encode($cart_items);
?>
