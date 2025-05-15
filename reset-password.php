<?php
require_once 'config_user.php';

$errors = [];
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST["email"] ?? ""));
    $new_password = $_POST["new-password"] ?? "";
    $confirm_password = $_POST["confirm-password"] ?? "";

    // Validate dữ liệu
    if (!$email) $errors["email"] = "Vui lòng nhập email.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors["email"] = "Email không hợp lệ.";
    if (!$new_password) $errors["password"] = "Vui lòng nhập mật khẩu mới.";
    elseif (strlen($new_password) < 6) $errors["password"] = "Mật khẩu mới phải có ít nhất 6 ký tự.";
    if ($new_password !== $confirm_password) $errors["confirm_password"] = "Mật khẩu xác nhận không khớp.";

    if (!$errors) {
        // Kiểm tra email có tồn tại không
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Cập nhật mật khẩu mới
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ?, reset_password = NULL WHERE email = ?");
            if ($stmt->execute([$hashed_password, $email])) {
                $success = "Mật khẩu đã được đặt lại thành công! Vui lòng đăng nhập.";
                header("Refresh: 2; url=login.php");
            } else {
                $errors["database"] = "Đã có lỗi xảy ra. Vui lòng thử lại.";
            }
        } else {
            $errors["email"] = "Email không tồn tại.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Lại Mật Khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(images/pngtree-colorful-blue-purple-gradient-technology-future-sense-streamer-flashing-e-commerce-picture-image_1621913.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .reset-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(147, 112, 219, 0.1);
            border: 1px solid #d8bfd8;
            width: 100%;
            max-width: 400px;
            animation: fadeInDown 0.6s ease-in-out;
        }
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        h2 {
            color: #9370db;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            color: #9370db;
            margin-bottom: 0.5rem;
        }
        input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #d8bfd8;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 0.8rem;
            background-color: #9370db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #7b68ee;
        }
        .back-link {
            text-align: center;
            margin-top: 1rem;
        }
        .back-link a {
            color: #9370db;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        .error-messages { color: red; font-weight: bold; text-align: center; margin-bottom: 1rem; }
        .error { background-color: #ffdddd; padding: 10px; border-radius: 5px; }
        .success-message { color: green; font-weight: bold; text-align: center; margin-bottom: 1rem; }
        .success { background-color: #ddffdd; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>Đặt Lại Mật Khẩu</h2>
        <?php if (!empty($errors)) : ?>
            <div class="error-messages">
                <?php foreach ($errors as $error) : ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($success)) : ?>
            <div class="success-message">
                <p class="success"><?php echo $success; ?></p>
            </div>
        <?php endif; ?>
        <form method="POST" action="reset-password.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Nhập email của bạn" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="new-password">Mật khẩu mới</label>
                <input type="password" id="new-password" name="new-password" placeholder="Nhập mật khẩu mới" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Xác nhận mật khẩu</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Xác nhận mật khẩu" required>
            </div>
            <button type="submit">Đặt Lại Mật Khẩu</button>
        </form>
        <div class="back-link">
            <a href="login.php">Quay lại đăng nhập</a>
        </div>
    </div>
</body>
</html>