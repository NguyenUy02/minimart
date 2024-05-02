<?php 
include ("connect.php");

if (isset($_POST['TENND']) && isset($_POST['SDT'])  && isset($_POST['MATKHAU']) 
    && isset($_POST['CONFIRM-MATKHAU']) 
    && isset($_POST['GIOITINH']) 
    && isset($_POST['DIACHI'])  ) {
    function LayMaND($db) {
        // Lấy danh sách các MAND từ bảng nguoidung
        $query = "SELECT MAND FROM nguoidung";
        $result = mysqli_query($db, $query);

        // Lấy MAND lớn nhất
        $maMax = '';
        while ($row = mysqli_fetch_assoc($result)) {
            $maND = $row['MAND'];
            if ($maND > $maMax) {
                $maMax = $maND;
            }
        }

        // Tạo mã ND mới
        $maND = intval(substr($maMax, 2)) + 1;
        $SP = str_pad($maND, 3, '0', STR_PAD_LEFT);
        return 'ND' . $SP;
    }

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $mand = LayMaND($conn);
    $tennd = validate($_POST['TENND']);
    $sdt = validate($_POST['SDT']);
    $matkhau = validate($_POST['MATKHAU']);
    $confirm_password = validate($_POST['CONFIRM-MATKHAU']);
    $gioitinh = validate($_POST['GIOITINH']); 
    $diachi = validate($_POST['DIACHI']);
    $isadmin = 0;
    $user_data = 'TENND=' . $tennd . '&SDT=' . $sdt . '&MATKHAU=' . $matkhau . '&CONFIRM-MATKHAU=' . $confirm_password 
    . '&gioitinh=' . $gioitinh  . '&DIACHI=' . $diachi;

    if (empty($tennd)) {
        header("Location: register.php?error=tên là bắt buộc&$user_data");
        exit();
    } else if (empty($sdt)) {
        header("Location: register.php?error=Số điện thoại là bắt buộc&$user_data");
        exit();
    } else if (empty($matkhau)) {
        header("Location: register.php?error=Mật khẩu là bắt buộc&$user_data");
        exit();
    } else if ($confirm_password != $matkhau) {
        header("Location: register.php?error=Mật khẩu không khớp&$user_data");
        exit();
    } else if (empty($gioitinh)) {
        header("Location: register.php?error=Giới tính là bắt buộc&$user_data");
        exit();   
    } else if (empty($diachi)) {
        header("Location: register.php?error=Địa chỉ là bắt buộc&$user_data");
        exit();
    } else {
        $sql = "SELECT * FROM nguoidung WHERE SDT='$sdt' ";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            header("Location: register.php?error=Số điện đã được sử dụng$user_data");
            exit();
        } else {
            $sql3 = "INSERT INTO nguoidung(MAND, TENND, SDT, MATKHAU,  GIOITINH,  DIACHI, ISADMIN) 
            VALUES('$mand', '$tennd', '$sdt', '$matkhau',  '$gioitinh',  '$diachi', '0')";
            $result3 = mysqli_query($conn, $sql3);

            if ($result3) {
                header("Location: login.php?success=Đăng ký thành công");
                exit();
            } else {
                header("Location: register.php?error=Đã xảy ra lỗi khi đăng ký&$user_data");
                exit();
            }
        }
    }
} else {
    header("Location: register.php");
    exit();
}
?>