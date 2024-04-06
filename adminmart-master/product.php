<?php
include 'header_admin.php';
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">   
        <div style="margin-bottom: 10px; margin-left: 20px ">
            <h1>Danh sách sản phẩm</h1>
            <a href="./product_add.php"><button class="btn btn-primary btn-sm add btn-flat"><i class="fa fa-plus"></i> Thêm</button></a>
        </div>
        <?php
        // Truy vấn cơ sở dữ liệu để lấy danh sách sản phẩm
        $query = "SELECT s.MASP, s.TENSP, s.SOLUONG, s.GIA, s.SALE, s.ANH, t.TENTH, l.TENLSP
            FROM sanpham s
            INNER JOIN thuonghieu t ON s.MATH = t.MATH
            INNER JOIN loaisanpham l ON s.MALSP = l.MALSP";
            $result = mysqli_query($conn, $query);

        // Kiểm tra và hiển thị danh sách sản phẩm
        if (mysqli_num_rows($result) > 0) {
            echo '<table class="table" style="color: black;">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Mã sản phẩm</th>';
            echo '<th>Tên sản phẩm</th>';
            echo '<th>Số lượng</th>';
            echo '<th>Giá</th>';
            echo '<th>Sale</th>';
            echo '<th>Thương hiệu</th>';
            echo '<th>Loại sản phẩm</th>';
            echo '<th>Ảnh</th>';
            echo '<th>Chức năng</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['MASP'] . '</td>';
                echo '<td>' . $row['TENSP'] . '</td>';
                echo '<td>' . $row['SOLUONG'] . '</td>';
                echo '<td>' . $row['GIA'] . '</td>';
                echo '<td>' . $row['SALE'] . '</td>';
                echo '<td>' . $row['TENTH'] . '</td>';
                echo '<td>' . $row['TENLSP'] . '</td>';
                echo '<td><img src="../img/' . $row['ANH'] . '" alt="Product Image" height="50" width="50"></td>';
                echo '<td>';
                echo '<a href="./product_Edit.php?maSP=' . $row['MASP'] . '"><button class="btn btn-success btn-sm edit btn-flat"><i class="fa fa-edit"></i> Sửa</button></a>';
                echo '<a href="./product_Details.php?maSP=' . $row['MASP'] . '"><button class="btn btn-info btn-sm info btn-flat"><i class="fa fa-circle-info"></i> Chi tiết</button></a>';
                echo '<a href="./product_Delete.php?maSP=' . $row['MASP'] . '"><button class="btn btn-danger btn-sm delete btn-flat"><i class="fa fa-trash"></i> Xoá</button></a>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo 'Không có sản phẩm nào.';
        }
        // Đóng kết nối cơ sở dữ liệu
        mysqli_close($conn);
        ?>
    </div>
</body>

<?php
include 'footer_admin.php';
?>
