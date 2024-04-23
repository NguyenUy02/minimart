<?php
include 'login.php';
include 'connect.php';

$result = mysqli_query($conn, "SELECT * FROM nguoidung WHERE nguoidung.MAND = '{$_SESSION['MAND']}'");
if (isset($_POST["saveChanges"])) {
    $tennd = $_POST["TENND"];
    $diachi = $_POST["DIACHI"];
    $sdt = $_POST["SDT"];

    $tennd_error = $diachi_error = $sdt_error =  "";
    $error_check = false;

    if (empty($tennd)) {
        $tenkh_error = "tennd_error=Tên không được để trống";
        $error_check = true;
    }
    if (empty($diachi)) {
        $diachi_error = "diachi_error=Địa chỉ không được để trống";
        $error_check = true;
    }
    if (empty($sdt)) {
        $sdt_error = "sdt_error=Số điện thoại không được để trống";
        $error_check = true;
    }
    
    
    if ($error_check) {
        $error_query =  $tennd_error ."&".  $diachi_error ."&". $sdt_error ."&". $email_error;       
        header("Location: user_changeinfo.php?" . $error_query);
        exit();
    }
    else {
        mysqli_query($conn, "UPDATE nguoidung 
    SET TENND = '$tennd', DIACHI = '$diachi', SDT = '$sdt'
    WHERE nguoidung.MAND = '{$_SESSION['MAND']}'");
    }
}
header("Location: user_changeinfo.php?$check");
?>