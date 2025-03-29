<?php
session_start();
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (strlen($password) < 6) {
        echo "<script>alert('Mật khẩu phải có 6 chữ!');</script>";
    } elseif ($password === $confirm_password) {
        setcookie("user_email", $email, time() + (86400 * 30), "/"); 
        setcookie("user_password", $password, time() + (86400 * 30), "/");

        echo "<script>alert('Đăng ký thành công!');</script>";
        header("Location: login.php");
        exit();
    } else {
        echo "<script>alert('Mật khẩu không giống nhau!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(images/123.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(147, 112, 219, 0.1);
            border: 2px solid transparent;
            background: linear-gradient(#fff, #fff) padding-box,
                          linear-gradient(90deg, #00eaff, #ff007a) border-box;
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
            background: linear-gradient(90deg, #3915bb, #b424b4);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            color: #4682b4;
            margin-bottom: 0.5rem;
        }
        input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #b0c4de;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(90deg, #9370db, #4682b4);
            color: white;
            font-weight: bold;
            margin-top: 1rem;
        }
        button:hover {
            background: linear-gradient(90deg, #7b68ee, #87ceeb);
            box-shadow: 0 2px 10px rgba(70, 130, 180, 0.5);
        }
        .links {
            text-align: center;
            margin-top: 1rem;
        }
        .links a {
            color: #9370db;
            text-decoration: none;
            margin: 0 10px;
        }
        .links a:hover {
            color: #4682b4;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Đăng Ký</h2>
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="username">Tên người dùng</label>
                <input type="text" id="username" name="username" placeholder="Họ và Tên" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Xác nhận mật khẩu</label>
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
            </div>
            <button type="submit">Đăng Ký</button>
        </form>
        <div class="links">
            <a href="login.php">Đăng nhập</a>
            <a href="reset-password.php">Reset Mật Khẩu</a>
        </div>
    </div>
</body>
</html>