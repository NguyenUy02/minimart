<?php
require_once 'db_connect.php';
require_once 'vendor/autoload.php'; // Đường dẫn đến autoload.php của thư viện PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
   

    // Tạo và xuất file Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Tạo tiêu đề cho file Excel
    $sheet->setCellValue('A1', 'Mã hóa đơn');
    $sheet->setCellValue('B1', 'Mã sản phẩm');
    $sheet->setCellValue('C1', 'Tên sản phẩm');
    $sheet->setCellValue('D1', 'Số lượng');
    $sheet->setCellValue('E1', 'Đơn giá');
    $sheet->setCellValue('F1', 'Thành tiền');

    // Lấy dữ liệu từ CSDL
    $sql = "SELECT hoadon.MAHD, chitiethoadon.MASP, sanpham.TENSP, chitiethoadon.SOLUONGMUA, 
           chitiethoadon.DONGIAXUAT 
           FROM (hoadon JOIN chitiethoadon ON hoadon.MAHD = chitiethoadon.MAHD)
           JOIN sanpham ON chitiethoadon.MASP = sanpham.MASP
           WHERE hoadon.MAHD = '$id'";
    $result = mysqli_query($conn, $sql);

    // Dòng bắt đầu để ghi dữ liệu vào file Excel
    $row = 2;

    // Ghi dữ liệu từ CSDL vào file Excel
    while ($data = mysqli_fetch_assoc($result)) {
        $sheet->setCellValueExplicit('A' . $row, $data['MAHD'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('B' . $row, $data['MASP'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('C' . $row, $data['TENSP'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('D' . $row, $data['SOLUONGMUA'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $sheet->setCellValueExplicit('E' . $row, $data['DONGIAXUAT'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $sheet->setCellValueExplicit('F' . $row, $data['DONGIAXUAT'] * $data['SOLUONGMUA'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $row++;
    }

    $totalCell = 'G2'; // Chọn ô G ở dòng tiếp theo
    $sheet->setCellValue('G1', 'Tổng tiền'); // Đặt chữ "Tổng tiền" vào ô F
    $sheet->setCellValue($totalCell, '=SUM(F2:F' . $row . ')');

    // Đặt tên file Excel và lưu nó vào desktop
    $desktopPath = 'D:\\';
    $filename = $desktopPath . 'hoa_don_' . $id . '_' . date('YmdHis') . '.xlsx';
    $writer = new Xlsx($spreadsheet);
    $writer->save($filename);

    echo "In hóa đơn thành công! Đã lưu tại: " . $filename;
}
?>