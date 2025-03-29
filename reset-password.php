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
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>Đặt Lại Mật Khẩu</h2>
        <form>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Nhập email của bạn" required>
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