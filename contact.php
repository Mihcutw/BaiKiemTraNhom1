<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ </title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container custom-size">
        <h1>Liên hệ với chúng tôi </h1>

        <?php
        // Xử lý form khi người dùng gửi
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $subject = htmlspecialchars($_POST['subject']);
            $message = htmlspecialchars($_POST['message']);

            // Ở đây bạn có thể thêm logic để gửi email hoặc lưu vào cơ sở dữ liệu
            // Ví dụ: mail($to, $subject, $message, $headers);

            // Hiển thị thông báo thành công với class "success-message"
            echo '<p class="success-message">Tin nhắn đã được gửi thành công!</p>';
        }
        ?>

        <div class="contact-wrapper">
            <!-- Form Section -->
            <div class="form-section">
                <h2>Gửi tin nhắn cho chúng tôi</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <input type="text" name="name" placeholder="Họ và tên" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="subject" placeholder="Chủ đề" required>
                    <textarea name="message" placeholder="Nội dung tin nhắn" required></textarea>
                    <button type="submit">Gửi tin nhắn</button>
                </form>
            </div>
            <!-- Contact Info Section -->
            <div class="info-section">
                <h2>Liên hệ với chúng tôi</h2>
                <p>Chúng tôi luôn sẵn sàng lắng nghe ý kiến hoặc chỉ để trò chuyện</p>
                <ul>
                    <li>
                        <span class="icon">📍</span>
                        <span>Địa chỉ: 198 West 21th Street, Suite 721 New York NY 10016</span>
                    </li>
                    <li>
                        <span class="icon">📞</span>
                        <span>Điện thoại: +1235 2355 98</span>
                    </li>
                    <li>
                        <span class="icon">✉️</span>
                        <span>Email: info@yoursite.com</span>
                    </li>
                    <li>
                        <span class="icon">🌐</span>
                        <span>Website: yoursite.com</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>