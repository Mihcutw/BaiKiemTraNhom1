<?php
// Dữ liệu sản phẩm từ hình ảnh
$products = [
    ['id' => 1, 'name' => 'Áo Thun Den', 'price' => 200000],
    ['id' => 2, 'name' => 'Quần Jeans Xanh', 'price' => 500000],
    ['id' => 3, 'name' => 'Giày Thể Thao', 'price' => 800000],
];
?>

<?php include 'header.php'; ?>

    <div class="container">
        <h1>Danh Sách Sản Phẩm</h1>

        <a href="create.php" class="btn btn-add">+ Thêm Sản Phẩm</a>
        <a href="update.php" class="btn btn-update">Cập nhật Sản Phẩm</a>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Giá</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td class="price"><?php echo number_format($product['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                            <td>
                                <a href="#" class="btn btn-edit">Sửa</a>
                                <a href="#" 
                                   class="btn btn-delete" 
                                   onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="4" class="empty-message">Hiện chưa có sản phẩm nào trong danh sách</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php include 'footer.php'; ?>

    <style>
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        h1 {
            color: #2d88ff;
            margin-bottom: 30px;
            text-align: center;
            font-size: 2.2em;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-add {
            background: linear-gradient(45deg, #00c853, #00e676);
            color: white;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,200,83,0.3);
        }

        .btn-add:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,200,83,0.4);
            background: linear-gradient(45deg, #00e676, #00c853);
        }

        .btn-update {
            background: linear-gradient(45deg, #ff9800, #ffb300);
            color: white;
            margin-bottom: 25px;
            margin-left: 15px;
            box-shadow: 0 4px 15px rgba(255,152,0,0.3);
        }

        .btn-update:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255,152,0,0.4);
            background: linear-gradient(45deg, #ffb300, #ff9800);
        }

        .table-wrapper {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
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
            background: linear-gradient(45deg, #2d88ff, #4dabff);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        tr {
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: #f8fafd;
            transform: scale(1.01);
        }

        .price {
            color: #e74c3c;
            font-weight: 500;
        }

        .btn-edit, .btn-delete {
            padding: 8px 18px;
            margin: 0 5px;
            border-radius: 25px;
            color: white;
            font-size: 0.9em;
        }

        .btn-edit {
            background: linear-gradient(45deg, #3498db, #2980b9);
        }

        .btn-delete {
            background: linear-gradient(45deg, #e74c3c, #c0392b);
        }

        .btn-edit:hover {
            background: linear-gradient(45deg, #2980b9, #3498db);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(52,152,219,0.3);
        }

        .btn-delete:hover {
            background: linear-gradient(45deg, #c0392b, #e74c3c);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(231,76,60,0.3);
        }

        .empty-message {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 10px;
            }

            table {
                display: block;
                overflow-x: auto;
            }

            th, td {
                min-width: 150px;
            }

            .btn-add, .btn-update {
                display: block;
                width: fit-content;
                margin: 10px auto;
            }
        }
    </style>