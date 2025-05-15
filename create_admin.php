<?php
include 'config_user.php'; // Kết nối database user_management

// Dữ liệu admin
$username = "admin";
$email = "admin@gmail.com";
$full_name = "Admin User";
$password = password_hash("111111", PASSWORD_DEFAULT); // Mã hóa mật khẩu

try {
    // Thêm tài khoản admin vào bảng
    $sql = "INSERT INTO admins (username, email, full_name, password) VALUES (:username, :email, :full_name, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':full_name' => $full_name,
        ':password' => $password
    ]);
    echo "Tài khoản admin đã được tạo thành công!";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>