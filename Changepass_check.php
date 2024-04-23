<?php
include("login_required.php"); 

include "connect.php";

if (isset($_POST['MATKHAU']) && isset($_POST['MATKHAUMOI']) && isset($_POST['CONFIRM_MATKHAU'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $op = validate($_POST['MATKHAU']);
    $np = validate($_POST['MATKHAUMOI']);
    $c_np = validate($_POST['CONFIRM_MATKHAU']);
    $op_error =  $c_np_error=$np_error="";
    $error_check = false;

    if (empty($op)) {
        $op_error = "op_error=Yêu cầu nhập mật khẩu hiện tại";
        $error_check = true;
    }
    if (empty($np)) {
        $np_error = "np_error=Yêu cầu nhập mật khẩu mới";
        $error_check = true;
    }
    if ($np !== $c_np) {
        $c_np_error = "c_np_error=Mật khẩu không khớp";
        $error_check = true;

    }
    if ($error_check) {
        $error_query =  $op_error ."&".  $np_error ."&". $c_np_error ;       
        header("Location: Change_password.php?" . $error_query);
        exit();
    } else {
        $id = $_SESSION['MAND'];
        $sql = "SELECT MATKHAU
                FROM nguoidung WHERE 
                MAND='$id' AND MATKHAU='$op'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {

            $sql_2 = "UPDATE nguoidung
        	          SET MATKHAU='$np'
        	          WHERE MAND='$id'";
            mysqli_query($conn, $sql_2);
            header("Location: Change_password.php?success=Đổi mật khẩu thành công");
            exit();

        } else {
            header("Location: Change_password.php?error=Incorrect password");
            exit();
        }

    }


} else {
    header("Location: index.php");
    exit();
}

