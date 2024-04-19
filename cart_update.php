<?php
include 'login_required.php';
include 'connect.php';
$masp = $_POST['MASP'];
$soluong = $_POST['SOLUONG'];
$response = array();
// Tìm kiếm và cập nhật dữ liệu trong cơ sở dữ liệu
$gioHang = mysqli_query($conn, "SELECT * FROM giohang join sanpham on giohang.MASP=sanpham.MASP
WHERE giohang.MASP = '$masp' and MAND = '{$_SESSION['MAND']}'");
if (mysqli_num_rows($gioHang) > 0) {
    $query = "UPDATE giohang SET SOLUONG = $soluong WHERE MASP = '$masp'";
    if (mysqli_query($conn, $query)) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }
} else {
    $response['success'] = false;
}
echo json_encode($response, JSON_NUMERIC_CHECK);

