<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "minimart4";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Lấy thông tin sản phẩm từ request
$masp = isset($_POST['masp']) ? $_POST['masp'] : '';
$tensp = isset($_POST['tensp']) ? $_POST['tensp'] : '';
$soluong = isset($_POST['soluong']) ? $_POST['soluong'] : 0;
$gia = isset($_POST['gia']) ? $_POST['gia'] : 0;
$sale = isset($_POST['sale']) ? $_POST['sale'] : 0;

// Lấy mã người dùng từ phiên đăng nhập
$mand = isset($_SESSION['MAND']) ? $_SESSION['MAND'] : '';

// Kiểm tra tính hợp lệ của thông tin sản phẩm và mã người dùng
if (empty($masp) || empty($tensp) || $soluong <= 0 || $gia <= 0 || empty($mand)) {
    echo "Vui lòng nhập đầy đủ thông tin sản phẩm và đăng nhập.";
    exit;
}

// Tạo mã hóa đơn mới
$mahd = LayMaHoaDon($conn);

// Tính tổng tiền
$tongtien = ($sale > 0) ? $sale * $soluong : $gia * $soluong;

// Bắt đầu giao dịch
$conn->begin_transaction();

try {
    // Lưu thông tin hóa đơn vào bảng hoadon
    $sql = "INSERT INTO hoadon (MAHD, MAND, NGAYTAO, TINHTRANGDONHANG) VALUES (?, ?, NOW(), ?, 'Giao hàng thành công')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sid", $mahd, $mand);
    $stmt->execute();

    // Lưu thông tin chi tiết hóa đơn vào bảng chitiethoadon
    $sql = "INSERT INTO chitiethoadon (MAHD, MASP, TENSP, DONGIAXUAT, SOLUONGMUA) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $dongia = ($sale > 0) ? $sale : $gia;
    $stmt->bind_param("sissid", $mahd, $masp, $tensp, $dongia, $soluong);
    $stmt->execute();

    // Commit the transaction
    $conn->commit();

    echo "Thanh toán thành công!";
} catch (Exception $e) {
    // Rollback the transaction if any error occurs
    $conn->rollback();
    echo "Có lỗi xảy ra khi thanh toán: " . $e->getMessage();
} finally {
    $stmt->close();
    $conn->close();
}

// Hàm tạo mã hóa đơn mới
function LayMaHoaDon($db) {
    // Lấy danh sách các MAHD từ bảng HOADON
    $query = "SELECT MAHD FROM hoadon";
    $result = mysqli_query($db, $query);

    // Lấy MAHD lớn nhất
    $maMax = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $maHD = $row['MAHD'];
        if ($maHD > $maMax) {
            $maMax = $maHD;
        }
    }

    // Tạo mã ND mới
    $maHD = intval(substr($maMax, 2)) + 1;
    $HD = str_pad($maHD, 4, '0', STR_PAD_LEFT);
    return 'HD' . $HD;
}
?>