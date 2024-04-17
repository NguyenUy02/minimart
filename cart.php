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
    <h1 class="mb-4">Cart</h1>
        <div class="table-responsive">
        <?php                
                 $result = mysqli_query($conn, "SELECT sanpham.*, thuonghieu.*, thongtinsanpham.*, giohang.SOLUONG as SLGH, sanpham.GIA as DGSP, sanpham.SALE as sale,sanpham.SOLUONG as SLSP
                 FROM giohang
                 JOIN sanpham ON giohang.MASP = sanpham.MASP 
                 JOIN thongtinsanpham ON sanpham.MATTSP = thongtinsanpham.MATTSP
                 JOIN thuonghieu ON sanpham.MATH = thuonghieu.MATH
                 WHERE giohang.MAND = '{$_SESSION['MAND']}'");
                    ?>
                    <?php if (mysqli_num_rows($result) == 0): ?>
                        <h3 class="text-muted">Không có sản phẩm trong giỏ hàng</h3>
                    <?php else: ?>
            <table class="table" style="color: black;">
                <thead>
                    <tr>
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
                        <td>
                            <div class="input-group quantity mt-4" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button onclick="decreaseQuantity('<?php echo $row['MASP']?>')" class="btn btn-sm btn-minus rounded-circle bg-light border" >
                                    <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" id="soluong_<?php echo $row['MASP']; ?>" class="form-control form-control-sm text-center border-0" value="<?php echo $row['SLGH']; ?>" min="1" max="<?php echo $row['SLSP']; ?>">
                                <div class="input-group-btn">
                                    <button onclick="increaseQuantity('<?php echo $row['MASP']?>')" class="btn btn-sm btn-plus rounded-circle bg-light border">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="mb-0 mt-4">
                            <?php if ($row['SALE'] > 0) { ?>
                                        <var id="subtotal_<?php echo $row['MASP']?>" class="price pt-2 item-total">
                                            <?php echo $row['SALE'] * $row['SLGH']; ?>
                                        </var>
                                    <?php } else { ?>
                                        <var id="subtotal_<?php echo $row['MASP']?>" class="price pt-2 item-total">
                                            <?php echo $row['DGSP'] * $row['SLGH']; ?>
                                        </var>
                                    <?php } ?>
                            </p>
                        </td>
                        <td>
                            <button class="btn btn-md rounded-circle bg-light border mt-4" >
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
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">Tổng hóa đơn</span></h1>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Tổng tiền:</h5>
                            <p class="mb-0">$96.00</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0 me-4">Phí</h5>
                            <div class="">
                                <p class="mb-0">Flat rate: $3.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                        <h5 class="mb-0 ps-4 me-4">Tổng cộng</h5>
                        <p class="mb-0 pe-4">$99.00</p>
                    </div>
                    <button class="btn border-secondary rounded-pill px-4 py-3 text-success text-uppercase mb-4 ms-4" type="button">Mua</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart Page End -->
<?php include 'footer.php' ?>
