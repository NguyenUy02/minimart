<?php
// Kiểm tra xem người dùng đã chọn ảnh đại diện mới hay chưa
if (isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];
    $uploadDir = '../assets/images/users/'; // Đường dẫn tới thư mục lưu trữ ảnh đại diện

    // Kiểm tra và di chuyển tệp tin tải lên vào thư mục lưu trữ
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = $file['name'];
        $filePath = $uploadDir . $fileName;
        move_uploaded_file($file['tmp_name'], $filePath);

        // Lưu đường dẫn ảnh vào tệp tin
        file_put_contents('path/to/file.txt', $filePath);
    }
}
