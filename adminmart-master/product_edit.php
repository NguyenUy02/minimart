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
        <h1>Chỉnh sửa thông tin sản phẩm</h1>
    <?php
function isProductsExists($conn, $TENSP, $maSP) {
    $TENSP = mysqli_real_escape_string($conn, $TENSP);
    $sql = "SELECT COUNT(*) as count FROM sanpham WHERE TENSP = '$TENSP' AND MASP != '$maSP'" ;
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

$maSP = $_GET['maSP'];
$sql_sanpham = "SELECT TENSP, GIA, SALE, SOLUONG, MOTA, ANH, TENLSP, TENTH, THANHPHAN, sanpham.MATTSP,
KHOILUONG, THETICH, NGAYSANXUAT, HANSUDUNG, XUATXU
FROM ((sanpham join loaisanpham on sanpham.MALSP = loaisanpham.MALSP) join thuonghieu on
sanpham.MATH = thuonghieu.MATH) join thongtinsanpham on sanpham.MATTSP=thongtinsanpham.MATTSP
WHERE sanpham.MASP = '$maSP'";
$result = mysqli_query($conn, $sql_sanpham);
$row = mysqli_fetch_assoc($result);
$maTTSP = $row['MATTSP'];

if (isset($_POST["luu"])) {
    $target_dir = "../img/";

    // Kiểm tra xem người dùng đã chọn ảnh mới hay chưa
    if (!empty($_FILES["Avatar"]["name"])) {
        $target_file = $target_dir . basename($_FILES["Avatar"]["name"]);
        $check = getimagesize($_FILES["Avatar"]["tmp_name"]);

        if ($check !== false) {
            move_uploaded_file($_FILES["Avatar"]["tmp_name"], $target_file);
            $anh_moi = $_FILES["Avatar"]["name"];
        } else {
            ?>
            <script>
                window.alert("Tệp ảnh không hợp lệ");
            </script>
            <?php
        }
    } else {
        // Nếu không có ảnh mới, sử dụng ảnh cũ
        $anh_moi = $row['ANH'];
    }

    if (!isProductsExists($conn, $_POST['TENSP'], $maSP)) {
        $sql = "UPDATE sanpham SET TENSP = '" . $_POST['TENSP'] . "', GIA = '" . $_POST['GIA'] . "',SALE = '" . $_POST['SALE'] . "',
        SOLUONG = '" . $_POST['SOLUONG'] . "', MOTA = '" . $_POST['MOTA'] . "', ANH = '$anh_moi',
            MALSP = '" . $_POST['loaisp'] . "', MATH = '" . $_POST['MATH'] . "'
            WHERE MASP = '" . $maSP . "'";
        $result = mysqli_query($conn, $sql);
        $sql = "UPDATE thongtinsanpham SET THANHPHAN = '" . $_POST['THANHPHAN'] . "', KHOILUONG = '" . $_POST['KHOILUONG'] . "',
            THETICH = '" . $_POST['THETICH'] . "', XUATXU = '" . $_POST['XUATXU'] . "', NGAYSANXUAT = '" . $_POST['NGAYSANXUAT'] . "',
            HANSUDUNG = '" . $_POST['HANSUDUNG'] . "'
            WHERE MATTSP = '" . $maTTSP . "'";
        $result = mysqli_query($conn, $sql);
        echo "
        <div class='alert alert-success alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h4><i class='icon fa fa-check'></i> Thành công!</h4>
            Sửa dữ liệu thành công
        </div>
        <script>
            setTimeout(function() {
                window.location.href = 'product.php';
            }, 2000); // Chuyển hướng sau 2 giây
        </script>
        ";
    } else {
        echo '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-warning"></i> Lỗi !</h4>
            Sản phẩm đã tồn tại
        </div>';
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
        <input type="text" class="form-control textfile" name="TENSP" required  value="<?php echo $row['TENSP'] ?>">
    </div>
    <div class="form-group">
        <label class="control-label">Giá</label>
        <input type="number" class="form-control textfile" name="GIA" required  value="<?php echo $row['GIA'] ?>">
    </div>
    <div class="form-group">
        <label class="control-label">Giảm giá</label>
        <input type="number" class="form-control textfile" name="SALE"  value="<?php echo $row['SALE'] ?>">
    </div>
    <div class="form-group">
        <label class="control-label">Số lượng</label>
        <input type="number" class="form-control textfile" name="SOLUONG" required  value="<?php echo $row['SOLUONG'] ?>">
    </div>
    <div class="form-group">
        <label class="control-label">Mô tả</label>
        <textarea class="form-control textfile" name="MOTA"><?php echo $row['MOTA'] ?></textarea>
    </div>
    <div class="form-group">
        <label class="control-label">Loại sản phẩm</label>
        <select class="form-control textfile" name="loaisp" required>
            <?php
            $sql_loaisp = "SELECT TENLSP, MALSP from loaisanpham ";
            $result_loaisp = mysqli_query($conn, $sql_loaisp);
            while ($rows = mysqli_fetch_row($result_loaisp)) {
                if ($row["TENLSP"] == $rows[0]) {
                        echo "<option selected value='$rows[1]'>$rows[0]</option>";
                } else
                        echo "<option value='$rows[1]'>$rows[0]</option>";
        } ?>
        </select>
    </div>
    <div class="form-group">
        <label class="control-label">Thương hiệu</label>
        <select class="form-control textfile" name="MATH" required>
            <?php
           $sql_thuonghieu = "SELECT TENTH, MATH from thuonghieu ";
           $result_thuonghieu = mysqli_query($conn, $sql_thuonghieu);
           while ($rows = mysqli_fetch_row($result_thuonghieu)) {
            if ($row["TENTH"] == $rows[0]) {
                    echo "<option selected value='$rows[1]'>$rows[0]</option>";
            } else
                    echo "<option value='$rows[1]'>$rows[0]</option>";
    } ?>
        </select>
    </div>
    <div class="form-group">
        <label class="control-label">Thành phần:</label>
        <input type="text" class="form-control textfile" name="THANHPHAN" required  value="<?php echo $row['THANHPHAN']; ?>">
    </div>
    <div class="form-group">
        <label class="control-label">Khối lượng</label>
        <input type="text" class="form-control textfile" name="KHOILUONG"  value="<?php echo $row['KHOILUONG'] ?>">
    </div>
    <div class="form-group">
        <label class="control-label">Thể tích</label>
        <input type="text" class="form-control textfile" name="THETICH"  value="<?php echo $row['THETICH'] ?>">
    </div>
    <div class="form-group">
        <label class="control-label">Xuất xứ</label>
        <input type="text" class="form-control textfile" name="XUATXU" required  value="<?php echo $row['XUATXU'] ?>">
    </div>
    <div class="form-group">
    <label class="control-label">Ngày sản xuất</label>
    <input type="date" class="form-control textfile" name="NGAYSANXUAT" value="<?php echo $row['NGAYSANXUAT']; ?>" required>
</div>
<div class="form-group">
    <label class="control-label">Hạn sử dụng</label>
    <input type="date" class="form-control textfile" name="HANSUDUNG" value="<?php echo $row['HANSUDUNG']; ?>" required>
</div>
    <div class="form-group">
        <label class="control-label">Ảnh đại diện</label>
        <input type="file" class="form-control-file" id="Avatar" name="Avatar"  accept="image/*" >
    </div>
    <button type="submit" class="btn btn-primary" name="luu">Sửa thông tin</button>
</form>
</div>   
</body>

<?php
include 'footer_admin.php';
?>
