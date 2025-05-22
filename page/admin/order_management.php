<?php
include '../../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    // Khởi tạo biến thông báo
    $message = '';

    // Xử lý hủy đơn hàng
    if (isset($_GET['cancel_order'])) {
        $order_id = (int)$_GET['cancel_order'];
        $stmt = $conn_store->prepare('SELECT status FROM orders WHERE id = ?');
        $stmt->execute([$order_id]);
        $order = $stmt->fetch();

        if ($order) {
            if ($order['status'] === 'pending' || $order['status'] === 'delivered') {
                $stmt = $conn_store->prepare('UPDATE orders SET status = "cancelled" WHERE id = ?');
                $stmt->execute([$order_id]);
                $_SESSION['message'] = "Đơn hàng #$order_id đã được hủy thành công!";
            } else {
                $_SESSION['message'] = "Đơn hàng #$order_id không thể hủy vì đang được xử lý!";
            }
        } else {
            $_SESSION['message'] = "Đơn hàng #$order_id không tồn tại!";
        }
        header("Location: /minh/page/admin/order_management.php");
        exit;
    }

    // Xử lý đặt đơn hàng thành công
    if (isset($_GET['mark_delivered'])) {
        $order_id = (int)$_GET['mark_delivered'];
        $stmt = $conn_store->prepare('SELECT status FROM orders WHERE id = ?');
        $stmt->execute([$order_id]);
        $order = $stmt->fetch();

        if ($order) {
            if ($order['status'] === 'pending' || $order['status'] === 'shipped') {
                $stmt = $conn_store->prepare('UPDATE orders SET status = "delivered" WHERE id = ?');
                $stmt->execute([$order_id]);
                $_SESSION['message'] = "Đơn hàng #$order_id đã được đánh dấu giao hàng thành công!";
            } else {
                $_SESSION['message'] = "Đơn hàng #$order_id không thể đánh dấu giao hàng thành công!";
            }
        } else {
            $_SESSION['message'] = "Đơn hàng #$order_id không tồn tại!";
        }
        header("Location: /minh/page/admin/order_management.php");
        exit;
    }

    // Lấy tất cả đơn hàng
    $stmt = $conn_store->query('SELECT * FROM orders ORDER BY created_at DESC');
    $orders = $stmt->fetchAll();

    // Hiển thị thông báo nếu có
    $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
    unset($_SESSION['message']);

} catch (PDOException $e) {
    echo "Lỗi truy vấn: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đơn Hàng</title>
</head>
<body>
    <div class="orders-wrapper">
        <div class="container animate-in">
            <h1>Quản Lý Đơn Hàng</h1>

            <!-- Nút Quay lại -->
            <div class="back-button">
                <a href="../../page/admin/admin.php" class="btn btn-back">Quay lại</a>
            </div>

            <!-- Hiển thị thông báo -->
            <?php if (!empty($message)): ?>
                <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID Đơn Hàng</th>
                            <th>User ID</th>
                            <th>Họ Tên</th>
                            <th>Số Điện Thoại</th>
                            <th>Email</th>
                            <th>Địa Chỉ</th>
                            <th>Thông Tin Thêm</th>
                            <th>Tổng Giá</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Đặt</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo substr($order['id'], 0, 6) . (strlen($order['id']) > 6 ? '...' : ''); ?></td>
                                <td><?php echo substr((string)$order['user_id'], 0, 6) . (strlen((string)$order['user_id']) > 6 ? '...' : ''); ?></td>
                                <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['phone']); ?></td>
                                <td><?php echo htmlspecialchars($order['email']); ?></td>
                                <td><?php echo htmlspecialchars($order['address']); ?></td>
                                <td><?php echo htmlspecialchars($order['additional_info']); ?></td>
                                <td class="price"><?php echo number_format($order['total'], 0, ',', '.') . ' VNĐ'; ?></td>
                                <td>
                                    <?php
                                    $status = isset($order['status']) ? $order['status'] : 'unknown';
                                    switch ($status) {
                                        case 'pending':
                                            echo '<span class="status pending">Chưa giao hàng</span>';
                                            break;
                                        case 'shipped':
                                            echo '<span class="status shipped">Đang giao hàng</span>';
                                            break;
                                        case 'delivered':
                                            echo '<span class="status delivered">Giao hàng thành công</span>';
                                            break;
                                        case 'cancelled':
                                            echo '<span class="status cancelled">Đã hủy</span>';
                                            break;
                                        default:
                                            echo '<span class="status unknown">Không xác định</span>';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $order['created_at']; ?></td>
                                <td>
                                    <?php if (isset($order['status']) && ($order['status'] === 'pending' || $order['status'] === 'delivered')): ?>
                                        <a href="?cancel_order=<?php echo $order['id']; ?>" class="btn btn-cancel" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">Hủy</a>
                                    <?php endif; ?>
                                    <?php if (isset($order['status']) && ($order['status'] === 'pending' || $order['status'] === 'shipped')): ?>
                                        <a href="?mark_delivered=<?php echo $order['id']; ?>" class="btn btn-delivered" onclick="return confirm('Bạn có chắc chắn muốn đánh dấu đơn hàng này đã giao thành công?')">Đặt thành công</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="11" class="empty-message">Không có đơn hàng nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
    body {
        font-family: Arial, sans-serif;
        background-image: url(../../images/123.jpg);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        margin: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .orders-wrapper {
        flex: 1;
        padding: 40px 20px;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .animate-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease-in-out forwards;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    h1 {
        color: #fff;
        margin-bottom: 30px;
        text-align: center;
        font-size: 2.5em;
        font-weight: 500;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }

    .message {
        background: #d4edda;
        color: #155724;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
        text-align: center;
    }

    .message.error {
        background: #ffdddd;
        color: #d8000c;
    }

    .table-wrapper {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1200px;
    }

    th, td {
        padding: 20px 25px;
        text-align: left;
        transition: all 0.3s ease;
    }

    th {
        background: linear-gradient(45deg, #9c5ffd, #1de0ff);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        white-space: nowrap;
    }

    tbody tr {
        transition: all 0.3s ease;
    }

    tbody tr:hover {
        background: rgba(156, 95, 253, 0.1);
        transform: scale(1.01);
    }

    .price {
        color: #ff4081;
        font-weight: 500;
    }

    .empty-message {
        text-align: center;
        padding: 40px;
        color: #7f8c8d;
        font-style: italic;
    }

    .status {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.9em;
        font-weight: 500;
    }

    .status.pending {
        background: #ffe082;
        color: #ff8f00;
    }

    .status.shipped {
        background: #81d4fa;
        color: #01579b;
    }

    .status.delivered {
        background: #a5d6a7;
        color: #1b5e20;
    }

    .status.cancelled {
        background: #ef9a9a;
        color: #b71c1c;
    }

    .status.unknown {
        background: #e0e0e0;
        color: #616161;
    }

    .btn {
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        color: white;
        font-size: 0.9em;
        transition: all 0.3s ease;
        display: inline-block;
        margin-right: 5px;
    }

    .btn-cancel {
        background: linear-gradient(45deg, #ef5350, #d32f2f);
    }

    .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(239, 83, 80, 0.3);
    }

    .btn-delivered {
        background: linear-gradient(45deg, #66bb6a, #2e7d32);
    }

    .btn-delivered:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(102, 187, 106, 0.3);
    }

    .btn-back {
        background: linear-gradient(45deg, #757575, #424242);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(66, 66, 66, 0.3);
    }

    .back-button {
        text-align: center;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .orders-wrapper {
            padding: 20px 10px;
        }

        .container {
            margin: 0;
            padding: 10px;
        }

        table {
            display: block;
            overflow-x: auto;
        }

        th, td {
            min-width: 150px;
        }
    }
    </style>    
</body>
</html>