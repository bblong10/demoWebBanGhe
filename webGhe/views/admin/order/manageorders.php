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

// Kiểm tra người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['userid'])) {
    header('Location: /views/login.php'); // Điều hướng tới trang đăng nhập
    exit();
}

// Lấy thông tin người dùng
$userId = $_SESSION['userid'];
$userRole = $_SESSION['role']; // Giả sử bạn lưu vai trò của người dùng vào session

// Lấy danh sách đơn hàng dựa trên vai trò của người dùng
try {
    if ($userRole === 'user') {
        // User, hiển thị chỉ đơn hàng của chính họ
        $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
    } elseif ($userRole === 'shipper' || $userRole === 'admin') {
        // Shipper hoặc admin, hiển thị tất cả đơn hàng
        $stmt = $conn->prepare("SELECT * FROM cart");
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        throw new Exception('Bạn không có quyền truy cập vào trang này');
    }

    $orders = $result->fetch_all(MYSQLI_ASSOC);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="mt-5">
        <h1 class="mb-4">Quản lý đơn hàng</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Khách Hàng</th>
                    <th>Địa Chỉ</th>
                    <th>Điện Thoại</th>
                    <th>Ghi Chú</th>
                    <th>Trạng Thái</th>
                    <th>Thao Tác</th>
                    <th>Chi Tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['cart_id']); ?></td>
                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($order['customer_address']); ?></td>
                    <td><?php echo htmlspecialchars($order['customer_phone']); ?></td>
                    <td><?php echo htmlspecialchars($order['customer_notes']); ?></td>
                    <td id="status-<?php echo htmlspecialchars($order['cart_id']); ?>">
                        <?php
                                $statusText = '';
                                switch ($order['status']) {
                                    case 'pending':
                                        $statusText = 'Đợi xác nhận';
                                        break;
                                    case 'processed':
                                        $statusText = 'Đợi đơn vị giao hàng';
                                        break;
                                    case 'shipped':
                                        $statusText = 'Đang trên đường giao';
                                        break;
                                    case 'completed':
                                        $statusText = 'Đã nhận hàng';
                                        break;
                                    case 'canceled':
                                        $statusText = 'Đã hủy';
                                        break;
                                }
                                echo htmlspecialchars($statusText);
                            ?>
                    </td>
                    <td>
                        <?php if ($userRole === 'admin'): ?>
                        <select class="form-control status-select"
                            data-order-id="<?php echo htmlspecialchars($order['cart_id']); ?>">
                            <option value="pending" <?php if ($order['status'] == 'pending') echo 'selected'; ?>>Đợi xác
                                nhận</option>
                            <option value="processed" <?php if ($order['status'] == 'processed') echo 'selected'; ?>>Đợi
                                đơn vị giao hàng</option>
                            <option value="shipped" <?php if ($order['status'] == 'shipped') echo 'selected'; ?>>Đang
                                trên đường giao</option>
                            <option value="completed" <?php if ($order['status'] == 'completed') echo 'selected'; ?>>Đã
                                nhận hàng</option>
                            <option value="canceled" <?php if ($order['status'] == 'canceled') echo 'selected'; ?>>Đã
                                hủy</option>
                        </select>
                        <?php elseif ($userRole === 'user'): ?>
                        <select class="form-control status-select"
                            data-order-id="<?php echo htmlspecialchars($order['cart_id']); ?>">
                            <option value="completed" <?php if ($order['status'] == 'completed') echo 'selected'; ?>>Đã
                                nhận hàng</option>
                            <option value="canceled" <?php if ($order['status'] == 'canceled') echo 'selected'; ?>>Đã
                                hủy</option>
                        </select>
                        <?php elseif ($userRole === 'shipper'): ?>
                        <select class="form-control status-select"
                            data-order-id="<?php echo htmlspecialchars($order['cart_id']); ?>">
                            <option value="shipped" <?php if ($order['status'] == 'shipped') echo 'selected'; ?>>Đang
                                trên đường giao</option>
                            <option value="completed" <?php if ($order['status'] == 'completed') echo 'selected'; ?>>Đã
                                nhận hàng</option>
                        </select>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-info view-details"
                            data-order-id="<?php echo htmlspecialchars($order['cart_id']); ?>">Xem chi tiết</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailsModalLabel">Chi tiết đơn hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="order-details-body">
                    <!-- Nội dung chi tiết đơn hàng sẽ được tải vào đây -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('.status-select').on('change', function() {
            var orderId = $(this).data('order-id');
            var newStatus = $(this).val();
            var statusText = '';

            switch (newStatus) {
                case 'pending':
                    statusText = 'Đợi xác nhận';
                    break;
                case 'processed':
                    statusText = 'Đợi đơn vị giao hàng';
                    break;
                case 'shipped':
                    statusText = 'Đang trên đường giao';
                    break;
                case 'completed':
                    statusText = 'Đã nhận hàng';
                    break;
                case 'canceled':
                    statusText = 'Đã hủy';
                    break;
            }

            $.ajax({
                url: '/views/admin/controller/updateorderstatus.php',
                method: 'POST',
                data: {
                    order_id: orderId,
                    status: newStatus
                },
                success: function(response) {
                    var jsonResponse = JSON.parse(response);

                    if (jsonResponse.status === 'success') {
                        // Cập nhật trạng thái trên giao diện
                        $('#status-' + orderId).text(statusText);
                    } else {
                        alert('Error: ' + jsonResponse.message);
                    }
                },
                error: function() {
                    alert('Request failed');
                }
            });
        });

        $('.view-details').on('click', function() {
            var orderId = $(this).data('order-id');

            $.ajax({
                url: '/views/admin/controller/getorderdetails.php',
                method: 'POST',
                data: {
                    order_id: orderId
                },
                success: function(response) {
                    var jsonResponse = JSON.parse(response);

                    if (jsonResponse.status === 'success') {
                        var orderDetails = jsonResponse.data;
                        var detailsHtml = '<h4>Thông tin đơn hàng</h4>';
                        detailsHtml += '<p><strong>Mã đơn hàng:</strong> ' + orderDetails
                            .order_code + '</p>';
                        detailsHtml += '<p><strong>Ngày đặt hàng:</strong> ' + orderDetails
                            .order_date + '</p>';
                        detailsHtml += '<h5>Chi tiết sản phẩm</h5>';
                        detailsHtml += '<table class="table table-bordered">';
                        detailsHtml +=
                            '<thead><tr><th>Tên Sản Phẩm</th><th>Giá</th><th>Số Lượng</th><th>Tổng Giá</th></tr></thead>';
                        detailsHtml += '<tbody>';
                        var total = 0;
                        $.each(orderDetails.details, function(index, detail) {
                            total += Number(detail.total_price);
                            var thanhtienfix = Number(detail.total_price).toLocaleString(
                                'en-US', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                                var dongia = Number(detail.product_price).toLocaleString(
                                'en-US', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                            detailsHtml += '<tr>';
                            detailsHtml += '<td>' + detail.product_name + '</td>';
                            detailsHtml += '<td>' + dongia + ' VND</td>';
                            detailsHtml += '<td>' + detail.quantity + '</td>';
                            detailsHtml += '<td>' + thanhtienfix + ' VND</td>';
                            detailsHtml += '</tr>';
                        });
                        var thanhtienttfix = Number(total).toLocaleString(
                                'en-US', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                        detailsHtml += '</tbody></table>';
                        detailsHtml += '<p style="text-align:right">Tổng: <span class="text-danger font-weight-bolder">'+thanhtienttfix+' VND</span></p>'
                        $('#order-details-body').html(detailsHtml);
                        $('#orderDetailsModal').modal('show');
                    } else {
                        alert('Error: ' + jsonResponse.message);
                    }
                },
                error: function() {
                    alert('Request failed');
                }
            });
        });
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>