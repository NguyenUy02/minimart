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
    <title>Danh sách loại sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <h1>Danh sách loại sản phẩm</h1>
        <div style="margin-bottom: 10px; margin-left: 20px ">
        <a href="./category_add.php"><button class="btn btn-primary btn-sm add btn-flat"><i class="fa fa-plus"></i> Thêm</button></a>
    </div>

        <?php
        

        // Truy vấn cơ sở dữ liệu để lấy danh sách loại sản phẩm
        $query = "SELECT * FROM loaisanpham";
        $result = mysqli_query($conn, $query);

        // Kiểm tra và hiển thị danh sách loại sản phẩm
        if (mysqli_num_rows($result) > 0) {
            echo '<table class="table" style="color: black;">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Mã loại sản phẩm</th>';
            echo '<th>Tên loại sản phẩm</th>';
            echo '<th>Chức năng</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['MALSP'] . '</td>';
                echo '<td>' . $row['TENLSP'] . '</td>';
                echo '<td>';
                echo '<a href="./category_edit.php?maLSP=' . $row['MALSP'] . '"><button class="btn btn-success btn-sm edit btn-flat"><i class="fa fa-edit"></i> Sửa</button></a>';
                echo '<a href="./category_delete.php?maLSP=' . $row['MALSP'] . '"><button class="btn btn-danger btn-sm delete btn-flat"><i class="fa fa-trash"></i> Xoá</button></a>';
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