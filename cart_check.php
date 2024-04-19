<?php
include 'login_required.php';
include 'header.php';

$statement = "";

if (isset($_POST['selectedProducts'])) {
    $selectedProducts = json_decode($_POST['selectedProducts'], true);
    $_SESSION['selectedProducts'] = $selectedProducts;
    foreach ($selectedProducts as $product) {
        $masp = $product['MASP'];
        $soluong = $product['SOLUONG'];

        $statement .= "'" . $masp . "',";
    }
    $statement = rtrim($statement, ","); // Loại bỏ dấu phẩy cuối cùng
    $query = "SELECT SUM(CASE
                WHEN sanpham.SALE > 0 THEN giohang.SOLUONG * sanpham.SALE
                ELSE giohang.SOLUONG * sanpham.GIA
            END) AS total
            FROM giohang
            JOIN sanpham ON giohang.MASP = sanpham.MASP
            WHERE giohang.MASP IN ($statement) AND giohang.MAND = '{$_SESSION['MAND']}'";
    $result = mysqli_query($conn, $query);
    $ctdh = mysqli_query($conn, "SELECT *, giohang.SOLUONG AS slgh, giohang.DONGIA AS dggh FROM giohang JOIN sanpham ON giohang.MASP = sanpham.MASP WHERE giohang.MASP IN ($statement) AND giohang.MAND = '{$_SESSION['MAND']}'");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $tongtien = $row["total"];
    } else {
        echo "Lỗi trong quá trình thực thi câu truy vấn.";
    }
}

$_SESSION['tongtien'] = $tongtien;
?>
<title>Xác nhận đơn hàng</title>
<body style="color:black">
<!-- Checkout Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <h1 class="mb-4 text-white" >Thông tin người nhận</h1>
        <form action="#">
        <div class="row g-5">
            <div class="col-md-12 col-lg-4">
                <h4 class="mb-4 text-center">Thông tin người nhận</h4>
                <div class="form-item">
                    <label class="form-label my-3">Tên người người nhận<sup>*</sup></label>
                    <input type="tel" class="form-control">
                </div>
                <div class="form-item">
                    <label class="form-label my-3">Địa chỉ người nhận <sup>*</sup></label>
                    <input type="text" class="form-control" placeholder="House Number Street Name">
                </div>
                <div class="form-item">
                    <label class="form-label my-3">Số điện thoại người nhận<sup>*</sup></label>
                    <input type="tel" class="form-control">
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-7">
                <div class="table-responsive">
                    <table class="table" style="color:black">
                        <thead>
                            <tr>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col" >Giá</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (mysqli_num_rows($ctdh) <> 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($ctdh)): ?>
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center mt-2">
                                        <img src="img/<?php echo $row['ANH'] ?>" class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
                                    </div>
                                </th>
                                <td class="py-5"><?php echo $row['TENSP'] ?></td>
                                <td class="py-5"><?php if ($row['SALE'] > 0): ?> 
                                    <var class="price"><?php echo $row['SALE'] ?></var>
                                    <?php else: ?>
                                        <var class="price"><?php echo $row['DONGIA'] ?></var>
                                    <?php endif; ?>
                                </td>
                                <td class="py-5"><?php echo $row['slgh'] ?></td>
                                <td class="py-5"><?php if ($row['SALE'] > 0): ?>
                                        <?php echo $row['slgh'] * $row['SALE'] ?>
                                    <?php else: ?>
                                        <?php echo $row['slgh'] * $row['DONGIA'] ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                            <tr style="color:black">
                                <th scope="row">
                                </th>
                                <td class="py-5">
                                    <p class="mb-0 text-uppercase py-3">Số tiền cần thanh toán</p>
                                </td>
                                <td class="py-5"></td>
                                <td class="py-5"></td>
                                <td class="py-5">
                                    <div class="py-3 border-bottom border-top">
                                        <p class="mb-0"><?php echo $tongtien ?></p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                    <button type="button" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-success">Thanh toán khi nhận hàng</button>
                </div>
                <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                    <button type="button" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-success">Thanh toán trước bằng VNPAY</button>
                </div>
            </div>
            </div>
        </form>
    </div>
</div>
<!-- Checkout Page End -->
</body>
<?php
include 'footer.php';
?>