<?php 
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'thuctap2');
$conn = mysqli_connect(DB_HOST , DB_USER, '', DB_NAME)
or die('Could not connect to MySQL: ' . mysqli_connect_error());
mysqli_set_charset($conn, 'UTF8');
// DB credentials.

// Establish database connection.
try {
    $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}
?>