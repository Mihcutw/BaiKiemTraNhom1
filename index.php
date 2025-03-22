<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sản Phẩm</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 40px;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 1200px;
        }
        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 600;
        }
        .search-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .search-bar input {
            padding: 10px;
            border: 1px solid #dcdcdc;
            border-radius: 5px;
            width: 300px;
            font-size: 14px;
        }
        .search-bar input:focus {
            outline: none;
            border-color: #6c5ce7;
            box-shadow: 0 0 5px rgba(108, 92, 231, 0.3);
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-add {
            background-color: #6c5ce7;
            color: white;
        }
        .btn-add:hover {
            background-color: #5a4bc7;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
        }
        .btn-copy {
            background-color: #f39c12;
            color: white;
        }
        .btn-copy:hover {
            background-color: #e67e22;
        }
        .btn-edit {
            background-color: #0984e3;
            color: white;
            margin-right: 5px;
        }
        .btn-edit:hover {
            background-color: #0871c1;
        }
        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c0392b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        th {
            background-color: #34495e;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
        }
        td {
            color: #34495e;
            font-size: 15px;
        }
        tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }
        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            color: #6c5ce7;
            text-decoration: none;
            padding: 8px 12px;
            border: 1px solid #dcdcdc;
            border-radius: 5px;
            margin: 0 5px;
            transition: all 0.3s ease;
        }
        .pagination a:hover {
            background-color: #6c5ce7;
            color: white;
        }
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            table {
                display: block;
                overflow-x: auto;
            }
            th, td {
                padding: 10px;
                font-size: 13px;
            }
            .btn {
                padding: 6px 12px;
                font-size: 12px;
            }
            .search-bar input {
                width: 200px;
            }
            .product-img {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Danh Sách Sản Phẩm</h2>

        <div class="search-bar">
            <input type="text" placeholder="Tìm kiếm sản phẩm..." id="searchInput" onkeyup="searchTable()">
            <a href="add.php" class="btn btn-add">Thêm Sản Phẩm</a>
        </div>

        <table id="productTable">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Giá</th>
                    <th>Ngày Cập Nhật</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Kết nối database
                $conn = mysqli_connect("localhost", "username", "password", "database_name");
                if (!$conn) {
                    die("Kết nối thất bại: " . mysqli_connect_error());
                }

                // Truy vấn danh sách sản phẩm
                $sql = "SELECT * FROM products";
                $result = mysqli_query($conn, $sql);

                // Hiển thị dữ liệu
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td><img src='" . ($row["image"] ?? 'default.jpg') . "' class='product-img' alt='Product Image'></td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . number_format($row["price"], 0, ',', '.') . " VNĐ</td>";
                        echo "<td>" . date("d/m/Y H:i", strtotime($row["updated_at"] ?? '2023-01-01')) . "</td>";
                        echo "<td>";
                        echo "<a href='copy.php?id=" . $row["id"] . "' class='btn btn-copy'>Copy</a>";
                        echo "<a href='edit.php?id=" . $row["id"] . "' class='btn btn-edit'>Sửa</a>";
                        echo "<a href='delete.php?id=" . $row["id"] . "' class='btn btn-delete' onclick='return confirm(\"Bạn có chắc muốn xóa?\")'>Xóa</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align: center; color: #7f8c8d;'>Không có sản phẩm nào</td></tr>";
                }

                // Đóng kết nối
                mysqli_close($conn);
                ?>
            </tbody>
        </table>

        <div class="pagination">
            <a href="#">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
        </div>
    </div>

    <script>
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("productTable");
            let rows = table.getElementsByTagName("tr");

            for (let i = 0; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName("td");
                let match = false;
                for (let j = 0; j < cells.length; j++) {
                    if (cells[j]) {
                        let textValue = cells[j].textContent || cells[j].innerText;
                        if (textValue.toLowerCase().indexOf(input) > -1) {
                            match = true;
                            break;
                        }
                    }
                }
                if (match) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>