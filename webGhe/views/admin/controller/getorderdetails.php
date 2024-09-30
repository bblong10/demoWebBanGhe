<?php
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

// Lấy mã đơn hàng từ yêu cầu POST
$orderId = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;

if ($orderId <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid order ID']);
    exit();
}

try {
    // Lấy thông tin đơn hàng
    $stmt = $conn->prepare("SELECT * FROM cart WHERE cart_id = ?");
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $orderResult = $stmt->get_result()->fetch_assoc();

    if (!$orderResult) {
        echo json_encode(['status' => 'error', 'message' => 'Order not found']);
        exit();
    }

    // Lấy chi tiết đơn hàng
    $stmt = $conn->prepare("SELECT * FROM cartdetail WHERE cart_id = ?");
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $detailsResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => [
            'order_code' => $orderResult['order_code'],
            'order_date' => $orderResult['order_date'],
            'details' => $detailsResult
        ]
    ]);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$conn->close();
?>
