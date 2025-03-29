<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <?php
    // Bắt đầu session
    session_start();
    ?>
    <header>
        <div class="logo-container">
            <div class="logo">
                <img src="./images/tientu.png" alt="Logo">
            </div>
            <div class="web-title">
                <h1>Tên Website</h1>
                <span class="intro-text">Khám phá trải nghiệm mới</span>
            </div>
        </div>
        <input type="checkbox" id="nav-toggle" class="nav-toggle">
        <label for="nav-toggle" class="nav-toggle-label"><span></span></label>
        <nav>
            <ul>
                <li><a href="index.php">Trang Chủ</a></li>
                <li><a href="gioithieu.php">Giới Thiệu</a></li>
                <li><a href="contact.php">Liên Hệ</a></li>
                <li><a href="products.php">Cửa Hàng</a></li>
                <?php
                // Kiểm tra nếu người dùng đã đăng nhập
                if (isset($_SESSION['user'])) {
                    echo '<li><a href="logout.php">Đăng Xuất</a></li>';
                } else {
                    echo '<li><a href="login.php">Đăng Nhập</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>
</body>
</html>