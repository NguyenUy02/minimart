<?php 
$conn = mysqli_connect('localhost', 'root', '', 'minimart4')
or die('Could not connect to MySQL: ' . mysqli_connect_error());
mysqli_set_charset($conn, 'UTF8');
?>