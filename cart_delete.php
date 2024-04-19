<?php
include 'login_required.php';
include 'connect.php';
$masp = $_POST['MASP'];
$response = array();
// Tìm kiếm và cập nhật dữ liệu trong cơ sở dữ liệu
$gioHang = mysqli_query($conn, "SELECT * FROM giohang 
WHERE giohang.MASP = '$masp' and MAND = '{$_SESSION['MAND']}'");
if (isset($gioHang)) {
    $deleteQuery = "DELETE FROM giohang 
                WHERE giohang.MASP = '$masp' AND MAND = '{$_SESSION['MAND']}'";
    mysqli_query($conn, $deleteQuery);
    $response['success'] = true;
    $_SESSION['SLGH'] -=1;
    $response['slgh'] =  $_SESSION['SLGH'];
}
else
$response['success'] = false;
echo json_encode($response, JSON_NUMERIC_CHECK);