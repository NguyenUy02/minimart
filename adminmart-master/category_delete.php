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
    <title>Xóa loại sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
<?php
    $maLSP = $_GET['maLSP'];
    $sql = "SELECT TENLSP FROM loaisanpham WHERE MALSP = '{$maLSP}'";
    $kq = mysqli_query($conn, $sql);
    $tenLSP = mysqli_fetch_assoc($kq);
    $tenLSP = $tenLSP['TENLSP'];
    
    if (isset($_POST['delete'])) {
        try {
            $sql = "DELETE FROM loaisanpham WHERE MALSP = '$maLSP'";
            mysqli_query($conn, $sql);
            
            echo "
            <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-check'></i> Thành công!</h4>
                Xoá thành công
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = 'category.php';
                }, 2000); // Chuyển hướng sau 2 giây
            </script>
            ";
        } catch (Exception $e) {
            echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Lỗi !</h4>
                Đang có các sản phẩm liên kết với loại sản phẩm này
            </div>';
        }
    } 
    ?>
    <div class="container">
        <h2>Xóa loại sản phẩm</h2>
        <form action="" method="POST" id="form-3">
            <div class="form-horizontal">
                <div class="form-group">
                    <label>Mã loại sản phẩm</label>
                    <input type="text" class="form-control textfile" value="<?php echo $maLSP ?>" disabled name="maLSP">
                </div>
                <div class="form-group">
                    <label>Tên loại</label>
                    <input required type="text" class="form-control textfile" name="tenLSP" id="tenLSP" value="<?php echo $tenLSP ?>">
                    <span class="error_message"></span>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input type="submit" value="Xóa" class="btn btn-danger" name="delete" />
                        <a href="javascript:history.go(-1);"><input type="button" value="Quay lại" class="btn btn-success" name="Quay lại" /></a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

<?php
include 'footer_admin.php';
?>