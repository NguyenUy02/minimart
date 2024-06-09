<?php include 'header.php'; 
$id = "";
if (isset($_GET["id"])) {
    $id = trim(preg_replace('/\s+/', ' ', $_GET["id"]));
}

$order = ""; // Khởi tạo biến $order

if (isset($_GET["order"])) {
    $order = $_GET["order"];
}

if (isset($_GET['querry'])) {
    $querry = $_GET['querry'];
} else {
    $querry = "SELECT * FROM sanpham 
               JOIN thuonghieu ON sanpham.MATH = thuonghieu.MATH
               JOIN thongtinsanpham ON sanpham.MATTSP = thongtinsanpham.MATTSP
               JOIN loaisanpham ON sanpham.MALSP = loaisanpham.MALSP
               WHERE LOWER(TENSP) LIKE '%" . strtolower($id) . "%'
                  OR sanpham.MALSP = '$id'
                  OR LOWER(thuonghieu.TENTH) LIKE '%" . strtolower($id) . "%'";
}

// Thêm phần ORDER BY vào câu truy vấn SQL dựa trên giá trị của $order
switch ($order) {
    case 'priceDesc':
        $querry .= " ORDER BY sanpham.GIA DESC";
        break;
    case 'priceAsc':
        $querry .= " ORDER BY sanpham.GIA ASC";
        break;
    case 'discountDesc':
        $querry .= " ORDER BY (sanpham.GIA / sanpham.SALE)*100 DESC";
        break;
    case 'featured':
    default:
        // Không cần thêm ORDER BY, mặc định sẽ lấy dữ liệu theo truy vấn ban đầu
        break;
}

$listSanPham = mysqli_query($conn, $querry);


?>
<title>Sản phẩm</title>
<!-- Poster Start -->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
       <h1 class="text-white">Shop</h1>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">           
                    <div class="col-xl-3">
                        <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4 mt-4">
                            <label for="fruits">Sắp xếp theo:</label>
                            <select id="fruits" name="fruitlist" class="border-0 form-select-sm bg-light me-3" form="fruitform" onchange="sortProducts(this.value)">
                                <option value="featured" <?php if ($order == 'featured') echo 'selected'; ?>>Nổi bật</option>
                                <option value="priceDesc" <?php if ($order == 'priceDesc') echo 'selected'; ?>>Giá giảm</option>
                                <option value="priceAsc" <?php if ($order == 'priceAsc') echo 'selected'; ?>>Giá tăng</option>
                                <option value="discountDesc" <?php if ($order == 'discountDesc') echo 'selected'; ?>>Phần trăm giảm</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-2">
                        <div class="row g-4">
                            <div class="col-lg-12">
                            <div class="mb-3">
                                <h5>Danh mục sản phẩm</h5>
                                <ul class="list-unstyled fruite-categorie">
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM loaisanpham");
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $MALSP = $row['MALSP'];
                                            $TENLSP = $row['TENLSP'];
                                    ?>
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name ">
                                            <a href="product.php?id=<?php echo $MALSP; ?>">
                                                <i class="fas fa-circle me-2 text-success"></i>
                                                <span class="text-success"><?php echo $TENLSP; ?></span>
                                            </a>
                                        </div>
                                    </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="col-lg-12">
                            <div class="row g-4 justify-content-center">
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM sanpham");
                            if (mysqli_num_rows($result) <> 0) {
                                while ($rows = mysqli_fetch_assoc($listSanPham)) {
                                    $gia = $rows['GIA'];
                                    $sale = $rows['SALE'];
                                    ?>
                                    <div class="col-md-6 col-lg-6 col-xl-3">
                                        <div class="border border-success rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <a href="detail.php?id=<?php echo $rows['MASP']; ?>" class="img-wrap">
                                                    <img src="img/<?php echo $rows['ANH']; ?>" class="img-fluid w-100 rounded-top" alt="">
                                                </a>
                                            </div>
                                            <?php
                                            $phanTramGiamGia = round((($rows['GIA'] - $rows['SALE']) / $rows['GIA']) * 100);
                                            if ($phanTramGiamGia > 0 && $rows['SALE'] > 0) {
                                                echo '<div class="text-white bg-danger px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">' . $phanTramGiamGia . '%</div>';
                                            }
                                            ?>
                                            
                                            <div class="p-4 rounded-bottom">
                                                <h6><?php echo $rows['TENSP']; ?></h6>
                                                <!-- <p><?php echo $rows['MOTA']; ?></p> -->
                                                <div class="d-flex flex-lg-wrap mb-3">
                                                    <?php if ($sale > 0) { ?>
                                                        <p class="text-danger fs-5 fw-bold mb-0"><?php echo $sale . ' đ'; ?></p>
                                                        <del class="ms-2"><?php echo $gia . ' đ'; ?></del>
                                                    <?php } else { ?>
                                                        <p class="text-dark fs-5 fw-bold mb-0"><?php echo $gia . ' đ'; ?></p>
                                                    <?php } ?>
                                                </div>
                                                <div class="text-center">
                                                    <a <?php if (!isset($_SESSION['MAND'])) { ?> 
                                                        href="login.php" <?php } else { ?> href="javascript:void(0)"  
                                                        onclick="addToCart('<?php echo $rows['MASP']; ?>');" <?php } ?> class="btn border border-success rounded-pill px-4 text-success">
                                                        <i class="fa fa-shopping-bag me-2 text-success"></i> Thêm vào giỏ</a>
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
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Poster End -->

<?php include 'footer.php' ?>
<style>
    .fruite-img img {
        width: 100%;
        height: 250px; 
        object-fit: contain; 
    }
</style>
<script>
   
    function addToCart(masp) {
    var soluong = 1;
    $.ajax({
        url: 'cart_add.php', // URL của phương thức "ThemVaoGioHang" trong controller
        type: 'POST',
        data: { MASP: masp, SOLUONG: soluong }, // Truyền dữ liệu masp và soluong
        success: function (response) {
            var result = JSON.parse(response);
            if (result.success) {
                $("#CartCount").text(result.slgh);
                showSuccessToast("Đã thêm sản phẩm vào giỏ hàng");
            } else {
                showErrorToast("Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng");
            }
        },
        error: function () {
            showErrorToast("Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng");
        }
    });
}

function showSuccessToast(message) {
    // Code để hiển thị toast thông báo thành công
    console.log(message);
}

function showErrorToast(message) {
    // Code để hiển thị toast thông báo lỗi
    console.log(message);
}
function sortProducts(order) {
        var urlParams = new URLSearchParams(window.location.search);
        urlParams.set('order', order);
        var newUrl = window.location.pathname + '?' + urlParams.toString();
        window.location.href = newUrl;
    }
</script>