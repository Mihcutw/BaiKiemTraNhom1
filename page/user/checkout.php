<?php
// Bật hiển thị lỗi để debug (trừ Notice để tránh thông báo không cần thiết)
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

include '../../config/config.php';

// Chỉ gọi session_start() nếu chưa có session active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../page/user/login.php");
    exit();
}

try {
    // Kiểm tra kết nối cơ sở dữ liệu
    if (!$conn_store) {
        throw new Exception("Không thể kết nối đến cơ sở dữ liệu!");
    }

    // Lấy hoặc gán user_id
    $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

    // Khởi tạo biến
    $message = '';
    $full_name = '';
    $phone = '';
    $email = '';
    $address = '';
    $additional_info = '';
    $phone_error = '';

    // Xử lý xác nhận thanh toán
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
        // Lấy thông tin từ form
        $full_name = htmlspecialchars(trim($_POST['full_name'] ?? ''));
        $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
        $email = htmlspecialchars(trim($_POST['email'] ?? ''));
        $address = htmlspecialchars(trim($_POST['address'] ?? ''));
        $additional_info = htmlspecialchars(trim($_POST['additional_info'] ?? ''));

        // Validate
        $errors = [];
        if (!$full_name) $errors[] = "Vui lòng nhập họ và tên.";
        if (!$phone || !preg_match('/^[0-9]{10}$/', $phone)) {
            $phone_error = "Số điện thoại không hợp lệ (phải là 10 chữ số).";
            $phone = ''; // Xóa số điện thoại không hợp lệ
        }
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email không hợp lệ.";
        if (!$address) $errors[] = "Vui lòng nhập địa chỉ.";

        if (empty($errors) && empty($phone_error)) {
            // Lấy danh sách sản phẩm trong giỏ hàng
            $stmt = $conn_store->prepare('
                SELECT c.id, c.product_id, c.quantity, p.name, p.price, p.image
                FROM cart c
                JOIN products p ON c.product_id = p.id
                WHERE c.user_id = ?
            ');
            $stmt->execute([$user_id]);
            $cart_items = $stmt->fetchAll();

            if (!empty($cart_items)) {
                // Tính tổng tiền
                $total = 0;
                foreach ($cart_items as $item) {
                    $total += $item['price'] * $item['quantity'];
                }

                // Thêm đơn hàng vào bảng orders
                $stmt = $conn_store->prepare('INSERT INTO orders (user_id, total, full_name, phone, email, address, additional_info) VALUES (?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([$user_id, $total, $full_name, $phone, $email, $address, $additional_info]);
                $order_id = $conn_store->lastInsertId();

                // Thêm chi tiết đơn hàng vào bảng order_items
                $stmt = $conn_store->prepare('
                    INSERT INTO order_items (order_id, product_id, quantity, price)
                    VALUES (?, ?, ?, ?)
                ');
                foreach ($cart_items as $item) {
                    $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
                }

                // Xóa giỏ hàng
                $stmt = $conn_store->prepare('DELETE FROM cart WHERE user_id = ?');
                $stmt->execute([$user_id]);

                $message = "Thanh toán thành công! Cảm ơn bạn đã mua hàng.";
            } else {
                $message = "Giỏ hàng trống, không thể thanh toán!";
            }
        } else {
            if (!empty($errors)) {
                $message = implode("<br>", $errors);
            }
        }
    }

    // Lấy danh sách sản phẩm trong giỏ hàng để hiển thị
    $stmt = $conn_store->prepare('
        SELECT c.id, c.product_id, c.quantity, p.name, p.price, p.image
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
    ');
    $stmt->execute([$user_id]);
    $cart_items = $stmt->fetchAll();

} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
    exit;
}
?>

<?php include '../../page/header.php'; ?>

<div class="checkout-wrapper">
    <div class="checkout-container">
        <h2>THANH TOÁN</h2>

        <?php if (!empty($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <?php if (empty($message)): ?>
            <div class="payment-section">
                <h3>THÔNG TIN THANH TOÁN</h3>
                <?php if (!empty($phone_error)): ?>
                    <div class="error-message"><?php echo htmlspecialchars($phone_error); ?></div>
                <?php endif; ?>
                <form method="POST" action="checkout.php?confirm=true">
                    <div class="form-group">
                        <label for="full_name">Họ và tên *</label>
                        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required style="<?php echo !$full_name && isset($_GET['confirm']) ? 'border: 2px solid red;' : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại *</label>
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email (tùy chọn)</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" style="<?php echo !$email && isset($_GET['confirm']) ? 'border: 2px solid red;' : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ *</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required style="<?php echo !$address && isset($_GET['confirm']) ? 'border: 2px solid red;' : ''; ?>">
                    </div>
            </div>

            <div class="additional-section">
                <h3>THÔNG TIN BỔ SUNG</h3>
                <div class="form-group">
                    <label for="additional_info">Ghi chú cho người giao hàng (tùy chọn)</label>
                    <textarea id="additional_info" name="additional_info" rows="3" style="width: 100%; padding: 0.8rem; border: 1px solid #b0c4de; border-radius: 5px; box-sizing: border-box;"><?php echo htmlspecialchars($additional_info); ?></textarea>
                </div>
            </div>

            <div class="order-section">
                <h3>ĐƠN HÀNG CỦA BẠN</h3>
                <div class="order-details">
                    <p><strong>Sản phẩm</strong></p>
                    <div style="width: 100%; background-color: red; height: 20px;"></div>
                    <p><strong>Thành tiền</strong> <span class="total-price"><?php
                        $total = 0;
                        foreach ($cart_items as $item) {
                            $total += $item['price'] * $item['quantity'];
                        }
                        echo number_format($total, 0, ',', '.') . ' đ';
                    ?></span></p>
                </div>
                <button type="submit" class="place-order-btn">ĐẶT HÀNG</button>
                </form>
            </div>

            <div class="info-section">
                <h3>TÀM TÍNH</h3>
                <p>✔ Chuyển khoản ngân hàng: Bạn sẽ nhận được thông tin thanh toán qua email hoặc số điện thoại sau khi đặt hàng thành công.</p>
                <p>✔ Vui lòng kiểm tra kỹ thông tin trước khi đặt hàng.</p>
                <p>✔ Đơn hàng sẽ được giao sau khi xác nhận thanh toán từ ngân hàng.</p>
            </div>
        <?php else: ?>
            <div class="success-message">
                <p>Đơn hàng của bạn đã được xử lý. Bạn có thể quay lại <a href="../../page/products/products.php">Danh sách sản phẩm</a> để tiếp tục mua sắm.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
body {
    font-family: Arial, sans-serif;
    background-image: url(../../images/123.jpg);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    margin: 0;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.checkout-wrapper {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding-bottom: 60px;
}

.checkout-container {
    background-color: #fff;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(147, 112, 219, 0.1);
    border: 2px solid transparent;
    background: linear-gradient(#fff, #fff) padding-box, linear-gradient(90deg, #00eaff, #ff007a) border-box;
    width: 100%;
    max-width: 800px;
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

h3 {
    color: #4682b4;
    margin-bottom: 1rem;
    text-align: center;
}

.message {
    background: #d4edda;
    color: #155724;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    text-align: center;
}

.error-message {
    background: #ffdddd;
    color: #d8000c;
    padding: 10px;
    margin-bottom: 1rem;
    border-radius: 5px;
    text-align: center;
}

.success-message {
    background: #d4edda;
    color: #155724;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
}

.success-message a {
    color: #9370db;
    text-decoration: none;
}

.success-message a:hover {
    color: #4682b4;
    text-decoration: underline;
}

.payment-section, .additional-section, .order-section, .info-section {
    margin-bottom: 2rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    color: #4682b4;
    margin-bottom: 0.5rem;
}

.form-group input {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid #b0c4de;
    border-radius: 5px;
    box-sizing: border-box;
}

.form-group input[required]:invalid {
    border-color: red;
}

.form-group textarea {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid #b0c4de;
    border-radius: 5px;
    box-sizing: border-box;
    resize: vertical;
}

.order-details {
    padding: 1rem;
    border: 1px solid #b0c4de;
    border-radius: 5px;
    margin-bottom: 1rem;
}

.order-details p {
    margin: 0.5rem 0;
}

.total-price {
    float: right;
    color: #ff4081;
    font-weight: 500;
}

.place-order-btn {
    width: 100%;
    padding: 0.8rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: red;
    color: white;
    font-weight: bold;
    margin-top: 1rem;
}

.place-order-btn:hover {
    background-color: #cc0000;
    box-shadow: 0 2px 10px rgba(255, 0, 0, 0.5);
}

.info-section p {
    color: #666;
    font-size: 0.9rem;
    margin: 0.5rem 0;
}

@media (max-width: 768px) {
    .checkout-container {
        padding: 1rem;
        max-width: 100%;
    }
}
</style>