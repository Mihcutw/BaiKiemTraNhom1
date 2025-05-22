<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root"; // Thay bằng username của bạn
$password = ""; // Thay bằng password của bạn
$dbname = "bigshop"; // Thay bằng tên cơ sở dữ liệu của bạn

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Include header
include 'header.php';
?>

<!-- CSS để hiển thị sản phẩm -->
<style>
    .container {
        width: 80%;
        margin: 0 auto;
    }
    .category {
        margin-bottom: 30px;
    }
    .category h2 {
        font-size: 24px;
        color: #333;
        border-bottom: 2px solid #ff6200;
        padding-bottom: 10px;
    }
    .product-list {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    .product {
        width: 18%;
        text-align: center;
        border: 1px solid #ddd;
        padding: 10px;
        box-sizing: border-box;
    }
    .product img {
        max-width: 100%;
        height: auto;
    }
    .product p {
        margin: 5px 0;
    }
    .product .price {
        color: #ff6200;
        font-weight: bold;
    }
    .product .add-to-cart {
        background-color: #ff6200;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
    }
</style>

<div class="container">
    <!-- Danh mục sản phẩm -->
    <?php
    // Lấy danh sách danh mục duy nhất
    $categories = ['Danh Mục', 'Nổi Bật', 'Mới Nhất', 'Sản Phẩm Công Nghệ'];

    foreach ($categories as $category) {
        echo "<div class='category'>";
        echo "<h2>$category</h2>";
        echo "<div class='product-list'>";

        // Lấy sản phẩm theo danh mục
        $sql = "SELECT * FROM products WHERE category = '$category' LIMIT 5";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<img src='{$row['image']}' alt='{$row['name']}'>";
                echo "<p>" . $row['name'] . "</p>";
                echo "<p class='price'>" . number_format($row['price'], 0, ',', '.') . " đ</p>";
                echo "<a href='#' class='add-to-cart'>Thêm giỏ hàng</a>";
                echo "</div>";
            }
        }

        echo "</div>";
        echo "</div>";
    }

    $conn->close();
    ?>
</div>

<?php
// Include footer
include 'footer.php';
?>