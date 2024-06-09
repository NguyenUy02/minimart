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

// Lấy thông tin sản phẩm từ AJAX request
$masp = $_POST['masp'];
$tensp = $_POST['tensp'];
$soluong = $_POST['soluong'];
$gia = $_POST['gia'];
$sale = $_POST['sale'];

// Tạo mã hóa đơn mới
$mahd = uniqid();
$ngaytao = date('Y-m-d H:i:s');
$tinhtrang = "Đang xử lý";
$mand = 1; // Thay đổi giá trị này bằng mã người dùng đang đăng nhập

// Thêm hóa đơn vào bảng hoadon
$sql_hoadon = "INSERT INTO hoadon (MAHD, MAND, NGAYTAO, TINHTRANGDONHANG) VALUES ('$mahd', '$mand', '$ngaytao', '$tinhtrang')";
if ($conn->query($sql_hoadon) === TRUE) {
    // Thêm chi tiết hóa đơn vào bảng chitiethoadon
    $sql_chitiethoadon = "INSERT INTO chitiethoadon (MAHD, MASP, SOLUONGMUA, DONGIAXUAT) VALUES ('$mahd', '$masp', '$soluong', '$gia')";
    if ($conn->query($sql_chitiethoadon) === TRUE) {
        echo "Thanh toán thành công!";
    } else {
        echo "Lỗi khi thêm chi tiết hóa đơn: " . $conn->error;
    }
} else {
    echo "Lỗi khi thêm hóa đơn: " . $conn->error;
}

$conn->close();
?>