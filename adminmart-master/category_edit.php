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
    $maLoaiSP = "";
    $tenLSP = "";  
    if (isset($_GET['maLSP'])) {
        $maLoaiSP = $_GET['maLSP'];
        $sql = "SELECT TENLSP FROM loaisanpham WHERE MALSP = '{$maLoaiSP}'";
        $kq = mysqli_query($conn, $sql);
        if ($kq) {
            $row = mysqli_fetch_assoc($kq);
            $tenLSP = $row['TENLSP'];
        } else {
            echo "Lỗi truy vấn cơ sở dữ liệu: " . mysqli_error($conn);
        }
    }
    
    function isCategoryExists($conn, $tenLSP) {
        $tenLSP = mysqli_real_escape_string($conn, $tenLSP);
        $sql = "SELECT COUNT(*) as count FROM loaisanpham WHERE TENLSP = '$tenLSP'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['count'] > 0;
        } else {
            echo "Lỗi truy vấn cơ sở dữ liệu: " . mysqli_error($conn);
            return false;
        }
    }
    
    if (isset($_POST['edit'])) {
        if (isset($_POST['tenLSP'])) {
            $tenLSP = $_POST["tenLSP"];
            if (!isCategoryExists($conn, $tenLSP)) {
                $sql = "UPDATE loaisanpham SET TENLSP = '{$tenLSP}' WHERE MALSP = '{$maLoaiSP}'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo "
                    <script>
                        setTimeout(function() {
                            window.location.href = 'category.php';
                        }, 0); 
                    </script>
                    ";
                } else {
                    echo "Lỗi truy vấn cơ sở dữ liệu: " . mysqli_error($conn);
                }
            } else {
                echo '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-warning"></i> Lỗi!</h4>
                        Loại sản phẩm đã tồn tại và không thể chỉnh sửa
                    </div>';
            }
        } else {
            echo "Vui lòng nhập tên loại sản phẩm";
        }
    }
    ?>
    <div class="container">
        <h2>Chỉnh sửa loại sản phẩm</h2>
        <form action="" method="POST" id="form-3">
            <div class="form-horizontal">
                <div class="form-group">
                    <label>Mã loại sản phẩm</label>
                    <input type="text" class="form-control textfile" value="<?php echo $maLoaiSP ?>" disabled name="maLoaiSP">
                </div>
                <div class="form-group">
                    <label>Tên loại</label>
                    <input required type="text" class="form-control textfile" name="tenLSP" id="tenLSP" value="<?php echo $tenLSP ?>">
                    <span class="error_message"></span>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input type="submit" value="Chỉnh sửa" class="btn btn-success" name="edit" />
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