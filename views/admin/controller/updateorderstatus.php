<?php
session_start();

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

// Kiểm tra nếu thông tin đơn hàng được gửi đến
if (!isset($_POST['order_id']) || !isset($_POST['status'])) {
    echo json_encode(['status' => 'error', 'message' => 'Thông tin không đầy đủ']);
    exit();
}

// Lấy thông tin đơn hàng
$orderId = $_POST['order_id'];
$newStatus = $_POST['status'];

// Kiểm tra trạng thái đơn hàng
try {
    // Lấy thông tin trạng thái hiện tại của đơn hàng
    $stmt = $conn->prepare("SELECT status FROM cart WHERE cart_id = ?");
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $stmt->bind_result($currentStatus);
    $stmt->fetch();
    $stmt->close();

    // Kiểm tra trạng thái hiện tại và trạng thái mới
    // if ($currentStatus == 'pending' && $newStatus == 'processed' && $_SESSION['role'] != 'admin') {
    //     echo json_encode(['status' => 'error', 'message' => 'Bạn không có quyền chuyển đổi trạng thái này']);
    //     exit();
    // }

    // Cập nhật trạng thái đơn hàng
    $stmt = $conn->prepare("UPDATE cart SET status = ? WHERE cart_id = ?");
    $stmt->bind_param('si', $newStatus, $orderId);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['status' => 'success', 'message' => 'Trạng thái đơn hàng đã được cập nhật']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi khi cập nhật đơn hàng: ' . $e->getMessage()]);
}

// Đóng kết nối
$conn->close();
?>
