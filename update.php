
<?php include 'header.php'; ?>

<div class="update-product-wrapper">
    <div class="update-product-container">
        <h2>Cập Nhật Sản Phẩm</h2>
        <form id="update-product-form" onsubmit="return validateForm(event)">
            <div class="form-group">
                <label for="product-name">Tên sản phẩm</label>
                <input type="text" id="product-name" name="product-name" placeholder="Nhập tên sản phẩm" required>
            </div>
            <div class="form-group">
                <label for="price">Giá</label>
                <input type="number" id="price" name="price" placeholder="Nhập giá (VNĐ)" step="1000" min="0" required>
            </div>
            <div class="form-group">
                <label for="quantity">Số lượng</label>
                <input type="number" id="quantity" name="quantity" placeholder="Nhập số lượng" min="0" required>
            </div>
            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description" placeholder="Nhập mô tả sản phẩm"></textarea>
            </div>
            <button type="submit">Cập Nhật Sản Phẩm</button>
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
.update-product-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

.update-product-container {
    background-color: #fff;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(147, 112, 219, 0.2);
    border: 1px solid #d8bfd8;
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
    color: #9370db;
    text-align: center;
    margin-bottom: 2rem;
    font-size: 1.8rem;
    font-weight: 500;
}
.form-group {
    margin-bottom: 1.5rem;
}
label {
    display: block;
    color: #9370db;
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
    border-color: #7b68ee;
    box-shadow: 0 0 5px rgba(123, 104, 238, 0.3);
}

textarea {
    height: 120px;
    resize: vertical;
}
input::placeholder, textarea::placeholder {
    color: #b0b0b0;
    font-style: italic;
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
    transition: background-color 0.3s ease, transform 0.1s ease;
}

button:hover {
    transform: translateY(-2px);
}

button:active {
    transform: translateY(0);
}
.back-link {
    text-align: center;
    margin-top: 1.5rem;
}

.back-link a {
    color: #9370db;
    text-decoration: none;
    font-size: 1rem;
    transition: color 0.3s ease;
}

.back-link a:hover {
    color: #7b68ee;
    text-decoration: underline;
}
@media (max-width: 480px) {
    .update-product-container {
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