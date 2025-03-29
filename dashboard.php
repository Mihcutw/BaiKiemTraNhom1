<?php
$page_title = "Dashboard";

$product_count = 0;
$user_count = 0;
$order_count = 0;

include 'header.php';
?>

<div class="stats">
    <div class="stat-box">
        <h3>Sản phẩm</h3>
        <p><?php echo $product_count; ?></p>
    </div>
    <div class="stat-box">
        <h3>Người dùng</h3>
        <p><?php echo $user_count; ?></p>
    </div>
    <div class="stat-box">
        <h3>Đơn hàng</h3>
        <p><?php echo $order_count; ?></p>
    </div>  
</div>

<a href="products.php" class="btn">Xem Danh Sách Sản Phẩm</a>

<?php
include 'footer.php';
?>

<style>
    .stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-box {
        background: #fff;
        padding: 25px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .stat-box:hover {
        transform: translateY(-5px);
    }

    .stat-box h3 {
        color: #666;
        font-size: 16px;
        margin-bottom: 15px;
    }

    .stat-box p {
        font-size: 28px;
        font-weight: bold;
        color: #333;
    }

    .btn {
        display: inline-block;
        padding: 12px 25px;
        background: #1a73e8;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #1557b0;
    }

    @media (max-width: 768px) {
        .stats {
            grid-template-columns: 1fr;
        }
    }
</style>