<?php
require 'db_connect.php';

$id = $_POST['id'];

$sql = "SELECT
            NGAYTAO,
            MAHD,
            TINHTRANGDONHANG
        FROM
            HOADON
        WHERE MAHD = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $id);
$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $output['maHD'] = $row['MAHD'];
    $output['ngaytaoHD'] = date('d \t\h\á\n\g m \n\ă\m Y', strtotime($row['NGAYTAO']));
    $output['tinhtrang'] = $row['TINHTRANGDONHANG'];
}

$stmt->close();
mysqli_close($conn);

echo json_encode($output);
?>