<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "minimart4");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Lấy mã vạch từ request
$barcode = $_POST['barcode'];

// Truy vấn thông tin sản phẩm
$sql = "SELECT MASP, TENSP, SOLUONG, GIA, SALE FROM sanpham WHERE barcode = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $barcode);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo 'false';
}

$stmt->close();
$conn->close();
?>