<?php
include 'header_admin.php';
include 'db_connect.php';
require_once("vendor/autoload.php"); // Đường dẫn đến autoload.php của thư viện PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
?>
<body>
    <div class="page-wrapper">  
    <h1 style="text-align:center">Tính toán số sản phẩm bán được theo loại</h1>

<div style="display:flex;justify-content:center">
    <form action="" method="post" class="form-inline" autocomplete="off">
        <div class="form-group">
            <label for="startDate" class="mr-2">Ngày bắt đầu:</label>
            <div class="input-group">
                <div class="datepicker-container">
                    <input id="ngayBatDau" name="ngayBatDau" type="date"
                        class="form-control datepicker" autocomplete="off" required="required"
                        value="<?php echo (isset($_POST['ngayBatDau'])) ? $_POST['ngayBatDau'] : "" ?>">
                </div>
            </div>
        </div>
        <div class="form-group ml-4">
            <label for="endDate" class="mr-2">Ngày kết thúc:</label>
            <div class="input-group">
                <div class="datepicker-container">
                    <input id="ngayKetThuc" name="ngayKetThuc" type="date"
                        class="form-control datepicker" autocomplete="off" required="required"
                        value="<?php echo (isset($_POST['ngayKetThuc'])) ? $_POST['ngayKetThuc'] : "" ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php
            $sql_sp = "SELECT MALSP, TENLSP FROM loaisanpham";
            $result_sp = mysqli_query($conn, $sql_sp);
            ?>
            <label for="loaiSanPham" class="mr-2">Loại sản phẩm:</label>
            <select id="loaisp" name="loaisp" class="form-control">
                <option value="">-- Chọn loại sản phẩm --</option>
                <?php
                while ($row_sp = mysqli_fetch_assoc($result_sp)) {
                ?>
                    <option value="<?php echo $row_sp['MALSP'] ?>">
                        <?php echo $row_sp['TENLSP'] ?>
                    </option>
                <?php
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary ml-4" name="tinhtoan">Tính toán</button>
        <button type="submit" class="btn btn-success ml-2" name="inExcel">In excel</button>
    </form>
</div>

<?php
if (isset($_POST['tinhtoan'])) {
    $sql_tt = "SELECT sanpham.TENSP, chitiethoadon.SOLUONGMUA AS TONGSOLUONG , chitiethoadon.SOLUONGMUA * chitiethoadon.DONGIAXUAT AS TONGBANDUOC
               FROM ((hoadon JOIN chitiethoadon ON hoadon.MAHD = chitiethoadon.MAHD)
               JOIN sanpham ON chitiethoadon.MASP = sanpham.MASP)
               JOIN loaisanpham ON sanpham.MALSP = loaisanpham.MALSP
               WHERE (sanpham.MALSP = '" . $_POST["loaisp"] . "') 
               AND (hoadon.NGAYTAO <= '" . $_POST['ngayKetThuc'] . "') 
               AND (hoadon.NGAYTAO >= '" . $_POST['ngayBatDau'] . "') 
               AND hoadon.TINHTRANGDONHANG = 'Giao hàng thành công'
               GROUP BY sanpham.TENSP
               ORDER BY TONGBANDUOC DESC";

    $result_tt = mysqli_query($conn, $sql_tt);
    ?>
    <table class="table table-striped mt-2">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng bán được</th>
                <th>Tổng tiền bán được</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Duyệt qua tất cả các dòng kết quả
            while ($row = mysqli_fetch_assoc($result_tt)) {
            ?>
                <tr>
                    <td><?php echo $row['TENSP'] ?></td>
                    <td><?php echo $row['TONGSOLUONG'] ?></td>
                    <td><?php echo number_format($row['TONGBANDUOC']) ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
<?php
} elseif (isset($_POST["inExcel"])) {
    // Code để tạo và xuất file Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Tạo tiêu đề cho file Excel
    $sheet->setCellValue('A2', 'Tên sản phẩm');
    $sheet->setCellValue('B2', 'Số lượng bán được');
    $sheet->setCellValue('C2', 'Tổng tiền bán được');

    // Dữ liệu từ CSDL
    $sql_tt = "SELECT sanpham.TENSP, chitiethoadon.SOLUONGMUA AS TONGSOLUONG, chitiethoadon.SOLUONGMUA * chitiethoadon.DONGIAXUAT AS TONGBANDUOC, loaisanpham.TENLSP AS TLSP
        FROM ((hoadon JOIN chitiethoadon ON hoadon.MAHD = chitiethoadon.MAHD)
        JOIN sanpham ON chitiethoadon.MASP = sanpham.MASP)
        JOIN loaisanpham ON sanpham.MALSP = loaisanpham.MALSP
        WHERE (sanpham.MALSP = '" . $_POST["loaisp"] . "') 
        AND (hoadon.NGAYTAO <= '" . $_POST['ngayKetThuc'] . "') 
        AND (hoadon.NGAYTAO >= '" . $_POST['ngayBatDau'] . "') 
        AND hoadon.TINHTRANGDONHANG = 'Giao hàng thành công'
        GROUP BY sanpham.TENSP
        ORDER BY TONGBANDUOC DESC";

    $result_tt = mysqli_query($conn, $sql_tt);

    // Kiểm tra lỗi SQL
    if (!$result_tt) {
        die('Query Error: ' . mysqli_error($conn));
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A2', 'Tên sản phẩm');
    $sheet->setCellValue('B2', 'Số lượng bán được');
    $sheet->setCellValue('C2', 'Tổng tiền bán được');

    $row = 3;
    $tlspValue = ''; // Khởi tạo biến để giữ giá trị TLSP

    while ($data = mysqli_fetch_assoc($result_tt)) {
        
        $sheet->setCellValueExplicit('A' . $row, $data['TENSP'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('B' . $row, $data['TONGSOLUONG'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $sheet->setCellValueExplicit('C' . $row, $data['TONGBANDUOC'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $row++;

        // Lưu giá trị TLSP nếu tồn tại
        if (isset($data['TLSP'])) {
            $tlspValue = $data['TLSP'];
        }
    }

    // Đặt giá trị TLSP sau khi vòng lặp kết thúc
    $sheet->setCellValue('A1', $tlspValue);

    $desktopPath = 'C:\\Users\\Admin\\Desktop\\';
    $filename = $desktopPath . 'tong_sp_ban' . date('YmdHis') . '.xlsx';

    try {
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);
        echo "In thành công! Đã lưu tại: " . $filename;
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}

?>
    </div>
</body>

<?php
include 'footer_admin.php';
?>