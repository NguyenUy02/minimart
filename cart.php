<?php include 'header.php'; 
include 'login_required.php'; 
if(!isset($_SESSION['MAND']))
{
    header("Location: login.php");  
    exit(); 
}
?>
<title>Giỏ hàng</title>
 <!-- Cart Page Start -->
<div class="container-fluid py-5" >
    <div class="container py-5" >
    <h1 class="mb-4">Giỏ hàng</h1>
        <div class="table-responsive">
        <?php                
            $result = mysqli_query($conn, "SELECT sanpham.*, thuonghieu.*, thongtinsanpham.*, giohang.SOLUONG as SLGH, sanpham.GIA as DGSP, sanpham.SALE as sale,sanpham.SOLUONG as SLSP
            FROM giohang JOIN sanpham ON giohang.MASP = sanpham.MASP JOIN thongtinsanpham ON sanpham.MATTSP = thongtinsanpham.MATTSP
                JOIN thuonghieu ON sanpham.MATH = thuonghieu.MATH
                WHERE giohang.MAND = '{$_SESSION['MAND']}'");
            ?>
            <?php if (mysqli_num_rows($result) == 0): ?>
                <h3 class="text-muted">Không có sản phẩm trong giỏ hàng</h3>
            <?php else: ?>
            <table class="table" style="color: black;">
                <thead>
                    <tr>
                    <th scope="col" width="60"> </th>
                    <th scope="col" width="150">Sản phẩm</th>
                    <th scope="col">Tên</th>
                    <th scope="col" width="150">Giá</th>
                    <th scope="col" width="150">Số lượng</th>
                    <th scope="col" width="150">Thành tiền</th>
                    <th scope="col"></th>                  
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td class="text-center align-middle">
                        <input type="checkbox" class="col-9 sanpham-checkbox pt-4" style="height: 20px"
                            id="sanpham" data-idsp="<?php echo $row['MASP']?>" onchange="calculateTotalPrice()" />
                    </td>
                    <td>
                        <div>
                            <img src="img/<?php echo $row['ANH']?>" style="width: 80px; height: 80px;" alt="">
                        </div>
                    </td>
                    <td>
                        <p class="mb-0 mt-4"><?php echo $row['TENSP']?></p>
                    </td>
                    <td>
                        <p class="mb-0 mt-4">
                        <?php if ($row['SALE'] > 0) { ?>
                                    <var class="price pt-2 sale-price"
                                        id="giaSP_<?php echo $row['MASP']?>">  <?php echo $row['sale']; ?></var>
                                <?php } else { ?>
                                    <var class="price pt-2"
                                        id="giaSP_<?php echo $row['MASP']?>">  <?php echo $row['DGSP']; ?></var>
                                <?php } ?>
                        </p>
                    </td>
                    <!-- Nút tăng giảm số lượng -->
                    <td>
                        <div class="input-group quantity mt-4" style="width: 100px;">
                            <div class="input-group-btn">
                                <button onclick="decreaseQuantity('<?php echo $row['MASP']?>')" class="btn btn-sm btn-minus rounded-circle bg-light border" type="button">
                                <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input id="soluong_<?php echo $row['MASP']; ?>" type="text" class="form-control form-control-sm text-center border-0" 
                                  value="<?php echo $row['SLGH']; ?>" min="1" max="<?php echo $row['SLSP']; ?>">
                            <div class="input-group-btn">
                                <button onclick="increaseQuantity('<?php echo $row['MASP']?>')" class="btn btn-sm btn-plus rounded-circle bg-light border" type="button">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                    <!-- Thành tiền -->
                    <td>
                        <p class="mb-0 mt-4">
                        <?php if ($row['SALE'] > 0) { ?>
                                    <span class="price pt-2 item-total">
                                        <?php echo $row['SALE'] * $row['SLGH']; ?>
                                    </span>
                                <?php } else { ?>
                                    <span  class="price pt-2 item-total">
                                        <?php echo $row['DGSP'] * $row['SLGH']; ?>
                                    </span>
                                <?php } ?>
                        </p>
                    </td>
                    <!-- Nút xóa -->
                    <td>
                        <button id="xoaSP_<?php echo $row['MASP']?>" class="btn btn-md rounded-circle bg-light border mt-4" data-masp="<?php echo $row['MASP']?>">
                            <i class="fa fa-times text-danger"></i>
                        </button>
                    </td>                    
                </tr>
                <?php endwhile; ?>                   
                </tbody>
            </table><?php endif; ?>
        </div>

        <div class="row g-4 justify-content-end">
            <div class="col-8"></div>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded" style="color: black;">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">Tổng hóa đơn</h1>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Tổng tiền:</h5>
                            <strong class="mb-0" id="TongTien">0</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0 me-4">Phí</h5>                        
                                <p class="mb-0">Vận chuyển: </p>       
                        </div>
                    </div>
                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                        <h5 class="mb-0 ps-4 me-4">Thành tiền</h5>
                        <strong class="mb-0 pe-4" id="ThanhTien">0</strong>
                    </div>
                    <a href="cart_check.php" id="btnThanhToan" class="btn border-secondary rounded-pill px-4 py-3 text-success text-uppercase mb-4 ms-4">Mua</a>
                </div>
            </div>
        </div>
        <form id="hiddenForm" action="cart_check.php" method="POST">
    <input type="hidden" name="selectedProducts" id="hiddenSelectedProducts">
</form>
    </div>
</div>
<!-- Cart Page End -->

<script>
    // hàm hiển thị thông báo cạnh viền   
    $(function () {
        // Lấy các phần tử DOM cần thiết
        var checkboxes = document.querySelectorAll('[id="sanpham"]');
        var checkAllCheckbox = document.getElementById('check-all');

        // Thiết lập sự kiện cho checkbox check-all
        $("#check-all").click(function () {
            for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
            }
            calculateTotalPrice();
            calculateSelectedCount();
        });

        // Thiết lập sự kiện cho các checkbox sản phẩm
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
            calculateTotalPrice();
            calculateSelectedCount();
        // Kiểm tra nếu tất cả các checkbox sản phẩm đều được chọn
            var allChecked = Array.from(checkboxes).every(function (checkbox) {
            return checkbox.checked;
            });
            // Cập nhật trạng thái của checkbox "Tất cả"
            checkAllCheckbox.checked = allChecked;
            });
        });
    });

    function calculateSelectedCount() {
        var checkboxes = document.querySelectorAll('.sanpham-checkbox');
        var countElement = document.querySelector('.countslsp');
        var countElement1 = document.querySelector('.countslsp1');
        var selectedCount = 0;

        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
            selectedCount++;
            }
    });

        countElement.innerText = selectedCount;
        countElement1.innerText = selectedCount;
    }

    // Cập nhật số lượng vào csdl
    function updateCart(idsp, soluong) {
    $.ajax({
        type: "POST",
        url: "cart_update.php",
        data: { MASP: idsp, SOLUONG: soluong },
        success: function (response) {
        var result = JSON.parse(response);
        if (!result.success) {
            alert("Có lỗi xảy ra khi cập nhật giỏ hàng!");
        }
        },
        error: function () {
        alert("Có lỗi xảy ra khi cập nhật giỏ hàng!");
        }
    });
    }

    // Xóa sản phẩm khỏi giỏ hàng
    $('[id^="xoaSP_"]').click(function (e) {
        e.preventDefault();
        var masp = $(this).data('masp');
        var currentRow = $(this).closest('tr');

        $.ajax({
            url: 'cart_delete.php',
            type: 'POST',
            data: { MASP: masp },
            success: function (response) {
            var result = JSON.parse(response);
            if (result.success) {
                $("#CartCount").text(result.slgh);
                currentRow.remove();
            } else {
                alert("Xóa lỗi");
            }
            },
            error: function () {
            // Xử lý lỗi nếu cần thiết
            }
        });
    });

    // Tính thành tiền cho từng sản phẩm
    function calculateSubtotalPrice(idsp) {
        var inputElement = document.getElementById("soluong_" + idsp);
        var quantity = parseInt(inputElement.value);
        var price = parseInt(document.getElementById("giaSP_" + idsp).innerText.replace(/\D/g, ""));
        var subtotalPrice = quantity * price;
        var subtotalElement = document.getElementById("subtotal_" + idsp);
        subtotalElement.innerText = formatCurrency(subtotalPrice);
        calculateTotalPrice(); // Gọi hàm tính tổng tiền mỗi khi thay đổi số lượng
    }

    // Tính tổng tiền
    function calculateTotalPrice() {
        var total = 0;
        var checkboxes = document.querySelectorAll('.sanpham-checkbox');
        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
            var idsp = checkbox.getAttribute('data-idsp');
            var quantityInput = document.getElementById('soluong_' + idsp);
            var quantity = parseInt(quantityInput.value);
            var priceElement = document.getElementById('giaSP_' + idsp);
            var price = parseInt(priceElement.innerText.replace(/\D/g, ''));
            var subtotalPrice = quantity * price;
            total += subtotalPrice;
            }
    });

        var sumElement = document.getElementById('TongTien');
        sumElement.innerText = formatCurrency(total);
        var finalSumElement = document.getElementById('ThanhTien');
        finalSumElement.innerText = formatCurrency(total);
    }

    $('#btnThanhToan').click(function (e) {
    e.preventDefault();
    sendSelectedProducts();
    });

    // Truyền dữ liệu selected products sang action cart_check
    function sendSelectedProducts() {
        var checkboxes = document.querySelectorAll('.sanpham-checkbox:checked');
        var selectedProducts = [];

        checkboxes.forEach(function (checkbox) {
            var masp = checkbox.dataset.idsp;
            var soluong = parseInt(document.getElementById('soluong_' + masp).value);

            var selectedProduct = {
            MASP: masp,
            SOLUONG: soluong,
            };

            selectedProducts.push(selectedProduct);
        });

        // Gán giá trị selectedProducts vào trường ẩn trong biểu mẫu
        document.getElementById('hiddenSelectedProducts').value = JSON.stringify(selectedProducts);

        // Gửi biểu mẫu
        if (selectedProducts.length > 0)
            document.getElementById('hiddenForm').submit();
        else
            alert("Vui lòng chọn sản phẩm trong giỏ hàng để thanh toán");
    }

    function formatCurrency(number) {
        return number.toLocaleString("vi-VN", { style: "currency", currency: "VND" });
    }
</script>
  
<?php include 'footer.php' ?>
