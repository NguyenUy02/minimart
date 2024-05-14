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
    <title>Sửa tên thương hiệu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
<?php
 $maND = $_GET['maND'];
 $sql_nguoidung = "SELECT EMAIL, TENND, GIOITINH, SDT, DIACHI FROM nguoidung WHERE MAND = '{$maND}'";
 $kq_nguoidung = mysqli_query($conn, $sql_nguoidung);
 $row_nguoidung = mysqli_fetch_assoc($kq_nguoidung);
 
 if (isset($_POST["edit"])) {
     $sql = "UPDATE nguoidung SET EMAIL = '{$_POST['EMAIL']}', TENND = '{$_POST['hoTen']}', SDT = '{$_POST['sdt']}',
             DIACHI = '{$_POST['diachi']}' WHERE MAND = '$maND'";
     mysqli_query($conn, $sql);
     echo "
     <div class='alert alert-success alert-dismissible'>
         <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
         <h4><i class='icon fa fa-check'></i> Thành công!</h4>
         Sửa dữ liệu thành công
     </div>
     <script>
         setTimeout(function() {
             window.location.href = 'users.php';
         }, 0); 
     </script>
     ";
 }
?>
    <div class="container">
        <h2>Chỉnh sửa thương hiệu</h2>
        <form action="" method="POST" id="form-3">
            <div class="form-horizontal">
            <div class="form-group">
                <label for="hoTen">Họ tên:</label>
                <input type="text" class="form-control" id="hoTen" name="hoTen" value="<?php echo $row_nguoidung['TENND'] ?>" required>
            </div>
            <div class="form-group">
                <label for="EMAIL">Email:</label>
                <input type="email" class="form-control" id="EMAIL" name="EMAIL" value="<?php echo $row_nguoidung['EMAIL'] ?>" required>
            </div>
            <div class="form-group">
                <label for="sdt">Số điện thoại:</label>
                <input type="text" class="form-control" id="sdt" name="sdt" value="<?php echo $row_nguoidung['SDT'] ?>" required>
            </div>
            <div class="form-group">
                <label for="diachi">Địa chỉ:</label>
                <input type="text" class="form-control" id="diachi" name="diachi" value="<?php echo $row_nguoidung['DIACHI'] ?>" required>
            </div>
            <button type="submit" name="edit" class="btn btn-primary">Chỉnh sửa</button>
            <a href="javascript:history.go(-1);"><input type="button" value="Quay lại" class="btn btn-success" name="Quay lại" /></a>
            </form>
        </div>
</body>
<?php
include 'footer_admin.php';
?>