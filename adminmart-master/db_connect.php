<?php
$conn = mysqli_connect('localhost', 'root', '', 'minimart4');
if (!$conn) {
    die('Không thể kết nối đến cơ sở dữ liệu: ' . mysqli_connect_error());
}
?>