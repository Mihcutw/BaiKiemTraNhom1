<?php
include 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product-name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];

    // Validate dữ liệu
    if (!empty($name) && is_numeric($price) && $price >= 0 && is_numeric($quantity) && $quantity >= 0) {
        try {
            $stmt = $conn->prepare('INSERT INTO products (name, price, quantity, description) VALUES (?, ?, ?, ?)');
            $stmt->execute([$name, $price, $quantity, $description]);
            header('Location: products.php');
            exit;
        } catch (PDOException $e) {
            $error = "Lỗi khi thêm sản phẩm: " . $e->getMessage();
        }
    } else {
        $error = "Vui lòng nhập đầy đủ và đúng định dạng.";
    }
}
?>

<?php include 'header.php'; ?>

<div class="add-product-wrapper">
    <div class="add-product-container">
        <h2>Thêm Sản Phẩm</h2>
        <?php if ($error): ?>
            <p style="color: #ff4081;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form id="add-product-form" method="POST">
            <div class="form-group">
                <label for="product-name">Tên sản phẩm</label>
                <input type="text" id="product-name" name="product-name" placeholder="Nhập tên sản phẩm" required>
                <span class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="price">Giá</label>
                <input type="number" id="price" name="price" placeholder="Nhập giá (VNĐ)" step="1000" min="0" required>
                <span class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="quantity">Số lượng</label>
                <input type="number" id="quantity" name="quantity" placeholder="Nhập số lượng" min="0" required>
                <span class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description" placeholder="Nhập mô tả sản phẩm"></textarea>
            </div>
            <button type="submit">Thêm Sản Phẩm</button>
        </form>
        <div class="back-link">
            <a href="products.php">Quay lại danh sách</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Roboto', sans-serif;
}
.add-product-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}
.add-product-container {
    background: rgba(255, 255, 255, 0.9); 
    backdrop-filter: blur(5px);
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(147, 112, 219, 0.3);
    width: 100%;
    max-width: 450px; 
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
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 1.5rem;
    position: relative;
}

label {
    display: block;
    color: #9c5ffd;
    margin-bottom: 0.5rem;
    font-size: 1rem;
    font-weight: 500;
}

input, textarea {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid #d8bfd8;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 1rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input:focus, textarea:focus {
    outline: none;
    border-color: #1de0ff;
    box-shadow: 0 0 5px rgba(29, 224, 255, 0.3);
}

textarea {
    height: 120px;
    resize: vertical;
}

input::placeholder, textarea::placeholder {
    color: #b0b0b0;
    font-style: italic;
}

.error-message {
    color: #ff4081;
    font-size: 0.9rem;
    margin-top: 0.3rem;
    display: block;
    min-height: 1.2rem;
}

button {
    width: 100%;
    padding: 0.8rem;
    background: linear-gradient(to right, #9c5ffd, #1de0ff);
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1.1rem;
    font-weight: 500;
    transition: transform 0.1s ease, box-shadow 0.3s ease;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(29, 224, 255, 0.4);
}

button:active {
    transform: translateY(0);
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

@media (max-width: 480px) {
    .add-product-container {
        padding: 1.5rem;
        max-width: 100%;
    }

    h2 {
        font-size: 1.5rem;
    }

    button {
        font-size: 1rem;
    }
}
    </style>