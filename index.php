<?php
// Bắt đầu session
session_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="main-content">
        <h1>Chào mừng đến với chúng tôi</h1>
        <p>Khám phá và trải nghiệm những điều mới mẻ!</p>
        <div class="cta-buttons">
            <a href="register.php" class="cta-button register-btn">Đăng Ký</a>
            <a href="login.php" class="cta-button login-btn">Đăng Nhập</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>