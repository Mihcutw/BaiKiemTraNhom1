<?php
// Bao gồm tệp config với đường dẫn chính xác
include '../../config/config.php';

// Chỉ gọi session_start() nếu chưa có session active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    // Lấy hoặc gán user_id từ session
    $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
    if ($user_id === 0) {
        header("Location: ../../page/user/login.php");
        exit;
    }

    // Khởi tạo biến thông báo
    $message = '';

    // Xử lý thêm sản phẩm vào giỏ hàng
    if (isset($_GET['add_to_cart'])) {
        $product_id = (int)$_GET['add_to_cart'];

        // Kiểm tra số lượng tồn kho trong bảng products
        $stmt = $conn_store->prepare('SELECT quantity FROM products WHERE id = ?');
        $stmt->execute([$product_id]);
        $stock_quantity = $stmt->fetchColumn();

        if ($stock_quantity === false) {
            $message = "Sản phẩm không tồn tại!";
        } elseif ($stock_quantity <= 0) {
            $message = "Sản phẩm đã hết hàng!";
        } else {
            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $stmt = $conn_store->prepare('SELECT * FROM cart WHERE user_id = ? AND product_id = ?');
            $stmt->execute([$user_id, $product_id]);
            $cart_item = $stmt->fetch();

            if ($cart_item) {
                // Nếu sản phẩm đã có trong giỏ, cộng dồn số lượng hiện tại trong cart với số lượng tồn kho hiện tại
                $new_quantity = $cart_item['quantity'] + $stock_quantity;
                $stmt = $conn_store->prepare('UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?');
                $stmt->execute([$new_quantity, $user_id, $product_id]);
                $message = "Đã thêm sản phẩm vào giỏ hàng, số lượng hiện tại: $new_quantity!";
            } else {
                // Thêm mới vào giỏ với số lượng bằng số lượng tồn kho hiện tại
                $stmt = $conn_store->prepare('INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)');
                $stmt->execute([$user_id, $product_id, $stock_quantity]);
                $message = "Đã thêm sản phẩm vào giỏ hàng với số lượng $stock_quantity!";
            }
        }

        // Lưu thông báo vào session để hiển thị sau khi làm mới trang
        $_SESSION['message'] = $message;
        // Làm mới trang products.php
        header("Location: /minh/page/products/products.php");
        exit;
    }

    // Xử lý tăng số lượng sản phẩm
    if (isset($_GET['increment_id'])) {
        $increment_id = (int)$_GET['increment_id'];
        // Cập nhật số lượng trong bảng products (tăng lên 1)
        $stmt = $conn_store->prepare('UPDATE products SET quantity = quantity + 1 WHERE id = ?');
        $stmt->execute([$increment_id]);
        $_SESSION['message'] = "Đã tăng số lượng sản phẩm!";

        // Không cập nhật số lượng trong cart, giữ nguyên
        // Làm mới trang sau khi cập nhật
        header("Location: /minh/page/products/products.php");
        exit;
    }

    // Xử lý giảm số lượng sản phẩm
    if (isset($_GET['decrement_id'])) {
        $decrement_id = (int)$_GET['decrement_id'];
        // Lấy số lượng hiện tại
        $stmt = $conn_store->prepare('SELECT quantity FROM products WHERE id = ?');
        $stmt->execute([$decrement_id]);
        $current_quantity = $stmt->fetchColumn();

        if ($current_quantity > 0) {
            // Cập nhật số lượng trong bảng products (giảm đi 1)
            $stmt = $conn_store->prepare('UPDATE products SET quantity = quantity - 1 WHERE id = ?');
            $stmt->execute([$decrement_id]);
            $_SESSION['message'] = "Đã giảm số lượng sản phẩm!";
        } else {
            $_SESSION['message'] = "Số lượng sản phẩm đã là 0, không thể giảm thêm!";
        }

        // Không cập nhật số lượng trong cart, giữ nguyên
        // Làm mới trang sau khi cập nhật
        header("Location: /minh/page/products/products.php");
        exit;
    }

    // Lấy dữ liệu từ bảng products
    $stmt = $conn_store->query('SELECT * FROM products');
    $products = $stmt->fetchAll();

    // Hiển thị thông báo nếu có
    $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
    unset($_SESSION['message']); // Xóa thông báo sau khi hiển thị

} catch (PDOException $e) {
    echo "Lỗi truy vấn: " . $e->getMessage();
    exit;
}
?>

<?php include '../../page/header.php'; ?>

<div class="products-wrapper">
    <div class="container animate-in">
        <h1>Danh Sách Sản Phẩm</h1>

        <!-- Hiển thị thông báo -->
        <?php if (!empty($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

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
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                                <?php else: ?>
                                    <span>Không có ảnh</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td class="price"><?php echo number_format($product['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                            <td>
                                <div class="quantity-wrapper">
                                    <span><?php echo $product['quantity']; ?></span>
                                    <a href="?decrement_id=<?php echo $product['id']; ?>" 
                                       class="btn btn-decrement">−</a>
                                    <a href="?increment_id=<?php echo $product['id']; ?>" 
                                       class="btn btn-increment">+</a>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($product['description'] ?? 'Không có mô tả'); ?></td>
                            <td>
                                <a href="?add_to_cart=<?php echo $product['id']; ?>" 
                                   class="btn btn-cart">Thêm vào giỏ hàng</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="7" class="empty-message">Hiện chưa có sản phẩm nào trong danh sách</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Reset mặc định */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Roboto', sans-serif; /* Sử dụng font Roboto */
}

/* Thêm ảnh nền và lớp phủ mờ */
body {
    background-image: url(../../images/123.jpg); /* Sử dụng ảnh nền tương tự manage_users.php */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    margin: 0;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    position: relative;
}

body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3); /* Lớp phủ mờ */
    z-index: 0;
}

/* Wrapper cho toàn bộ trang */
.products-wrapper {
    min-height: 100vh;
    padding: 40px 20px;
    position: relative;
    z-index: 1;
}

/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    position: relative;
    z-index: 1;
}

/* Hiệu ứng animate-in */
.animate-in {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.6s ease-in-out forwards;
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Tiêu đề */
h1 {
    color: #fff; /* Màu trắng để nổi bật trên gradient */
    margin-bottom: 30px;
    text-align: center;
    font-size: 2.5em;
    font-weight: 500;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
}

/* Thông báo */
.message {
    background: #d4edda;
    color: #155724;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    text-align: center;
}

.message.error {
    background: #ffdddd;
    color: #d8000c;
}

/* Action buttons */
.action-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 30px;
}

/* Nút chung */
.btn {
    display: inline-flex;
    align-items: center;
    padding: 12px 25px;
    text-decoration: none;
    border-radius: 50px;
    transition: all 0.3s ease;
    font-weight: 500;
    color: white;
}

/* Nút Thêm Sản Phẩm */
.btn-add {
    background: linear-gradient(45deg, #00c853, #00e676);
    box-shadow: 0 4px 15px rgba(0, 200, 83, 0.3);
}

.btn-add:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 200, 83, 0.4);
    background: linear-gradient(45deg, #00e676, #00c853);
}

/* Nút Cập nhật Sản Phẩm */
.btn-update {
    background: linear-gradient(45deg, #ff9800, #ffb300);
    box-shadow: 0 4px 15px rgba(255, 152, 0, 0.3);
}

.btn-update:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(255, 152, 0, 0.4);
    background: linear-gradient(45deg, #ffb300, #ff9800);
}

/* Nút Giỏ Hàng */
.btn-cart {
    background: linear-gradient(45deg, #2ecc71, #27ae60);
    box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
    padding: 8px 18px;
    margin: 0 5px;
    border-radius: 25px;
    color: white;
    font-size: 0.9em;
}

.btn-cart:hover {
    background: linear-gradient(45deg, #27ae60, #2ecc71);
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(46, 204, 113, 0.3);
}

/* Nút Tăng Số Lượng */
.btn-increment {
    background: linear-gradient(45deg, #00e676, #00c853);
    box-shadow: 0 4px 15px rgba(0, 200, 83, 0.3);
    padding: 4px 10px;
    margin-left: 10px;
    border-radius: 15px;
    color: white;
    font-size: 0.8em;
    text-decoration: none;
}

.btn-increment:hover {
    background: linear-gradient(45deg, #00c853, #00e676);
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(0, 200, 83, 0.3);
}

/* Nút Giảm Số Lượng */
.btn-decrement {
    background: linear-gradient(45deg, #ff9800, #ffb300);
    box-shadow: 0 4px 15px rgba(255, 152, 0, 0.3);
    padding: 4px 10px;
    margin-left: 10px;
    border-radius: 15px;
    color: white;
    font-size: 0.8em;
    text-decoration: none;
}

.btn-decrement:hover {
    background: linear-gradient(45deg, #ffb300, #ff9800);
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(255, 152, 0, 0.3);
}

/* Wrapper cho cột Số lượng */
.quantity-wrapper {
    display: flex;
    align-items: center;
}

/* Table wrapper */
.table-wrapper {
    background: rgba(255, 255, 255, 0.9); /* Nền trắng trong suốt */
    backdrop-filter: blur(5px); /* Hiệu ứng mờ nền */
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

/* Table */
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
    background: linear-gradient(45deg, #9c5ffd, #1de0ff); /* Gradient tím-xanh lam */
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

tbody tr {
    transition: all 0.3s ease;
}

tbody tr:hover {
    background: rgba(156, 95, 253, 0.1); /* Nền tím nhạt khi hover */
    transform: scale(1.01);
}

.price {
    color: #ff4081; /* Màu hồng để nổi bật */
    font-weight: 500;
}

/* Cải thiện hiển thị ảnh sản phẩm (đồng bộ với cart.php) */
.product-image {
    max-width: 80px; /* Tăng kích thước ảnh */
    max-height: 80px;
    border-radius: 5px;
    border: 2px solid #ddd;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-image:hover {
    transform: scale(1.1); /* Phóng to ảnh khi hover */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Thông báo trống */
.empty-message {
    text-align: center;
    padding: 40px;
    color: #7f8c8d;
    font-style: italic;
}

/* Responsive */
@media (max-width: 768px) {
    .products-wrapper {
        padding: 20px 10px;
    }

    .container {
        margin: 0;
        padding: 10px;
    }

    .action-buttons {
        flex-direction: column;
        gap: 10px;
    }

    .btn-add, .btn-update {
        width: 100%;
        text-align: center;
    }

    table {
        display: block;
        overflow-x: auto;
    }

    th, td {
        min-width: 150px;
    }

    .product-image {
        max-width: 60px; /* Giảm kích thước ảnh trên mobile */
        max-height: 60px;
    }
}
</style>