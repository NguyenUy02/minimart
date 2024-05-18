<?php
include 'header_admin.php';
require 'db_connect.php';
?>
<title>AdminMiniMart</title>
<body>
    <div class="page-wrapper">
 
        <div class="container-fluid">
            <div class="card-group">
                <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">    
                        <div>
                        <?php 
                            $sql_countKH = "SELECT COUNT(*)-1 FROM nguoidung";
                            $kq = mysqli_query($conn, $sql_countKH);
                            $kq = mysqli_fetch_row($kq);
                        ?>    
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium"><?php echo $kq[0] ?></h2>
                                <span
                                    class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">...</span>
                            </div>
                            <h6 class="text-dark font-weight-normal mb-0 w-100 text-truncate">Khách hàng</h6>
                        </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-dark"><i data-feather="user"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                            <?php                 
                                $sql_countHD = "SELECT COUNT(*) FROM hoadon";
                                $kq = mysqli_query($conn, $sql_countHD);
                                $kq = mysqli_fetch_row($kq);
                            ?>
                                <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><sup
                                        class="set-doller"> +</sup><?php echo $kq[0] ?></h2>
                                <h6 class="text-dark font-weight-normal mb-0 w-100 text-truncate">Tổng đơn đặt hàng
                                </h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-dark"><i data-feather="file-plus"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">...</h2>
                                    <span
                                        class="badge bg-danger font-12 text-white font-weight-medium badge-pill ml-2 d-md-none d-lg-block">...</span>
                                </div>
                                <h6 class="text-dark font-weight-normal mb-0 w-100 text-truncate">Sản phẩm bán được</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-dark"><i data-feather="file-plus"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <?php 
                            $sql_countSP = "SELECT COUNT(*) FROM sanpham";
                            $kq = mysqli_query($conn, $sql_countSP);
                            $kq = mysqli_fetch_row($kq);
                        ?>
                            <div>
                                <h2 class="text-dark mb-1 font-weight-medium"><?php echo $kq[0] ?></h2>
                                <h6 class="text-dark font-weight-normal mb-0 w-100 text-truncate">Sản phẩm</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-dark"><i data-feather="grid"></i></span>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="card">
            <div class="card-body">
    <form class="form-inline">
        <div class="form-group">
            <label class="mr-2" style="padding: 10px;">Chọn năm: </label>
            <select class="form-control input-sm" id="select_year">
                <?php
                $currentYear = date('Y');
                for ($i = $currentYear - 1; $i <= $currentYear + 10; $i++) {
                    $selected = ($i == $year) ? 'selected' : '';
                    echo "<option value='" . $i . "' " . $selected . ">" . $i . "</option>";
                }
                ?>
            </select>
        </div>
    </form>
    <div class="mt-2"></div>
    <div id="legend" class="text-center"></div>
    <canvas id="barChart" width="1150" height="500"></canvas>
    <div id="debug-months"></div>
    <div id="debug-sales"></div>
</div>

<?php
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$months = array();
$sales = array();
$totalRevenue = 0;

// Khởi tạo mảng giá trị ban đầu cho tất cả 12 tháng
for ($m = 1; $m <= 12; $m++) {
    array_push($sales, 0);
    array_push($months, date('M', mktime(0, 0, 0, $m, 1)));
}

// Sử dụng một truy vấn để lấy tổng cho từng tháng trong năm được chọn
$stmt = $conn->prepare("SELECT MONTH(hoadon.NGAYTAO) AS month, SUM(chitiethoadon.DONGIAXUAT * chitiethoadon.SOLUONGMUA) AS total
                        FROM chitiethoadon
                        LEFT JOIN hoadon ON hoadon.MAHD=chitiethoadon.MAHD 
                        LEFT JOIN sanpham ON sanpham.MASP=chitiethoadon.MASP 
                        WHERE YEAR(hoadon.NGAYTAO)=? AND hoadon.TINHTRANGDONHANG='Giao hàng thành công'
                        GROUP BY MONTH(hoadon.NGAYTAO)");
$stmt->bind_param("s", $year);
$stmt->execute();

$result = $stmt->get_result();

// Lấy dữ liệu từ kết quả truy vấn và đưa vào mảng
while ($srow = $result->fetch_assoc()) {
    $sales[$srow['month'] - 1] = round($srow['total'], 2);
    $totalRevenue += $srow['total'];
}

$stmt->close();

$months = json_encode($months);
$sales = json_encode($sales);
?>

<!-- End Chart Data -->

<!-- Hiển thị tổng doanh thu -->
<div style="text-align: center;"><b>Tổng doanh thu: <?php echo number_format($totalRevenue); ?> VNĐ</b></div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function drawChart() {
        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var barChartData = {
            labels: <?php echo $months; ?>,
            datasets: [
                {
                    label: 'Doanh thu',
                    backgroundColor: 'rgba(153, 102, 255, 0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: <?php echo $sales; ?>
                }
            ]
        };

        console.log('Months:', <?php echo $months; ?>);
        console.log('Sales:', <?php echo $sales; ?>);

        var barChartOptions = {
            // Các tùy chọn khác của biểu đồ
        };

        barChartOptions.datasetFill = false;
        var myChart = new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });

        document.getElementById('legend').innerHTML = myChart.generateLegend();

        // Lưu trạng thái của đồ thị vào session storage
        sessionStorage.setItem('chartDrawn', 'true');
    }

    $(function () {
        // Lấy năm hiện tại
        var currentYear = <?php echo date('Y'); ?>;
        var selectedYear = <?php echo $year; ?>;

        // Thiết lập giá trị mặc định cho dropdown
        $('#select_year').val(selectedYear);

        // Gọi hàm vẽ biểu đồ
        drawChart();

        // Lắng nghe sự kiện thay đổi của select
        $('#select_year').change(function () {
            // Gọi hàm thay đổi năm và lưu vào localStorage
            changeYearAndSave($(this).val());
        });

        // Hàm để thay đổi trang và lưu giá trị vào localStorage
        function changeYearAndSave(value) {
            window.location.href = 'Index.php?year=' + value;
            localStorage.setItem('selectedYear', value);
        }
    });
</script>
<?php

include 'footer_admin.php';
?>
<style>
    ul {
    list-style-type: none; /* Loại bỏ dấu chấm của danh sách */
}

/* CSS tùy chọn nếu bạn muốn giữ dấu chấm cho các mục danh sách khác */
ul li {
    list-style-type: none;
}
.small-box .inner  {
    color: #FFFFFF;/* Mã màu hoặc tên màu bạn muốn sử dụng */;
}

.small-box-footer {
    color: #FFFFFF !important;
}
</style>