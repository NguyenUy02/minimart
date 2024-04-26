<?php 
session_start();
session_unset(); // Xóa tất cả các biến session
session_destroy(); // Hủy bỏ session hiện tại
header("Location: ../login.php");