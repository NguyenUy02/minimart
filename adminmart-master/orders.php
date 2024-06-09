<?php
require 'db_connect.php';
include 'header_admin.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
  if (isset($_GET['input'])) {
      $input = $_GET['input'];
  } else {
      $input = '';
  }

  $sql = "SELECT h.MAHD, nd.TENND, SUM(c.DONGIAXUAT * c.SOLUONGMUA) AS 'TONGCONG',
              h.NGAYTAO, h.TINHTRANGDONHANG, c.SOLUONGMUA as SOLUONGMUA, nd.SDT, nd.DIACHI
          FROM hoadon h JOIN nguoidung nd ON h.MAND = nd.MAND
          JOIN chitiethoadon c ON h.MAHD = c.MAHD
          WHERE h.MAHD LIKE '%$input%' 
              OR nd.TENND LIKE '%$input%'  
              OR nd.SDT LIKE '%$input%'             
              OR h.TINHTRANGDONHANG LIKE '%$input%'
          GROUP BY h.MAHD, nd.TENND, nd.SDT, nd.DIACHI, h.NGAYTAO, h.TINHTRANGDONHANG
          ORDER BY h.NGAYTAO DESC";
} else {
  $input = '';
  $sql = "SELECT h.MAHD, nd.TENND, SUM(c.DONGIAXUAT * c.SOLUONGMUA) AS 'TONGCONG',
              h.NGAYTAO,
              h.TINHTRANGDONHANG,
              c.SOLUONGMUA as SOLUONGMUA,
              nd.SDT,
              nd.DIACHI
          FROM hoadon h JOIN nguoidung nd ON h.MAND = nd.MAND
          JOIN chitiethoadon c ON h.MAHD = c.MAHD
          GROUP BY h.MAHD, nd.TENND, nd.SDT, nd.DIACHI, h.NGAYTAO, h.TINHTRANGDONHANG
          ORDER BY h.NGAYTAO DESC";
}

$result = $conn->query($sql);
$list = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<title>Danh sách hóa đơn</title>
<body>
    <div class="page-wrapper">   
    <div class="d-flex justify-content-between align-items-center ">
    <h1 class="ml-4">Hóa đơn</h1>
    <div class="d-flex">
        <form action="" method="get" class="d-flex mr-4">
            <input type="text" name="input" value="<?php echo isset($_GET['input']) ? $_GET['input'] : ''; ?>" 
                placeholder="Tìm kiếm" class="form-control me-2">
            <button type="submit" name="search" class="btn btn-primary">Tìm</button>
        </form>
    </div>
</div>   
        <table class="table" style="color: black;">
        <tr align="center">
            <th>Mã hóa đơn</th>
            <th>Ngày tạo</th>
            <th>Tên khách hàng</th>
            <th>SDT</th>
            <th>Địa chỉ</th>
            <th>Tình trạng đơn</th>
            <th>Tổng tiền</th>
            <th>Chức năng</th>
        </tr>
       
        <?php foreach ($list as $row) { ?>
            <tr align="center">
                <td><?php echo $row["MAHD"]; ?></td>
                <td><?php echo date('d/m/Y H:i:s', strtotime($row["NGAYTAO"])); ?></td>
                <td><?php echo $row["TENND"]; ?></td>
                <td><?php echo $row["SDT"]; ?></td>
                <td><?php echo $row["DIACHI"]; ?></td>
                <td style="color:
                    <?php
                        if ($row["TINHTRANGDONHANG"] === "Đang xử lý") {
                            echo 'red'; // Đang xử lý: màu đỏ
                        } elseif ($row["TINHTRANGDONHANG"] === "Giao hàng thành công") {
                            echo 'green'; // Giao hàng thành công: màu xanh lá
                        } elseif ($row["TINHTRANGDONHANG"] === "Đang giao hàng") {
                            echo 'black'; // Đang giao hàng: màu đen
                        } elseif ($row["TINHTRANGDONHANG"] === "Giao hàng thất bại") {
                            echo 'orange'; // Giao hàng thất bại: màu cam
                        } else {
                            echo 'transparent'; // Màu mặc định nếu không khớp với bất kỳ tình trạng nào khác
                        }
                    ?>;
                ">
                    <?php echo $row["TINHTRANGDONHANG"]; ?>
                </td>
                <td><?php echo number_format($row["TONGCONG"], 0, ',', '.'); ?> VND</td>
                <td>
                    <button type="button" class="btn btn-success mb-1 inhoadon" 
                            data-id="<?php echo $row["MAHD"]; ?>"
                            data-toggle="modal" data-target="#inhoadonModal">
                            <i class='fa fa-print'></i> In
                    </button>
                    <button type="button" class="btn btn-primary mb-1 chitiethoadon" 
                            data-id="<?php echo $row["MAHD"]; ?>"
                            data-toggle="modal" data-target="#chitiethoadonModal">
                        <i class='fa fa-search'></i> Xem 
                    </button>
                    <button type="button" class="btn btn-secondary capnhathoadon" 
                            data-id="<?php echo $row["MAHD"]; ?>"
                            data-toggle="modal" data-target="#capnhathoadonModal">
                        <i class="fa fa-refresh"></i></i>Cập nhật hóa đơn
                    </button>
                </td>
            </tr>
        <?php } ?>

    </table>
    <div style="display: flex; width: 100%;">
  
</div>
    </div>
</body>
<?php
include 'footer_admin.php';
?>
<style>
    body {
        font-family: Arial, sans-serif;
    }
</style>
<div class="modal fade" id="chitiethoadonModal" tabindex="-1" role="dialog" aria-labelledby="chitiethoadonModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="chitiethoadonModalLabel"><b>Chi Tiết Hóa Đơn</b></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span><b>Ngày tạo</b></span> <span id="ngaytao"></span>
        <br/>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Tên Sản Phẩm</th>
              <th scope="col">Đơn Giá</th>
              <th scope="col">Số Lượng</th>
              <th scope="col">Thành Tiền</th>
            </tr>
          </thead>
          <tbody id="detail"></tbody>
        </table>
        <div style="text-align: right; padding-top: 10px;">
          <span><b>Tổng</b></span>
          <span id="total"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="capnhathoadonModal" tabindex="-1" role="dialog" aria-labelledby="capnhathoadonModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="capnhathoadonModalLabel"><b>Cập Nhật Hóa Đơn</b></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span><b>Mã Hóa Đơn</b></span> <span id="maHD"></span><br />
        <span><b>Ngày Tạo</b></span> <span id="ngaytaoHD"></span><br />
        <div class="form-group">
            <label for="tinhtrang">Tình trạng đơn hàng:</label>
            <select class="form-control" id="tinhtrang" name="tinhtrang">
                <option value="Đang xử lý">Đang xử lý</option>
                <option value="Đang giao hàng">Đang giao hàng</option>
                <option value="Giao hàng thành công">Giao hàng thành công</option>
                <option value="Giao hàng thất bại">Giao hàng thất bại</option>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-success" id="luuChinhSua">Lưu</button>
      </div>
    </div>
  </div>
</div>

<script>

$(function(){
  $(document).on('click', '.chitiethoadon', function(e){
    e.preventDefault();

    $('#chitiethoadon').modal('show');
    var id = $(this).data('id');
    
    $.ajax({
      type: 'POST',
      url: 'order_view.php',
      data: {id:id},
      dataType: 'json',
      success:function(response){
        $('#ngaytao').html(response.ngaytao);
        $('#maHD').html(response.maHD);
        $('#detail').html(response.list);
        $('#total').html(response.total);
      }
    });
  });

  $("#chitiethoadon").on("hidden.bs.modal", function () {
      $('.prepend_items').remove();
  });
});


$(function(){
  $(document).on('click', '.capnhathoadon', function(e){
    e.preventDefault();
    
    // Lấy giá trị id từ data-attribute của nút
    var id = $(this).data('id');
    
    $('#capnhathoadon').modal('show');
    
    $.ajax({
      type: 'POST',
      url: 'order_update.php',
      data: {id: id},
      dataType: 'json',
      success:function(response){
        $('#maHD').html(response.maHD);
        $('#ngaytaoHD').html(response.ngaytaoHD);
        // Đặt giá trị cho combo box
        $('#tinhtrang').val(response.tinhtrang);
        
        // Truyền giá trị id vào hàm xuất hiện modal
        setupLuuChinhSua(id);
      }
    });
  });

  function setupLuuChinhSua(id) {
    // Sự kiện click của nút "Lưu"
    $(document).on('click', '#luuChinhSua', function(e){
      e.preventDefault();
  
      // Lấy giá trị từ combo box
      var tinhtrang = $('#tinhtrang').val();
  
      // Gửi dữ liệu đến file xử lý lưu
      $.ajax({
        type: 'POST',
        url: 'order_save.php', // Đặt tên file PHP xử lý lưu
        data: {id: id, tinhtrang: tinhtrang},
        dataType: 'json',
        success:function(response){
          // Xử lý kết quả nếu cần thiết
          location.reload();
        }
      });
    });
  }


  $("#capnhathoadonModal").on("hidden.bs.modal", function () {
    $('#maHD').html('');
    $('#ngaytaoHD').html('');
    $('#update_tinhtrang').html('');
  });
});
$(function(){
  $(document).on('click', '.inhoadon', function(e){
    e.preventDefault();

    $('#inhoadon').modal('show');
    var id = $(this).data('id');
    
    $.ajax({
    type: 'POST',
    url: 'Print_order.php',
    data: {id:id},
    dataType: 'json',
    success:function(response){
        if (response.status === 'success') {
            alert(response.message);
        } else {
            alert(response.message);
        }
        $('#ngaytao').html(response.ngaytao);
        $('#maHD').html(response.maHD);
        $('#detail').html(response.list);
        $('#total').html(response.total);
    }
});
  });

  $("#chitiethoadon").on("hidden.bs.modal", function () {
      $('.prepend_items').remove();
  });
});
</script>

