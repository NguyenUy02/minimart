<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "minimart4";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy mã vạch từ AJAX request
$barcode = $_POST['barcode'];

// Truy vấn thông tin sản phẩm từ bảng sanpham
$sql = "SELECT MASP, TENSP, GIA, SALE FROM sanpham WHERE barcode = '$barcode'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $productInfo = array(
        'MASP' => $row['MASP'],
        'TENSP' => $row['TENSP'],
        'GIA' => $row['GIA'],
        'SALE' => $row['SALE']
    );
    echo json_encode($productInfo);
} else {
    echo json_encode(null);
}

$conn->close();
?>