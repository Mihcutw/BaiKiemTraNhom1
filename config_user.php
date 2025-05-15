<?php
// Chỉ gọi session_start() nếu chưa có session active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$username = "root"; // Thay bằng username MySQL của bạn
$password = ""; // Thay bằng password MySQL của bạn
$dbname = "user_management";

try {
    // Kết nối đến MySQL mà không chọn cơ sở dữ liệu
    $temp_conn = new PDO("mysql:host=$host", $username, $password);
    $temp_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Tạo cơ sở dữ liệu nếu chưa tồn tại
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    $temp_conn->exec($sql);
    
    // Chọn cơ sở dữ liệu
    $conn_user = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn_user->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn_user->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Tạo bảng users nếu chưa tồn tại
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        reset_password VARCHAR(255) DEFAULT NULL,
        avatar VARCHAR(255) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn_user->exec($sql);

    // Tạo bảng admins nếu chưa tồn tại
    $sql = "CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        reset_password VARCHAR(255) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn_user->exec($sql);

    // Thêm cột avatar nếu chưa tồn tại
    try {
        $sql = "ALTER TABLE users ADD COLUMN avatar VARCHAR(255) DEFAULT NULL";
        $conn_user->exec($sql);
    } catch (PDOException $e) {
        if ($e->getCode() != '42S21') { // Mã lỗi khi cột đã tồn tại
            die("Failed to add avatar column: " . $e->getMessage());
        }
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>