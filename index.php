<?php include 'header.php' ?>
<title>Trang chủ</title>
    
    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tìm kiếm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->

    <!-- Poster Start -->
    <div class="container-fluid py-5 hero-header">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">MiniMart</h4>
                    <h1 class="mb-5 display-3 text-success">Drink and Food</h1>
                    <div class="position-relative mx-auto">
                        <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="number" placeholder="Tìm kiếm">
                        <button type="submit" class="btn btn-success border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100" style="top: 0; right: 25%;">Tìm kiếm</button>
                    </div>
                </div>
                <!-- Banner -->
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active rounded">
                                <img src="img/hero-img-1.png" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                <!-- <a href="#" class="btn px-4 py-2 text-white rounded"> </a> -->
                            </div>
                            <div class="carousel-item rounded">
                                <img src="img/hero-img-2.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                <!-- <a href="#" class="btn px-4 py-2 text-white rounded"></a> -->
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Poster End -->

    <!-- Bestsaler Product Start -->
    <div class="container-fluid">
        <div class="container">
            <div class="text-center mx-auto mb-5 mt-5" style="max-width: 700px;">
                <h1>Sản phẩm giảm giá</h1>
                <p>Chương trình giảm giá hấp dẫn</p>
            </div>
            <div class="row g-4">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM sanpham WHERE SALE > 0 ORDER BY RAND() LIMIT 6");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $tenSP = $row['TENSP'];
                    $anh = $row['ANH'];
                    $gia = $row['GIA'];
                    $sale = $row['SALE'];                  
            ?>
            <div class="col-lg-6 col-xl-4">
                <div class="p-4 rounded bg-light d-flex flex-fill">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <img src="img/<?php echo $anh; ?>" class="img-fluid rounded-circle w-100" style="width: 150px; height: 150px;" alt="">
                        </div>
                        <div class="col-6">
                            <a href="#" class="h5"><?php echo $tenSP; ?></a>
                            <h4 class="mb-3">
                                <del><?php echo number_format($gia, 0, ".", ","); ?></del>
                                <span class="text-danger"><?php echo number_format($sale, 0, ".", ","); ?></span>
                            </h4>
                            <a href="#" class="btn btn-sm border border-secondary rounded-pill px-3 text-success"><i class="fa fa-shopping-bag me-2 text-success"></i> Thêm vào giỏ hàng</a>
                        </div>
                    </div>
                </div>
            </div>
                <?php
                    }
                } else {
                    echo "Không có sản phẩm giảm giá.";
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Bestsaler Product End -->
    <!-- Vesitable Shop Start-->
    <div class="container-fluid vesitable py-5">
        <div class="container py-5">
            <h1 class="mb-0">Sản phẩm nổi bật</h1>
            <div class="owl-carousel vegetable-carousel justify-content-center">
                <?php
                $result = mysqli_query($conn, "SELECT * FROM sanpham  LIMIT 12");
                if (mysqli_num_rows($result) <> 0) {
                    while ($rows = mysqli_fetch_assoc($result)) {
                ?>
                <div class="border border-success rounded position-relative vesitable-item" style="height: 400px; width: 251px;">
                    <div class="vesitable-img">
                        <img src="img/<?php echo $rows['ANH']; ?>" class="img-fluid rounded-top" style="height: 200px; object-fit: cover;" alt="">
                    </div>
                    <!-- <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?php echo $rows['MALSP']; ?></div> -->
                    <div class="p-4 rounded-bottom">
                        <h5><?php echo $rows['TENSP']; ?></h5>
                        <p style="height: 45px; overflow: hidden;"><?php echo $rows['MOTA']; ?></p>
                        <div class="d-flex justify-content-between flex-wrap">
                            <p class="text-dark fw-bold mb-1"><?php echo $rows['GIA']; ?></p>
                        </div>
                        <div class="text-center"> <!-- Thêm lớp text-center để căn giữa nút -->
                            <a href="#" class="btn border border-secondary rounded-pill text-success"><i class="fa fa-shopping-bag me-2 text-success"></i> Thêm vào giỏ</a>
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
    <!-- Vesitable Shop End -->
    <!-- Featurs Section Start -->
    <div class="container-fluid featurs py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-car-side fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Giao hàng miễn phí</h5>
                            <p class="mb-0">Áp dụng cho hóa đơn trên 300k</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-user-shield fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Thanh toán dễ dàng</h5>
                            <p class="mb-0">Nhiều hình thức thanh toán</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-exchange-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Không đổi trả</h5>
                            <p class="mb-0">Mua rồi không trả</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fa fa-phone-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Tư vấn 24/7</h5>
                            <p class="mb-0">Liên hệ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Featurs Section End -->

    <!-- Footer Start -->
    <?php include 'footer.php' ?>
