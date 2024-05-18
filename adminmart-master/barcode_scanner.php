<?php
include 'header_admin.php';
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css" />
  <script type="text/javascript" src="jquery.js"></script>
  <script type="text/javascript" src="barcode.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      barcode.config.start = 0.1;
      barcode.config.end = 0.9;
      barcode.config.video = '#barcodevideo';
      barcode.config.canvas = '#barcodecanvas';
      barcode.config.canvasg = '#barcodecanvasg';
      barcode.setHandler(function(barcode) {
        // Gửi mã vạch đến server để lấy thông tin sản phẩm
        $.ajax({
          url: 'process_barcode.php',
          type: 'POST',
          data: { barcode: barcode },
          success: function(response) {
            var productInfo = JSON.parse(response);
            if (productInfo) {
              // Hiển thị thông tin sản phẩm trong form
              $('#masp').val(productInfo.MASP);
              $('#tensp').val(productInfo.TENSP);
              $('#soluong').val(1); // Đặt số lượng mặc định là 1
              $('#gia').val(productInfo.GIA);
              $('#sale').val(productInfo.SALE);

              // Hiển thị form
              $('#result').show();
            } else {
              // Ẩn form nếu không tìm thấy sản phẩm
              $('#result').hide();
            }
          },
          error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin sản phẩm:', error);
            // Ẩn form nếu có lỗi
            $('#result').hide();
          }
        });
      });
      barcode.init();

      // Truy cập vào thiết bị camera và hiển thị ảnh từ camera lên một phần tử video
      navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(stream) {
          var videoElement = document.getElementById('barcodevideo');
          videoElement.srcObject = stream;
          videoElement.play();
        })
        .catch(function(error) {
          console.log('Không thể truy cập vào camera: ', error);
        });
    });
  </script>
</head>
<body>
<div class="page-wrapper">
  <div id="barcode">
    <video id="barcodevideo" autoplay></video>
    <canvas id="barcodecanvasg"></canvas>
    <canvas id="barcodecanvas"></canvas>
  </div>
  <div id="result" style="display: none;">
    <form>
      <label for="masp">Mã sản phẩm:</label>
      <input type="text" id="masp" name="masp" readonly>
      <br>
      <label for="tensp">Tên sản phẩm:</label>
      <input type="text" id="tensp" name="tensp" readonly>
      <br>
      <label for="soluong">Số lượng:</label>
      <input type="number" id="soluong" name="soluong" value="1" min="1">
      <br>
      <label for="gia">Giá:</label>
      <input type="text" id="gia" name="gia" readonly>
      <br>
      <label for="sale">Sale:</label>
      <input type="text" id="sale" name="sale" readonly>
      <br>
      <button type="button" onclick="pay()">Thanh toán sản phẩm</button>
    </form>
  </div>
</body>
</html>

<?php include 'footer_admin.php';?>
<script>
    function pay() {
  // Lấy thông tin sản phẩm từ form
  var masp = $('#masp').val();
  var tensp = $('#tensp').val();
  var soluong = $('#soluong').val();
  var gia = $('#gia').val();
  var sale = $('#sale').val();

  // Gửi thông tin sản phẩm đến server để lưu vào cơ sở dữ liệu
  $.ajax({
    url: 'process_payment.php',
    type: 'POST',
    data: {
      masp: masp,
      tensp: tensp,
      soluong: soluong,
      gia: gia,
      sale: sale
    },
    success: function(response) {
      // Xử lý phản hồi từ server
      console.log(response);
      // Có thể hiển thị thông báo cho người dùng hoặc thực hiện các hành động khác
    },
    error: function(xhr, status, error) {
      console.error('Lỗi khi thanh toán sản phẩm:', error);
    }
  });
}
</script>