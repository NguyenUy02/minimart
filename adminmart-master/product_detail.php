<?php
include 'header_admin.php';
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem chi tiết sản phẩm</title>
</head>
<?php
$maSP = $_GET['maSP'];
$sql_sanpham = "SELECT TENSP, GIA, SALE, SOLUONG, MOTA, ANH, NGAYTAO, TENLSP, TENTH, THANHPHAN , KHOILUONG, THETICH, XUATXU , NGAYSANXUAT, HANSUDUNG
FROM ((sanpham join loaisanpham on sanpham.MALSP = loaisanpham.MALSP) join thuonghieu on
sanpham.MATH = thuonghieu.MATH) join thongtinsanpham on sanpham.MATTSP = thongtinsanpham.MATTSP
WHERE sanpham.MASP = '$maSP'";
$result = mysqlI_query($conn,$sql_sanpham);
$row = mysqli_fetch_assoc($result);
?>
<body style="color: black;">
<div class="page-wrapper">

<div class="container">
    <h2 style="text-align: center;">Thông tin chi tiết</h2>
    <hr />
    <dl class="dl-horizontal">
        <dt>Tên sản phẩm</dt>
        <dd><?php echo $row['TENSP']; ?></dd>
        
        <dt> Giá</dt>
        <dd><?php echo number_format($row['GIA']); ?></dd>

        <dt>Số lượng</dt>
        <dd><?php echo $row['SOLUONG'];?></dd>

        <dt>Mô tả</dt>
        <dd><?php echo $row['MOTA']; ?></dd>

        <dt>Ảnh sản phẩm</dt>
        <dd><img class="" width="30%" src="<?php $anh =$row['ANH']; echo "../img/".$anh ?>  "></dd>

        <dt>Loại sản phẩm</dt>
        <dd><?php echo $row['TENLSP']; ?></dd>

        <dt>Thương hiệu </dt>
        <dd><?php echo $row['TENTH']; ?></dd>

        <dt>Thành phần</dt>
        <dd><?php echo $row['THANHPHAN'] ; ?></dd>

        <?php if($row['KHOILUONG'] != 0 || $row['KHOILUONG'] != null) {?>
        <dt>Khối lượng</dt>
        <dd><?php  echo $row['KHOILUONG'] .'g'; ?></dd>
        <?php } else { ?>
        <dt></dt><dd></dd><?php } ?>

        <?php if($row['THETICH'] != 0 || $row['THETICH'] != null) {?>
        <dt>Thể tích</dt>
        <dd> <?php echo $row['THETICH'] .'ml'; ?></dd>
        <?php } else { ?>
        <dt></dt><dd></dd><?php } ?>

        <dt> Xuất xứ</dt>
        <dd> <?php echo $row['XUATXU'];?> </dd>

        <dt>Ngày sản xuất</dt>
        <dd><?php echo $row['NGAYSANXUAT']; ?></dd>

        <dt>Hạn sử dụng</dt>
        <dd><?php echo $row['HANSUDUNG'] ; ?> </dd>

        <dt> Ngày mở bán sản phẩm</dt>
        <dd> <?php echo $row['NGAYTAO']; ?></dd>
    </dl>
    <p>
        <a href="./Edit.php?maSP=<?php echo $maSP ?>" class="btn btn-success">Chỉnh sửa</a> 
        <a href="./product.php" class="btn btn-success">Trở về trang danh sách</a>
    </p>
</div>
</body>
</html>
<?php
include 'footer_admin.php';
?>