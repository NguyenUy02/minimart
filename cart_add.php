<?php
include 'login_required.php';
include 'connect.php';
if (!isset($_SESSION['MAND'])) {
    header('Location: login.php');
    exit();
}
$response = array();
$response['success'] = false;
$masp = $_POST['MASP'];
$soluong = $_POST['SOLUONG'];

$result = mysqli_query($conn, "SELECT count(SOLUONG) as SLGH FROM giohang WHERE MASP = '$masp' AND MAND = '{$_SESSION['MAND']}'");
$row = mysqli_fetch_assoc($result);
$slgh = $row['SLGH'];

if ($slgh != 0) {
    // Nếu sản phẩm đã tồn tại, cập nhật số lượng
    $updateQuery = "UPDATE giohang SET SOLUONG = SOLUONG + $soluong WHERE MASP = '$masp' AND MAND = '{$_SESSION['MAND']}'";
    mysqli_query($conn, $updateQuery);
    $response['success'] = true;
} else {
    // Nếu sản phẩm chưa tồn tại, tạo mới và thêm vào giỏ hàng
    $dongiaResult = mysqli_query($conn, "SELECT GIA, SALE FROM sanpham WHERE MASP = '$masp'");
    $dongiaRow = mysqli_fetch_assoc($dongiaResult);
    $dongia = $dongiaRow['GIA'];
    $sale = $dongiaRow['SALE'];

    // Kiểm tra nếu SALE lớn hơn 0
    if ($sale > 0) {
        $dongia = $sale; // Thay đổi giá trị DONGIA thành SALE
    }

    $insertQuery = "INSERT INTO giohang (MAND, MASP, SOLUONG, DONGIA) VALUES ('{$_SESSION['MAND']}', '$masp', $soluong, $dongia )";
    mysqli_query($conn, $insertQuery);

    // Tăng giá trị của SLGH trong session
    $_SESSION['SLGH'] += 1;
    $response['success'] = true;
}

// Trả về kết quả thành công hoặc thông tin khác cần thiết (nếu cần)

$response['slgh'] = $_SESSION['SLGH'];
echo json_encode($response, JSON_NUMERIC_CHECK);
