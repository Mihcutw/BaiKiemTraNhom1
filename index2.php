<?php
// Bắt đầu session
session_start();

// Kết nối cơ sở dữ liệu
require_once 'config_user.php';

// Kiểm tra nếu không có session user_id hoặc admin_id thì chuyển hướng về login.php
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Đảm bảo $conn_user tồn tại
if (!isset($conn_user)) {
    die("Lỗi: Không thể kết nối đến cơ sở dữ liệu user_management.");
}

// Lấy username và avatar từ database
try {
    if (isset($_SESSION['admin_id'])) {
        // Nếu là admin, lấy thông tin từ bảng admins
        $stmt = $conn_user->prepare("SELECT username FROM admins WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $admin = $stmt->fetch();
        
        if ($admin) {
            $username = $admin['username'];
            // Avatar cố định mới cho admin
            $avatar = 'https://cdn.hero.page/pfp/92a703ca-3ad4-48ef-8883-a37dd918b569-silhouetted-anime-character-anime-pfp-dark-featuring-male-characters-3.png'; // Thay URL này bằng URL avatar mới bạn muốn
        } else {
            // Nếu không tìm thấy admin, hủy session và chuyển hướng
            session_destroy();
            header("Location: login.php");
            exit();
        }
    } else {
        // Nếu là user, lấy thông tin từ bảng users
        $stmt = $conn_user->prepare("SELECT username, avatar FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        
        if ($user) {
            $username = $user['username'];
            // Nếu avatar không tồn tại hoặc rỗng, sử dụng avatar mặc định
            $avatar = !empty($user['avatar']) ? htmlspecialchars($user['avatar']) : 'https://i.pinimg.com/originals/b2/ea/a0/b2eaa0d4918d54021f9c7aa3fc3d3cf3.jpg';
        } else {
            // Nếu không tìm thấy user, hủy session và chuyển hướng
            session_destroy();
            header("Location: login.php");
            exit();
        }
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
                <!-- Hiển thị avatar từ database hoặc avatar mặc định -->
                <img src="<?php echo $avatar; ?>" alt="Avatar">
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