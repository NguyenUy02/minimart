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
    <title>Thêm sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <h1>Thêm sản phẩm</h1>
    <?php
function isProductsExists($conn, $TENSP) {
    $TENSP = mysqli_real_escape_string($conn, $TENSP);
    $sql = "SELECT COUNT(*) as count FROM sanpham WHERE TENSP = '$TENSP'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

$sql = "SELECT MASP from sanpham ORDER BY MASP DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$maSP = (int) substr($row['MASP'], 2);
$maSP = $maSP + 1;
$maSP = "SP" . str_pad($maSP, 3, "0", STR_PAD_LEFT);

$sql = "SELECT MATTSP from thongtinsanpham ORDER BY MATSKT DESC LIMIT 1";
$result1 = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_assoc($result);
$maTTSP = (int) substr($row['MASP'], 4);
$maTTSP = $maTTSP + 1;
$maTTSP = "TT" . str_pad($maTTSP, 3, "0", STR_PAD_LEFT);

if (isset($_POST['TENSP'])) {
    $TENSP = $_POST["TENSP"]; 
} else {
    $TENSP = "";
}

if (isset($_POST["taomoi"])) {
    $TENSP  = mysqli_real_escape_string($conn, $TENSP);
    if (!isProductsExists($conn, $TENSP)) {
        $target_dir = "../img/";
        $target_file = $target_dir . basename($_FILES["Avatar"]["name"]);
        $check = getimagesize($_FILES["Avatar"]["tmp_name"]);
        $ngayTao = date("Y-m-d H:i:s");
        
        if ($check !== false) {
            $sale = isset($_POST['SALE']) ? $_POST['SALE'] : 0;

            $sql = "INSERT INTO thongtinsanpham VALUES ('$maTTSP', '" . $_POST['THANHPHAN'] . "', '" . $_POST['KHOILUONG'] . "', 
            '" . $_POST['THETICH'] . "', '" . $_POST['XUATXU'] . "', '" . $_POST['NGAYSANXUAT'] . "',
            '" . $_POST['HANSUDUNG'] . "')";
            $result = mysqli_query($conn, $sql);

            move_uploaded_file($_FILES["Avatar"]["tmp_name"], $target_file);

            $sql = "INSERT INTO sanpham (MASP, TENSP, GIA, SALE, SOLUONG, MOTA, ANH, NGAYTAO, MALSP, MATH, MATTSP)
            VALUES ('$maSP', '$TENSP', '" . $_POST['GIA'] . "', '$sale', 
            '" . $_POST['SOLUONG'] . "', '" . $_POST['MOTA'] . "', '" . $_FILES["Avatar"]["name"] . "',
            '$ngayTao', '" . $_POST['MALSP'] . "', '" . $_POST['MATH'] . "', '" . $maTTSP . "')";   
            $result = mysqli_query($conn, $sql);

            echo "
            <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-check'></i> Thành công!</h4>
                Thêm dữ liệu thành công
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = 'product.php';
                }, 2000); // Chuyển hướng sau 2 giây
            </script>
            ";       
        } else {
            echo '
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Lỗi !</h4>
                Sản phẩm đã tồn tại
            </div>';
        }
    }
}
?>

<div class="container">
<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label class="control-label">Mã sản phẩm </label>
        <input type="text" class="form-control textfile" readonly value="<?php echo $maSP ?>" name="MASP">
    </div>
    <div class="form-group">
        <label class="control-label ">Tên sản phẩm </label>
        <input type="text" class="form-control textfile" name="TENSP" required>
    </div>
    <div class="form-group">
        <label class="control-label">Giá:</label>
        <input type="number" class="form-control textfile" name="GIA" required>
    </div>
    <div class="form-group">
        <label class="control-label">Giảm giá:</label>
        <input type="number" class="form-control textfile" name="SALE">
    </div>
    <div class="form-group">
        <label class="control-label">Số lượng:</label>
        <input type="number" class="form-control textfile" name="SOLUONG" required>
    </div>
    <div class="form-group">
        <label class="control-label">Mô tả:</label>
        <textarea class="form-control textfile" name="MOTA" required></textarea>
    </div>
    <div class="form-group">
        <label class="control-label">Loại sản phẩm:</label>
        <select class="form-control textfile" name="MALSP" required>
            <?php
            $sql = "SELECT * FROM loaisanpham";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['MALSP'] . "'>" . $row['TENLSP'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label class="control-label">Thương hiệu:</label>
        <select class="form-control textfile" name="MATH" required>
            <?php
            $sql = "SELECT * FROM thuonghieu";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['MATH'] . "'>" . $row['TENTH'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label class="control-label">Thành phần:</label>
        <input type="text" class="form-control textfile" name="THANHPHAN" required>
    </div>
    <div class="form-group">
        <label class="control-label">Khối lượng:</label>
        <input type="text" class="form-control textfile" name="KHOILUONG">
    </div>
    <div class="form-group">
        <label class="control-label">Thể tích:</label>
        <input type="text" class="form-control textfile" name="THETICH">
    </div>
    <div class="form-group">
        <label class="control-label">Xuất xứ:</label>
        <input type="text" class="form-control textfile" name="XUATXU" required>
    </div>
    <div class="form-group">
        <label class="control-label">Ngày sản xuất:</label>
        <input type="date" class="form-control textfile" name="NGAYSANXUAT" required>
    </div>
    <div class="form-group">
        <label class="control-label">Hạn sử dụng:</label>
        <input type="date" class="form-control textfile" name="HANSUDUNG" required>
    </div>
    <div class="form-group">
        <label class="control-label">Ảnh đại diện:</label>
        <input type="file" class="form-control-file" id="Avatar" name="Avatar" required>
    </div>
    <button type="submit" class="btn btn-primary" name="taomoi">Thêm sản phẩm</button>
    <a href="javascript:history.go(-1);"><input type="button" value="Quay lại" class="btn btn-success" name="Quay lại" /></a>
</form>
</div>   
</body>

<?php
include 'footer_admin.php';
?>