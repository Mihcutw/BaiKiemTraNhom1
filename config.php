<?php
// Chỉ gọi session_start() nếu chưa có session active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$username = "root"; // Thay bằng username MySQL của bạn
$password = ""; // Thay bằng password MySQL của bạn
$dbname = "store_management";

try {
    // Kết nối đến MySQL mà không chọn cơ sở dữ liệu
    $temp_conn = new PDO("mysql:host=$host", $username, $password);
    $temp_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Tạo cơ sở dữ liệu nếu chưa tồn tại
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    $temp_conn->exec($sql);
    
    // Chọn cơ sở dữ liệu
    $conn_store = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn_store->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn_store->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Tạo bảng stores nếu chưa tồn tại
    $sql = "CREATE TABLE IF NOT EXISTS stores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        store_name VARCHAR(50) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        reset_password VARCHAR(255) DEFAULT NULL,
        logo VARCHAR(255) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn_store->exec($sql);

    // Tạo bảng products nếu chưa tồn tại
    $sql = "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        quantity INT NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn_store->exec($sql);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>