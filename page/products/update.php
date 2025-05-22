<?php
include '../../config/config.php';

try {
    // Xử lý xóa sản phẩm
    if (isset($_GET['delete_id'])) {
        $delete_id = (int)$_GET['delete_id'];

        // Xóa các bản ghi liên quan trong bảng cart trước
        $stmt_cart = $conn_store->prepare('DELETE FROM cart WHERE product_id = ?');
        $stmt_cart->execute([$delete_id]);

        // Xóa sản phẩm từ bảng products
        $stmt_products = $conn_store->prepare('DELETE FROM products WHERE id = ?');
        $stmt_products->execute([$delete_id]);

        // Làm mới trang sau khi xóa
        header("Location: ../../page/products/update.php");
        exit;
    }

    // Lấy dữ liệu từ bảng products
    $stmt = $conn_store->query('SELECT * FROM products');
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Lỗi truy vấn: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Sản Phẩm</title>
</head>
<body>
<div class="update-product-wrapper">
    <div class="update-product-container">
        <h2>Cập Nhật Sản Phẩm</h2>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>ID</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Mô tả</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <?php if ($product['image'] && file_exists($product['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-width: 50px; max-height: 50px;">
                                <?php else: ?>
                                    <span>Không có ảnh</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo number_format($product['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                            <td><?php echo $product['quantity']; ?></td>
                            <td><?php echo htmlspecialchars($product['description'] ?? 'Không có mô tả'); ?></td>
                            <td>
                                <a href="../../page/products/edit.php?id=<?php echo $product['id']; ?>" class="btn btn-edit">Chọn</a>
                                <a href="../../page/products/update.php?delete_id=<?php echo $product['id']; ?>" 
                                   class="btn btn-delete" 
                                   onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="7" class="empty-message">Hiện chưa có sản phẩm nào để cập nhật</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="back-link">
            <a href="../../page/admin/admin.php">Quay lại danh sách</a>
        </div>
    </div>
</div>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Roboto', sans-serif;
}

body {
    background-image: url(../../images/123.jpg);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 100vh;
}

.update-product-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

.update-product-container {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(5px);
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(147, 112, 219, 0.3);
    width: 100%;
    max-width: 1200px;
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
    color: #9c5ffd;
    text-align: center;
    margin-bottom: 2rem;
    font-size: 1.8rem;
    font-weight: 500;
}

.table-wrapper {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(5px);
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 18px 20px;
    text-align: left;
    transition: all 0.3s ease;
}

th {
    background: linear-gradient(45deg, #9c5ffd, #1de0ff);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

tbody tr {
    transition: all 0.3s ease;
}

tbody tr:hover {
    background: rgba(156, 95, 253, 0.1);
    transform: scale(1.01);
}

.btn {
    padding: 8px 18px;
    margin: 0 5px;
    border-radius: 25px;
    color: white;
    font-size: 0.9em;
    text-decoration: none;
}

.btn-edit {
    background: linear-gradient(45deg, #3498db, #2980b9);
}

.btn-edit:hover {
    background: linear-gradient(45deg, #2980b9, #3498db);
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(52, 152, 219, 0.3);
}

.btn-delete {
    background: linear-gradient(45deg, #e74c3c, #c0392b);
}

.btn-delete:hover {
    background: linear-gradient(45deg, #c0392b, #e74c3c);
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(231, 76, 60, 0.3);
}

.empty-message {
    text-align: center;
    padding: 40px;
    color: #7f8c8d;
    font-style: italic;
}

.back-link {
    text-align: center;
    margin-top: 1.5rem;
}

.back-link a {
    color: #9c5ffd;
    text-decoration: none;
    font-size: 1rem;
    transition: color 0.3s ease;
}

.back-link a:hover {
    color: #1de0ff;
    text-decoration: underline;
}

@media (max-width: 768px) {
    .update-product-container {
        padding: 1.5rem;
        max-width: 100%;
    }

    table {
        display: block;
        overflow-x: auto;
    }

    th, td {
        min-width: 150px;
    }
}
</style>
</body>
</html>