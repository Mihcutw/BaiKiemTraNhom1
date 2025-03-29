

<!-- create.php -->
<?php include 'header.php'; ?>

        <form>
            <div class="form-group">
                <label for="product-name">Tên sản phẩm</label>
                <input type="text" id="product-name" name="product-name" placeholder="Nhập tên sản phẩm" required>
            </div>
            <div class="form-group">
                <label for="price">Giá</label>
                <input type="number" id="price" name="price" placeholder="Nhập giá (VNĐ)" step="1000" required>
            </div>
            <div class="form-group">
                <label for="quantity">Số lượng</label>
                <input type="number" id="quantity" name="quantity" placeholder="Nhập số lượng" required>
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

    <style>
        .add-product-container {
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
        input, textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #d8bfd8;
            border-radius: 5px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
            resize: vertical;
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