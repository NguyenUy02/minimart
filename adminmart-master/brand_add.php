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
    <title>Thêm Thương hiệu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
<div class="page-wrapper">

<?php
function isBrandExists($conn, $tenTH) {
    $tenTH = mysqli_real_escape_string($conn, $tenTH);
    $sql = "SELECT COUNT(*) as count FROM thuonghieu WHERE TENTH = '$tenTH'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

$sql = "SELECT MATH from thuonghieu ORDER BY MATH DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$maTH = (int) substr($row['MATH'], 3);
$maTH = $maTH + 1;
$maTH = "TH" . str_pad($maTH, 2, "0", STR_PAD_LEFT);

if (isset($_POST['tenTH']) && isset($_POST['quocGia'])) {
    $tenTH = $_POST["tenTH"];
    $quocGia = $_POST["quocGia"];

    if (!isBrandExists($conn, $tenTH)) {    
        $sql = "INSERT INTO thuonghieu (MATH, TENTH, QUOCGIA) VALUES ('$maTH', '$tenTH', '$quocGia')";
        mysqli_query($conn, $sql);

        echo "
        <div class='alert alert-success alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h4><i class='icon fa fa-check'></i> Thành công!</h4>
            Thêm dữ liệu thành công
        </div>
        <script>
            setTimeout(function() {
                window.location.href = 'brand.php';
            }, 2000); // Chuyển hướng sau 2 giây
        </script>
        ";
    } else {
        echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Lỗi !</h4>
                Thương hiệu đã tồn tại
            </div>';
    }
}
?>

<div class="container">
    <h2>Thêm thương hiệu</h2>
    <form action="" method="POST" id="form-3">
        <div class="form-horizontal">
            
            <div class="form-group">
                <label>Mã thương hiệu</label>
                <input type="text" name="maTH" class="form-control textfile"  value="<?php echo $maTH ?>" disabled style="width:52%">
            </div>
            <div class="form-group">
                <label>Tên thương hiệu</label>
                <input type="text" id="tenTH" class="form-control textfile" name="tenTH"  style="width:52%">
                <span class="error_message"></span>
            </div>
            <div class="form-group">
                <label>Tên quốc gia</label>
                <input type="text" id="quocGia" class="form-control textfile" name="quocGia" style="width:52%">
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