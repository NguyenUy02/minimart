<?php
include 'header_admin.php';
include 'db_connect.php';

$maND = $_GET['maND'];
$sql = "SELECT MAND, TENND, SDT, EMAIL, DIACHI FROM nguoidung WHERE MAND = '{$maND}'";
$kq = mysqli_query($conn, $sql);
$thongTinND = mysqli_fetch_assoc($kq);

if (isset($_POST["delete"])) {
    try {
        $sql = "DELETE FROM nguoidung WHERE MAND = '$maND'";
        mysqli_query($conn, $sql);
        echo "
        <div class='alert alert-success alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h4><i class='icon fa fa-check'></i> Thành công!</h4>
            Xoá thành công
        </div>
        <script>
            setTimeout(function() {
                window.location.href = 'users.php';
            }, 3000); // Chuyển hướng sau 3 giây
        </script>
        ";
    } catch (Exception $exception) {
        echo '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-warning"></i> Lỗi !</h4>
            Đang có các hóa đơn liên kết với người dùng này
        </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa tài khoản người dùng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <div class="container">
            <h2>Bạn có chắc xóa tài khoản này?</h2>
            <form action="" method="POST" id="form-3">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label>Mã người dùng</label>
                        <input type="text" class="form-control textfile" value="<?php echo $thongTinND['MAND']; ?>" disabled name="maND">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" class="form-control textfile" name="SDT" disabled value="<?php echo $thongTinND['SDT']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control textfile" name="EMAIL" disabled value="<?php echo $thongTinND['EMAIL']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" class="form-control textfile" name="DIACHI" disabled value="<?php echo $thongTinND['DIACHI']; ?>">
                    </div>
                    <button type="submit" name="delete" class="btn btn-danger">Xóa</button>
                    <a href="javascript:history.go(-1);"><input type="button" value="Quay lại" class="btn btn-success" name="Quay lại" /></a>
                </div>
            </form>
        </div>
    </div>
</body>
<?php
include 'footer_admin.php';
?>