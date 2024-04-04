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
    <title>Xóa Thương hiệu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
<div class="page-wrapper">

<?php
$maTH = $_GET['maTH'];
$sql = "SELECT * FROM thuonghieu WHERE thuonghieu.MATH = '$maTH'";
$result = mysqlI_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_POST["delete"])) {
    try{
        $sql = "DELETE FROM thuonghieu WHERE MATH = '$maTH'";
        $result = mysqli_query($conn, $sql);
        echo "
        <div class='alert alert-success alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h4><i class='icon fa fa-check'></i> Thành công!</h4>
            Xoá thành công
        </div>
        <script>
            setTimeout(function() {
                window.location.href = 'brand.php';
            }, 2000); // Chuyển hướng sau 2 giây
        </script>
        ";
    }
    catch (Exception $e) {
        echo '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-warning"></i> Lỗi !</h4>
            Đang có các sản phẩm liên kết với thương hiệu này
        </div>';
    }      
    } 
?>

<div class="container">
    <h2>Xóa thương hiệu</h2>
    <form action="" method="POST">
        <div class="form-horizontal">          
            <div class="form-group">
                <label>Tên thương hiệu</label>
                <input type="text" class="form-control textfile"  value="<?php echo $row['TENTH'] ?>" disabled name="maLoaiSP" style="width:52%">
            </div>
            <div class="form-group">
                <label>Quốc gia</label>
                <input type="text" class="form-control textfile"name="tenLoaiSP" disabled value="<?php echo $row['QUOCGIA']?>" style="width:52%">
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-10"> 
                    <input type="submit" value="Xóa" class="btn btn-danger" name="delete" />
                    <a href="javascript:history.go(-1);"><input type="button" value="Quay lại" class="btn btn-success" name="Quay lại" /></a>
                </div>
            </div>
    </form>
</div> 
</body>

