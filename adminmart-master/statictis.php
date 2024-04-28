<?php
include 'header_admin.php';
include 'db_connect.php';
require_once("vendor/autoload.php"); // Đường dẫn đến autoload.php của thư viện PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
?>
<body>
    <div class="page-wrapper">  
        <h1 style="text-align: center">Thống kê doanh thu</h1>
        <div style="display: flex; justify-content: center">
            <form action="" method="post" class="form-inline" autocomplete="off">
                <div class="form-group">
                    <label for="startDate" class="mr-2">Ngày bắt đầu:</label>
                    <label for=""></label>
                    <div class="input-group">
                        <div class="datepicker-container">
                            <input id="ngayBatDau"
                                value="<?php echo (isset($_POST['ngayBatDau'])) ? $_POST['ngayBatDau'] : "" ?>"
                                name="ngayBatDau" type="date" class="form-control datepicker"
                                autocomplete="off" required="required">
                        </div>
                    </div>
                </div>
                <div class="form-group ml-4">
                    <label for="ngayKetThuc" class="mr-2">Ngày kết thúc:</label>
                    <div class="input-group">
                        <div class="datepicker-container">
                            <input id="ngayKetThuc"
                                value="<?php echo (isset($_POST['ngayKetThuc'])) ? $_POST['ngayKetThuc'] : "" ?>"
                                name="ngayKetThuc" type="date" class="form-control datepicker"
                                autocomplete="off" required="required">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ml-4" name="loc">Thống kê</button>
                <button type="submit" class="btn btn-success ml-2" name="inDoanhThu">In doanh thu</button>
            </form>
        </div>
        <?php
        if (isset($_POST["loc"])) {
            // Code lọc dữ liệu hiện tại
            $sql = "SELECT hoadon.MAHD, chitiethoadon.MASP, sanpham.TENSP, chitiethoadon.SOLUONGMUA, 
                    chitiethoadon.DONGIAXUAT FROM (hoadon join chitiethoadon on hoadon.MAHD = chitiethoadon.MAHD)
                    JOIN sanpham ON chitiethoadon.MASP = sanpham.MASP WHERE 
                    (hoadon.NGAYTAO <= '" . $_POST['ngayKetThuc'] . "') AND (hoadon.NGAYTAO >= '" . $_POST['ngayBatDau'] . "') AND hoadon.TINHTRANGDONHANG = 'Giao hàng thành công'";;
            $result = mysqli_query($conn, $sql);
            // Hiển thị dữ liệu trong bảng
            ?>
            <table class="table mt-4">
                <thead>
                <tr>
                    <th>Mã hóa đơn</th>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['MAHD'] ?></td>
                        <td><?php echo $row['MASP'] ?></td>
                        <td><?php echo $row['TENSP'] ?></td>
                        <td><?php echo $row['SOLUONGMUA'] ?></td>
                        <td><?php echo number_format($row['DONGIAXUAT']) ?></td>
                        <td>
                            <?php
                            $subtotal = $row['DONGIAXUAT'] * $row['SOLUONGMUA'];
                            echo number_format($subtotal);
                            $total += $subtotal;
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table> 
            <h4 class="mt-4 ml-3">Tổng doanh thu: <?php echo number_format($total) ?> VNĐ</h4>
            <?php
    } elseif (isset($_POST["inDoanhThu"])) {
        // Code để tạo và xuất file Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Tạo tiêu đề cho file Excel
        $sheet->setCellValue('A1', 'Mã hóa đơn');
        $sheet->setCellValue('B1', 'Mã sản phẩm');
        $sheet->setCellValue('C1', 'Tên sản phẩm');
        $sheet->setCellValue('D1', 'Số lượng');
        $sheet->setCellValue('E1', 'Đơn giá');
        $sheet->setCellValue('F1', 'Thành tiền');
    
        // Dữ liệu từ CSDL
        $sql = "SELECT hoadon.MAHD, chitiethoadon.MASP, sanpham.TENSP, chitiethoadon.SOLUONGMUA, 
                chitiethoadon.DONGIAXUAT FROM (hoadon join chitiethoadon on hoadon.MAHD = chitiethoadon.MAHD)
                JOIN sanpham ON chitiethoadon.MASP = sanpham.MASP WHERE 
                (hoadon.NGAYTAO <= '" . $_POST['ngayKetThuc'] . "') AND (hoadon.NGAYTAO >= '" . $_POST['ngayBatDau'] . "') AND hoadon.TINHTRANGDONHANG = 'Giao hàng thành công'";
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
            $sheet->setCellValueExplicit('F' . $row, $data['DONGIAXUAT'] * $data['SOLUONG'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $row++;
        }
        $totalCell = 'G2'; // Chọn ô G ở dòng tiếp theo
        $sheet->setCellValue('G1', 'Tổng tiền'); // Đặt chữ "Tổng tiền" vào ô F
        $sheet->setCellValue($totalCell, '=SUM(F2:F' . $row . ')');
    
        // Đặt tên file Excel và lưu nó vào desktop
        $desktopPath = 'D:\\';
        $filename = $desktopPath . 'doanh_thu_' . date('YmdHis') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        echo "In doanh thu thành công! Đã lưu tại: " . $filename;
    }
    
    ?>
    </div>
</body>

<?php
include 'footer_admin.php';
?>