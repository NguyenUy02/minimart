<?php
session_start();
include("connect.php");

if (isset($_POST['SDT']) && isset($_POST['MATKHAU'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $sdt = validate($_POST['SDT']);
    $matkhau = validate($_POST['MATKHAU']);
    $user_data = 'SDT=' . $email;

    if (empty($sdt)) {
        header("Location: login.php?error=Vui lòng nhập số điện thoại đăng nhập đăng nhập&$user_data");
        exit();
    } elseif (empty($matkhau)) {
        header("Location: login.php?error=Vui lòng nhập mật khẩu&$user_data");
        exit();
    } else {
        $sql = "SELECT * FROM nguoidung WHERE SDT='$sdt'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['MATKHAU'] === $matkhau && $row['EMAIL'] === $email && $row['ISADMIN'] ==0) {
                $_SESSION['TENND'] = $row['TENND'];
                $_SESSION['MAND'] = $row['MAND'];
				$_SESSION['GIOITINH'] = $row['GIOITINH'];
                $_SESSION['SDT'] = $row['SDT'];
                $_SESSION['DIACHI'] = $row['DIACHI'];
                

                $slgh = "SELECT COUNT(giohang.SOLUONG) AS total FROM giohang JOIN nguoidung ON giohang.MAND = nguoidung.MAND WHERE giohang.MAND = '{$row['MAND']}'";
                $result = mysqli_query($conn, $slgh);
                $row = mysqli_fetch_assoc($result);
                $_SESSION['SLGH'] = $row['total'];

                header("Location: index.php");
                exit();
            }elseif($row['MATKHAU'] === $matkhau && $row['SDT'] === $email && $row['ISADMIN'] ==1){
                $_SESSION['TENND'] = $row['TENND'];
                $_SESSION['MAAD'] = $row['MAND'];
				$_SESSION['GIOITINH'] = $row['GIOITINH'];
                $_SESSION['SDT'] = $row['SDT'];
                $_SESSION['DIACHI'] = $row['DIACHI'];
                
                header("Location: adminmart-master/index.html");
            } 
            else {
                header("Location: login.php?error=Sai tên đăng nhập hoặc mật khẩu&$user_data");
                exit();
            }
        } else {
            header("Location: login.php?error=Sai tên đăng nhập hoặc mật khẩu&$user_data");
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}
?>