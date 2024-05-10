<?php
include 'login_required.php'; 
include 'header.php';

?>
<title>Lịch sử đặt hàng</title>

        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <h1 class="mb-4 text-white">Thông tin cá nhân</h1>
                <div class="col-lg-12">         
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <!-- <div class="row g-4"> -->
                            <div class="mb-3">
                                <h2>Danh mục tùy chọn</h2>
                                <a class="list-group-item" href="user.php">Thông tin chung</a>
                                <a class="list-group-item  active" href="user_orders.php">Lịch sử đơn hàng</a>
                                <a class="list-group-item" href="user_changeinfo.php">Chỉnh sửa thông tin cá nhân</a>
                            </div>                          
                            <div class="position-relative">
                                <img src="img/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                                    <h3 class="text-secondary fw-bold">. <br> . <br> .</h3>
                                </div>
                            </div>                           
                            <!-- </div> -->
                        </div>
                        <div class="col-lg-9"><H2>Lịch sử đặt hàng</H2>   
                            <!-- <div class="col-lg-12"> -->  
                            <?php
                $tt_hd = mysqli_query($conn, "SELECT hoadon.*, nguoidung.*
                FROM hoadon
                JOIN nguoidung ON hoadon.MAND = nguoidung.MAND
                
                WHERE hoadon.MAND = '{$_SESSION['MAND']}'
                ORDER BY hoadon.MAHD DESC");

                ?>                       
                            <?php if (mysqli_num_rows($tt_hd) <> 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($tt_hd)): ?>
                        <?php
                        $tongtien_querry = mysqli_query($conn, "select sum(chitiethoadon.SOLUONGMUA*chitiethoadon.DONGIAXUAT) as tongtien
                        from chitiethoadon join hoadon on chitiethoadon.MAHD = hoadon.MAHD
                        WHERE hoadon.MAHD = '{$row['MAHD']}'");
                        $tongtien_row = mysqli_fetch_assoc($tongtien_querry);
                        $tongtien = $tongtien_row['tongtien'];
                        ?>
                        <article class="card mb-4">
                            <header class="card-header">
                                <a href="#" class="float-right"> <i class="fa fa-print text-dark"></i></a>
                                <strong class="d-inline-block mr-3">ID đơn đặt hàng:
                                    <?php echo $row['MAHD'] ?>
                                </strong>
                                <span>Ngày đặt:
                                    <?php echo $row['NGAYTAO'] ?>
                                </span>
                            </header>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6 class="text-muted">Giao hàng đến</h6>
                                        <p>
                                            <?php echo $row['TENND'] ?> <br>
                                            SĐT: <?php echo $row['SDT'] ?><br> 
                                           
                                            Địa chỉ: <?php echo $row['DIACHI']  ; ?>
                                            <br>

                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="text-muted">Thanh toán</h6>
                                        <span class="text-success">
                                            <i class="fab fa fa-money-bill"></i>
                                            <?php echo $row['TINHTRANGDONHANG'] ?>
                                        </span>
                                        <p>
                                            Tổng tiền:
                                            <?php echo $tongtien; ?>
                                            <br>
                                            Tiền ship:
                                            <?php echo 0; ?>
                                            <br>
                                            <span class="b">Thanh toán:
                                                <?php echo $tongtien; ?>
                                            </span>
                                        </p>
                                    </div>
                                </div> <!-- row.// -->
                            </div> <!-- card-body .// -->
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                        <?php 
                                        $tt_cthd = mysqli_query($conn, "SELECT chitiethoadon.*, hoadon.*, sanpham.*, chitiethoadon.SOLUONGMUA as SLCTHD, chitiethoadon.DONGIAXUAT as DGX, sanpham.GIA as DGSP, sanpham.SALE as SALE
                                        FROM chitiethoadon
                                        JOIN hoadon ON chitiethoadon.MAHD = hoadon.MAHD
                                        JOIN sanpham ON sanpham.MASP = chitiethoadon.MASP
                                        WHERE hoadon.MAHD = '{$row['MAHD']}'");
                                        ?>
                                        <?php if (mysqli_num_rows($tt_cthd) <> 0): ?>
                                            <?php while ($row = mysqli_fetch_assoc($tt_cthd)): ?>
                                                <tr>
                                                    <td width="65">
                                                        <img src="img/<?php echo $row["ANH"]?>" style="width:65px; height:65px;">
                                                    </td>
                                                    <td>
                                                        <a href="detail.php?id=<?php echo $row['MASP']?>">
                                                        <p class="title mb-0 text-dark"><?php echo $row["TENSP"]?> </p>
                                                        <?php if ($row['SALE'] > 0) { ?>
                                                            <var class="price h6" ><?php echo $row['DONGIAXUAT']; ?></var>
                                                            <span class="h6 original-price"><del style="color: gray;"><?php echo $row['GIA']; ?></del></span>
                                                            <?php
                                                            
                                                        } else { ?>
                                                            <var class="price h6"><?php echo $row['GIA']; ?></var>
                                                        <?php } ?>
                                                    </td>
                                                    <td> Số lượng <br> <?php echo $row['SLCTHD']; ?> </td>
                                                    <td width="250">
                                                        Thành tiền <br> Thanh toán:
                                                        <?php 
                                                            $thanh_tien = $row['DONGIAXUAT'] * $row['SLCTHD'];
                                                            echo $thanh_tien;
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php endif; ?>

                                    </tbody>
                                </table>
                            </div> <!-- table-responsive .end// -->
                        </article>

                    <?php endwhile; ?>
                <?php endif; ?> <!-- card-body .// --><!-- </div> -->                          
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    
<?php include 'footer.php' ?>