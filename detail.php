<?php include 'header.php'; 
$id = "";
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

$result = mysqli_query($conn, "SELECT * FROM sanpham 
    JOIN thuonghieu ON sanpham.MATH = thuonghieu.MATH 
    JOIN thongtinsanpham ON sanpham.MATTSP = thongtinsanpham.MATTSP 
    JOIN loaisanpham ON sanpham.MALSP = loaisanpham.MALSP
    WHERE MASP = '$id'
    LIMIT 1");

?>
<title>Chi tiết sản phẩm</title>
    <!-- Single Product Start -->
<div class="container-fluid py-5 mt-5" style="color: black;">
<div class="container py-5">
<h1 class="mb-4"></h1>
    <div class="row g-4 mb-5">
        <div class="col-lg-8 col-xl-9">
            <div class="row g-4">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col-lg-6">                                  
                    <img src="img/<?php echo $row['ANH']; ?>" class="img-fluid rounded" alt="Image">                      
                </div>
                <div class="col-lg-6">
                    <h4 class="fw-bold mb-3"><?php echo $row['TENSP']; ?></h4>                  
                    <?php if ($row['SALE'] > 0) { ?>
                        <p class="text-danger fw-bold mb-3">Giá bán: <?php echo $row['SALE']; ?> đ</p>
                    <?php } else { ?>
                        <p class="fw-bold mb-3">Giá bán: <?php echo $row['GIA']; ?> đ</p>
                    <?php } ?>
                    <?php if ($row['SOLUONG'] > 0) { ?>
                        <p class="mb-3 text-success">Còn hàng</p>
                    <?php } else { ?>
                        <p class="mb-3 text-danger">Tạm hết hàng</p>
                    <?php } ?>
                    <p class="mb-3">Thương hiệu: <?php echo $row['TENTH']; ?></p>
                    <div class="input-group quantity mb-5" style="width: 100px;">
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" id="ipQuantity" class="form-control form-control-sm text-center border-0" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-plus rounded-circle bg-light border" id="button-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>                   
                    <a <?php if (!isset($_SESSION['MAND'])) { ?>  href="login.php" <?php } 
                        else  ?> class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-success" id="addtocart">
                        <i class="fa fa-shopping-bag me-2 text-success"></i> Thêm vào giỏ hàng
                    </a>
                </div> 
                <div class="col-lg-12">                   
                    <div class="nav nav-tabs mb-3">
                        <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                            id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                            aria-controls="nav-about" aria-selected="true">Mô tả</button>                              
                    </div>                                      
                    <div class="tab-content mb-5">
                        <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">                    
                            <div class="px-2">
                                <div class="row g-4">
                                    <div class="col-6">
                                        <p><?php echo $row['MOTA']; ?></p>
                                    </div>
                                    <div class="col-6">
                                        <div class="row bg-light align-items-center text-center justify-content-center py-2">
                                            <div class="col-4">
                                                <p class="mb-0">Thành phần</p>
                                            </div>
                                            <div class="col-8">
                                                <p class="mb-0"><?php echo $row['THANHPHAN']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row text-center align-items-center justify-content-center py-2">
                                            <div class="col-4">
                                                <p class="mb-0">Xuất xứ</p>
                                            </div>
                                            <div class="col-8">
                                                <p class="mb-0"><?php echo $row['XUATXU']; ?></p>
                                            </div>
                                        </div>
                                        <?php if ($row['KHOILUONG'] > 0) { ?>
                                        <div class="row bg-light text-center align-items-center justify-content-center py-2">
                                            <div class="col-4">
                                                <p class="mb-0">Khối lượng</p>
                                            </div>
                                            <div class="col-8">
                                                <p class="mb-0"><?php echo $row['KHOILUONG']; ?>g</p>
                                            </div>
                                        </div>
                                        <?php } else { ?>
                                        <div class="row text-center align-items-center justify-content-center py-2">
                                            <div class="col-4">
                                                <p class="mb-0">Thể tích</p>
                                            </div>
                                            <div class="col-8">
                                                <p class="mb-0"><?php echo $row['THETICH']; ?>ml</p>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><?php } ?>
                </div>                   
            </div>
        </div>
        <div class="col-lg-4 col-xl-3">
            <div class="row g-4 fruite">
                <div class="col-lg-12">
                    <h4 class="mb-4">Sản phẩm đề xuất</h4>                       
                    <?php                       
                    $result1 = mysqli_query($conn, "SELECT * FROM sanpham ORDER BY RAND() LIMIT 2");                                            
                    while ($row1 = mysqli_fetch_assoc($result1)) { ?>
                    <div class="d-flex align-items-center justify-content-start">
                        <div class="rounded" style="width: 100px; height: 100px;">
                            <a href="detail.php?id=<?php echo $row1['MASP']; ?>" class="img-wrap">
                                <img src="img/<?php echo $row1['ANH']; ?>" class="img-fluid rounded" alt="Image">
                            </a>
                        </div>
                        <div>
                            <h6 class="mb-2">&nbsp;<?php echo $row1['TENSP']; ?></h6>
                            <div class="d-flex mb-2">
                                <?php if ($row1['SALE'] > 0) { ?>
                                    <h5 class="fw-bold me-2 text-danger">&nbsp;<?php echo $row1['SALE']; ?> đ</h5>
                                    <h5 class="text-muted text-decoration-line-through"><?php echo $row1['GIA']; ?> đ</h5>
                                <?php } else { ?>
                                    <h5 class="fw-bold me-2 text-dark">&nbsp;<?php echo $row1['GIA']; ?> đ</h5>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-lg-12">
                    <div class="position-relative">
                        <img src="img/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h1 class="fw-bold mb-0">Gợi ý sản phẩm</h1>
    <div class="row">
                <?php
               $result = mysqli_query($conn, "SELECT * FROM sanpham ORDER BY SOLUONG DESC LIMIT 10");
                if (mysqli_num_rows($result) <> 0) {
                    while ($rows = mysqli_fetch_assoc($result)) {
                ?>
                <div class="border border-success rounded position-relative vesitable-item mx-2 my-2 p-0" style="height: 410px; width: 247px;">
                    <div class="fruite-img">
                    <a href="detail.php?id=<?php echo $rows['MASP']; ?>" class="img-wrap">
                        <img src="img/<?php echo $rows['ANH']; ?>" class="img-fluid w-100 rounded-top" style="height: 240px; object-fit: cover;" alt="">
                    </a>        
                    </div>
                    <div class="d-flex flex-column py-2 px-4 rounded-bottom" style="height: calc(100% - 240px);">
                        <h5 class="mb-2"><?php echo $rows['TENSP']; ?></h5>
                        <div class="d-flex flex-column justify-content-between flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <?php if ($rows['SALE'] > 0) { ?>
                                    <div class="d-flex align-items-center">
                                        <p class="text-danger fw-bold mb-0 me-2"><?php echo $rows['SALE'] . ' đ'; ?></p>
                                        <del class="text-muted mb-0"><?php echo $rows['GIA'] . ' đ'; ?></del>
                                    </div>
                                <?php } else { ?>
                                    <p class="text-dark fw-bold mb-0"><?php echo $rows['GIA'] . ' đ'; ?></p>
                                <?php } ?>
                            </div>
                            <div class="mt-2 mb-3 text-center">
                                <a <?php if (!isset($_SESSION['MAND'])) { ?> 
                                    href="login.php" <?php } else { ?> href="javascript:void(0)"  
                                    onclick="addToCart('<?php echo $rows['MASP']; ?>');" <?php } ?> 
                                    class="btn border border-secondary rounded-pill text-success">
                                    <i class="fa fa-shopping-bag text-success"></i> Thêm vào giỏ hàng
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                }
                ?>
            </div>
</div>
</div>
<!-- Single Product End -->
<?php include 'footer.php' ?>
<script>
    // Lấy đối tượng input và button
    var input = document.getElementById('ipQuantity');
    var buttonMinus = document.getElementById('button-minus');
    var buttonPlus = document.getElementById('button-plus');
     $(function () {
        $("#addtocart").click(function () {
            var masp = '<?php echo $id?>'; // Lấy mã sản phẩm 
            var soluong = $('#ipQuantity').val(); // Lấy số lượng từ input
          
            $.ajax({
                url: 'cart_add.php', // URL của phương thức "ThemVaoGioHang" trong controller
                type: 'POST',
                data: { MASP: masp, SOLUONG: soluong }, // Truyền dữ liệu masp và soluong
                success: function (response) {
               
                    var result = JSON.parse(response); 
                
                    if (result.success) {        
                       $("#CartCount").text(result.slgh);                   
                       
                    } 
                    else{
                        alert("Không thể thêm vào giỏ hàng!");
                    }
                },
                error: function () {
                    
                    alert("Hãy đăng nhập trước khi thêm vào giỏ hàng!");
                }
            });

            return false;
        });
    });
    
</script>
