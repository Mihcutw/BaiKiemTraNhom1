<?php
include '../../config/config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../../page/products/products.php');
    exit;
}

$id = $_GET['id'];
try {
    $stmt = $conn_store->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: ../../page/products/products.php');
    exit;
} catch (PDOException $e) {
    echo "Lỗi khi xóa sản phẩm: " . $e->getMessage();
    exit;
}
?>