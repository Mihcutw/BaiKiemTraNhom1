<?php
require_once 'config_user.php';

$page_title = "Đăng Nhập";
include 'header.php';

$errors = [];

// Chỉ chuyển hướng nếu đã đăng nhập và truy cập trang login.php
if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
    if (basename($_SERVER['PHP_SELF']) == 'login.php') {
        header("Location: index2.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_input = htmlspecialchars(trim($_POST["email"] ?? "")); // Sử dụng "email" input để nhập username hoặc email
    $password = $_POST["password"] ?? "";

    if (!$login_input) $errors["login_input"] = "Vui lòng nhập username hoặc email.";
    if (!$password) $errors["password"] = "Vui lòng nhập mật khẩu.";

    if (!$errors) {
        // Kiểm tra trường hợp đặc biệt: nếu login_input là "admin", sử dụng username để đăng nhập admin
        if (strtolower($login_input) === "admin") {
            $stmt = $conn_user->prepare("SELECT id, username, password, email FROM admins WHERE username = ? LIMIT 1");
            $stmt->execute([$login_input]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['username'] = $admin['username'];
                $_SESSION['email'] = $admin['email']; // Đã thêm cột email vào truy vấn
                $_SESSION['is_admin'] = true;
                $_SESSION['last_activity'] = time(); // Khởi tạo thời gian hoạt động
                // Bỏ cập nhật last_login vì cột này chưa tồn tại
                header("Location: index2.php");
                exit();
            } else {
                $errors["login"] = "Sai username hoặc mật khẩu!";
            }
        } else {
            // Nếu không phải "admin", kiểm tra email cho cả admin và user
            // Kiểm tra admin trước
            $stmt = $conn_user->prepare("SELECT id, username, password, email FROM admins WHERE email = ? LIMIT 1");
            $stmt->execute([$login_input]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['username'] = $admin['username'];
                $_SESSION['email'] = $admin['email'];
                $_SESSION['is_admin'] = true;
                $_SESSION['last_activity'] = time(); // Khởi tạo thời gian hoạt động
                // Bỏ cập nhật last_login vì cột này chưa tồn tại
                header("Location: index2.php");
                exit();
            } else {
                // Kiểm tra user
                $stmt = $conn_user->prepare("SELECT id, username, password, email FROM users WHERE email = ? LIMIT 1");
                $stmt->execute([$login_input]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['is_user'] = true;
                    $_SESSION['last_activity'] = time(); // Khởi tạo thời gian hoạt động
                    header("Location: index2.php");
                    exit();
                } else {
                    $errors["login"] = "Sai email hoặc mật khẩu!";
                }
            }
        }
    }
}
?>

<div class="login-wrapper">
    <div class="login-container">
        <h2>Đăng Nhập</h2>
        <?php if (!empty($errors)) : ?>
            <div class="error-messages">
                <?php foreach ($errors as $error) : ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="email">Username hoặc Email</label>
                <input type="text" id="email" name="email" placeholder="Nhập username hoặc email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
            <button type="submit">Đăng Nhập</button>
        </form>
        <div class="links">
            <a href="register.php">Đăng Ký</a>
            <a href="reset-password.php">Reset Mật Khẩu</a>
        </div>
    </div>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        background-image: url(images/123.jpg);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        margin: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .login-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding-bottom: 60px;
    }
    .login-container {
        background-color: #fff;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(147, 112, 219, 0.1);
        border: 2px solid transparent;
        background: linear-gradient(#fff, #fff) padding-box, linear-gradient(90deg, #00eaff, #ff007a) border-box;
        width: 100%;
        max-width: 400px;
        animation: fadeInDown 0.6s ease-in-out;
    }
    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    h2 {
        background: linear-gradient(90deg, #3915bb, #b424b4);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .form-group { margin-bottom: 1rem; }
    label { display: block; color: #4682b4; margin-bottom: 0.5rem; }
    input { width: 100%; padding: 0.8rem; border: 1px solid #b0c4de; border-radius: 5px; box-sizing: border-box; }
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
    .links { text-align: center; margin-top: 1rem; }
    .links a { color: #9370db; text-decoration: none; margin: 0 10px; }
    .links a:hover { color: #4682b4; text-decoration: underline; }
    .error-messages { color: red; font-weight: bold; text-align: center; margin-bottom: 1rem; }
    .error { background-color: #ffdddd; padding: 10px; border-radius: 5px; }
</style>

<?php include 'footer.php'; ?>