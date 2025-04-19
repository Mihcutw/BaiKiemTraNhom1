<?php
// Bắt đầu session
session_start();

// Kết nối cơ sở dữ liệu
require_once 'config.php';

// Kiểm tra nếu không có session user_id thì chuyển hướng về login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Lấy username từ database
try {
    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    if ($user) {
        $username = $user['username'];
    } else {
        // Nếu không tìm thấy user, hủy session và chuyển hướng
        session_destroy();
        header("Location: login.php");
        exit();
    }
} catch (PDOException $e) {
    // Xử lý lỗi cơ sở dữ liệu
    die("Database error: " . $e->getMessage());
}
?>

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
                <img src="https://media3.giphy.com/media/v1.Y2lkPTc5MGI3NjExY2twdjVmY2h0OGw3d2trMGNmbmRxcmhqb2djYjYwMGQ0em5sMjFlNiZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/a6pzK009rlCak/giphy.gif" alt="Avatar">
            </div>
            <div class="user-details">
                <h2>Xin chào, <?php echo htmlspecialchars($username); ?>!</h2>
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