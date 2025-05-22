<?php
$page_title = "Liên Hệ";

include '../header.php';
?>

<div class="container custom-size">
    <h1>Liên Hệ</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $subject = htmlspecialchars($_POST['subject']);
        $message = htmlspecialchars($_POST['message']);
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
                    <span>Địa chỉ: SKIBIDI TOLET</span>
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


<style>
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background-color: #f5f5f5;
    }

    .container {
        max-width: 900px;
        width: 100%;
        margin: 0 auto; 
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center; 
    }

    .container h1 {
        font-size: 24px;
        color: white ;
        margin-bottom: 40px;
        text-transform: uppercase;
    }

    .contact-wrapper {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        width: 100%; 
    }

    .form-section {
        flex: 1;
        background: linear-gradient(135deg, #9c5ffd, #1de0ff);
        padding: 40px;
        border-radius: 10px;
        color: #fff;
        text-align: left;
    }

    .form-section h2 {
        font-size: 22px;
        margin-bottom: 20px;
    }

    .form-section form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .form-section input,
    .form-section textarea {
        padding: 12px;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        outline: none;
    }

    .form-section input::placeholder,
    .form-section textarea::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .form-section textarea {
        resize: none;
        height: 100px;
    }

    .form-section button {
        padding: 12px;
        background: linear-gradient(135deg, #841dff, #9c5ffd);
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .info-section {
        flex: 1;
        background-color: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        text-align: left;
    }

    .info-section h2 {
        font-size: 22px;
        color: #333;
        margin-bottom: 20px;
    }

    .info-section p {
        font-size: 14px;
        color: #666;
        margin-bottom: 20px;
    }

    .info-section ul {
        list-style: none;
    }

    .info-section ul li {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
        font-size: 14px;
        color: #333;
    }

    .info-section .icon {
        font-size: 20px;
    }

    .success-message {
        color: #28a745;
        font-size: 16px;
        margin-bottom: 20px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .contact-wrapper {
            flex-direction: column;
        }

        .form-section,
        .info-section {
            width: 100%;
        }
    }
</style>