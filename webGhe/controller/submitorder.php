<?php
session_start();
require '../connect/db.php'; // Đảm bảo đường dẫn chính xác tới tệp kết nối cơ sở dữ liệu

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION["userid"]) && !isset($_SESSION["username"])) {
    echo json_encode(['status' => 'error', 'message' => 'Bạn cần đăng nhập để thực hiện đơn hàng.']);
    exit;
}

// Kiểm tra xem giỏ hàng có rỗng không
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo json_encode(['status' => 'error', 'message' => 'Giỏ hàng trống.']);
    exit;
}

// Kiểm tra xem thông tin khách hàng có được cung cấp không
if (!isset($_POST['name']) || !isset($_POST['address']) || !isset($_POST['phone'])) {
    echo json_encode(['status' => 'error', 'message' => 'Thông tin không đầy đủ.']);
    exit;
}

// Thu thập thông tin khách hàng
$customerName = htmlspecialchars(trim($_POST['name']));
$customerAddress = htmlspecialchars(trim($_POST['address']));
$customerPhone = htmlspecialchars(trim($_POST['phone']));
$customerNotes = isset($_POST['notes']) ? htmlspecialchars(trim($_POST['notes'])) : '';
$userId = $_SESSION['userid']; // Lấy ID người dùng từ session

// Tạo mã đơn hàng ngẫu nhiên (hoặc bạn có thể sử dụng một cách tạo mã khác)
$orderCode = 'ORD-' . strtoupper(bin2hex(random_bytes(6))); // Tạo mã đơn hàng ngẫu nhiên

try {
    // Bắt đầu giao dịch
    $pdo->beginTransaction();

    // Chèn thông tin khách hàng và mã đơn hàng vào bảng cart
    $stmt = $pdo->prepare("INSERT INTO cart (order_code, customer_name, customer_address, customer_phone, customer_notes, user_id) 
                           VALUES (:order_code, :name, :address, :phone, :notes, :user_id)");
    $stmt->execute([
        ':order_code' => $orderCode,
        ':name' => $customerName,
        ':address' => $customerAddress,
        ':phone' => $customerPhone,
        ':notes' => $customerNotes,
        ':user_id' => $userId
    ]);

    // Lấy ID của đơn hàng vừa chèn
    $cartId = $pdo->lastInsertId();

    // Chèn chi tiết đơn hàng cho từng sản phẩm trong giỏ hàng
    foreach ($_SESSION['cart'] as $id => $quantity) {
        // Lấy thông tin sản phẩm từ cơ sở dữ liệu
        $stmt = $pdo->prepare("SELECT name, price FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $product = $stmt->fetch();

        if ($product) {
            $stmt = $pdo->prepare("INSERT INTO cartdetail (cart_id, product_id, product_name, product_price, quantity, total_price)
                                   VALUES (:cart_id, :product_id, :product_name, :product_price, :quantity, :total_price)");
            $stmt->execute([
                ':cart_id' => $cartId,
                ':product_id' => $id,
                ':product_name' => $product['name'],
                ':product_price' => $product['price'],
                ':quantity' => $quantity,
                ':total_price' => $product['price'] * $quantity
            ]);
        } else {
            throw new Exception("Sản phẩm không tồn tại.");
        }
    }

    // Cam kết giao dịch
    $pdo->commit();

    // Xóa giỏ hàng trong session sau khi lưu
    unset($_SESSION['cart']);

    echo json_encode(['status' => 'success', 'message' => 'Đơn hàng đã được gửi thành công!']);

} catch (Exception $e) {
    // Hủy giao dịch nếu có lỗi
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(['status' => 'error', 'message' => 'Lỗi khi gửi đơn hàng: ' . $e->getMessage()]);
}
?>
