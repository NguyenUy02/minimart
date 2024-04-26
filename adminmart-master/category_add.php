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
    <title>Thêm loại sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
    <?php
    function isCategoryExists($conn, $tenLSP) {
        $tenLSP = mysqli_real_escape_string($conn, $tenLSP);
        $sql = "SELECT COUNT(*) as count FROM loaisanpham WHERE TENLSP = '$tenLSP'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['count'] > 0;
    }

    $sql = "SELECT MALSP from loaisanpham ORDER BY MALSP DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $maLoaiSP = (int) substr($row['MALSP'], 3);
    $maLoaiSP = $maLoaiSP + 1;
    $maLoaiSP = "LSP" . str_pad($maLoaiSP, 2, "0", STR_PAD_LEFT);
    if (isset($_POST['tenLSP'])) $tenLSP = $_POST["tenLSP"]; else $tenLSP = "";
    if (isset($_POST["create"])) {
        $tenLSP  = mysqli_real_escape_string($conn, $tenLSP);
        if (!isCategoryExists($conn, $tenLSP)) {    
        $sql = "INSERT INTO loaisanpham (MALSP, TENLSP) VALUES ('$maLoaiSP', '$tenLSP')";
        mysqli_query($conn, $sql);
        echo "
        <div class='alert alert-success alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h4><i class='icon fa fa-check'></i> Thành công!</h4>
            Thêm dữ liệu thành công
        </div>
        <script>
            setTimeout(function() {
                window.location.href = 'category.php';
            }, 2000); // Chuyển hướng sau 2 giây
        </script>
        ";
    } else {
        echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Lỗi !</h4>
                Loại sản phẩm đã tồn tại
            </div>';
    }
    }
    ?>
    <div class="container">
        <h2>Thêm loại sản phẩm</h2>
        <form action="" method="POST" id="form-3">
            <div class="form-horizontal">
                
                <div class="form-group">
                    <label>Mã loại sản phẩm</label>
                    <input type="text" name="maLoaiSP" class="form-control textfile"  value="<?php echo $maLoaiSP ?>" disabled  style="width:52%">
                </div>
                <div class="form-group">
                    <label>Tên loại</label>
                    <input type="text" id="tenloai" class="form-control textfile" name="tenLSP" style="width:52%">
                    <span class="error_message"></span>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input type="submit" value="Thêm" class="btn btn-primary" name="create" />
                        <a href="javascript:history.go(-1);"><input type="button" value="Quay lại" class="btn btn-success" name="Quay lại" /></a>
                    </div>
                </div>
        </form>
    </div>  
</body>

<?php
include 'footer_admin.php';
?>