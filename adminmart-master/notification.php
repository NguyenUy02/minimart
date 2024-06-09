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
    <title>Thông báo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <div style="margin-bottom: 10px; margin-left: 20px ">
            <h1>Thông báo</h1>
        </div>
        <?php
        // Truy vấn cơ sở dữ liệu để lấy danh sách
        $query = "SELECT * FROM sanpham WHERE SOLUONG < 20";
        $result = mysqli_query($conn, $query);

        // Kiểm tra và hiển thị danh sách
        if (mysqli_num_rows($result) > 0) {
            echo '<table class="table" style="color: black;">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Mã sản phẩm</th>';
            echo '<th>Tên sản phẩm</th>';
            echo '<th>Số lượng</th>';           
            echo '<th>Ảnh</th>';           
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['MASP'] . '</td>';
                echo '<td>' . $row['TENSP'] . '</td>';
                echo '<td>' . $row['SOLUONG'] . '</td>';               
                echo '<td><img src="../img/' . $row['ANH'] . '" alt="Product Image" height="50" width="50"></td>';
                echo '<td>';               
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo 'Không có loại sản phẩm nào.';
        }
        // Đóng kết nối cơ sở dữ liệu
        mysqli_close($conn);
        ?>
    </div>
</body>

<?php
include 'footer_admin.php';
?>