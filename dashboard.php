<?php
// Start session
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng về trang login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Kết nối database (thay đổi thông tin theo cấu hình của bạn)
$conn = mysqli_connect("localhost", "username", "password", "database_name");

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Lấy dữ liệu tổng quan
$product_query = "SELECT COUNT(*) as total FROM products";
$product_result = mysqli_query($conn, $product_query);
$product_count = mysqli_fetch_assoc($product_result)['total'];

$user_query = "SELECT COUNT(*) as total FROM users";
$user_result = mysqli_query($conn, $user_query);
$user_count = mysqli_fetch_assoc($user_result)['total'];

$order_query = "SELECT COUNT(*) as total FROM orders";
$order_result = mysqli_query($conn, $order_query);
$order_count = mysqli_fetch_assoc($order_result)['total'];

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-box {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            flex: 1;
            text-align: center;
        }
        .stat-box h3 {
            margin: 0 0 10px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <p>Xin chào, <?php echo $_SESSION['username']; ?> | <a href="logout.php">Đăng xuất</a></p>

        <!-- Hiển thị số liệu tổng quan -->
        <div class="stats">
            <div class="stat-box">
                <h3>Sản phẩm</h3>
                <p><?php echo $product_count; ?></p>
            </div>
            <div class="stat-box">
                <h3>Người dùng</h3>
                <p><?php echo $user_count; ?></p>
            </div>
            <div class="stat-box">
                <h3>Đơn hàng</h3>
                <p><?php echo $order_count; ?></p>
            </div>
        </div>

        <!-- Nút chuyển hướng -->
        <a href="product_list.php" class="btn">Xem Danh Sách Sản Phẩm</a>

        <!-- Phần tùy chỉnh (có thể thêm widget hoặc chức năng khác) -->
        <div class="custom-section">
            <h2>Tùy chỉnh Dashboard</h2>
            <p>Thêm các widget hoặc thông tin bạn muốn hiển thị tại đây</p>
        </div>
    </div>

    <?php
    // Đóng kết nối
    mysqli_close($conn);
    ?>
</body>
</html>