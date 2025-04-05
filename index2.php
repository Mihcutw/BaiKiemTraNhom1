<?php
// Bắt đầu session
session_start();

// Kiểm tra nếu chưa đăng nhập thì chuyển hướng về index1.php
if (!isset($_SESSION['user'])) {
    header("Location: index1.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Đã Đăng Nhập</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="main-content">
        <!-- Tiêu đề chính -->
        <h1>Chào mừng bạn trở lại!</h1>
        <p>Khám phá thế giới của riêng bạn</p>

        <!-- Phần chào mừng cá nhân hóa -->
        <div class="user-welcome">
            <div class="user-info">
                <div class="user-avatar">
                    <!-- Placeholder cho ảnh đại diện, có thể thay bằng ảnh thật từ database -->
                    <img src="images/animegirl.gif" alt="Avatar">
                </div>
                <div class="user-details">
                    <h2>Xin chào, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
                    <p>Bạn đã đăng nhập thành công. Hãy bắt đầu hành trình của mình!</p>
                </div>
            </div>

            <!-- Các nút hành động -->
            <div class="cta-buttons">
                <a href="dashboard.php" class="cta-button dashboard-btn">Vào Dashboard</a>
                <a href="products.php" class="cta-button explore-btn">Khám Phá Sản Phẩm</a>
            </div>
        </div>

        <!-- Phần nội dung gợi ý -->
        <div class="suggestions">
            <h3>Gợi ý cho bạn</h3>
            <div class="suggestion-cards">
                <div class="card">
                    <h4>Cập nhật hồ sơ</h4>
                    <p>Hoàn thiện thông tin để cá nhân hóa trải nghiệm.</p>
                    <a href="profile.php" class="card-link">Cập nhật ngay</a>
                </div>
                <div class="card">
                    <h4>Sản phẩm mới</h4>
                    <p>Khám phá các sản phẩm hot nhất hôm nay.</p>
                    <a href="products.php" class="card-link">Xem ngay</a>
                </div>
                <div class="card">
                    <h4>Liên hệ hỗ trợ</h4>
                    <p>Có thắc mắc? Chúng tôi luôn sẵn sàng giúp bạn.</p>
                    <a href="contact.php" class="card-link">Liên hệ ngay</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>