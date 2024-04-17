<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link href="img/favio.png" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("connect.php"); 
?>
    <!-- Spinner Start -->
<div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
</div>
<!-- Spinner End -->


<!-- Navbar start -->
<div class="container-fluid fixed-top">
    <div class="container topbar bg-success d-none d-lg-block">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Nha Trang, khánh hòa</a></small>
                <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">uy.n.62cntt@ntu.edu.vn</a></small>
            </div>
            <div class="top-link pe-2">
                <a href="#" class="text-white"><small class="text-white mx-2"></small></a>
                <a href="#" class="text-white"><small class="text-white mx-2"></small></a>
                <a href="#" class="text-white"><small class="text-white ms-2"></small></a>
            </div>
        </div>
    </div>
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="index.php" class="navbar-brand"><h1 class="text-success display-6">Minimart</h1></a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="index.php" class="nav-item text-dark nav-link">Trang chủ</a>
                    <a href="product.php" class="nav-item text-dark nav-link">Sản phẩm</a>
                    
                    <!-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <a href="cart.php" class="dropdown-item">Cart</a>
                            <a href="chackout.php" class="dropdown-item">Chackout</a>
                            <a href="testimonial.php" class="dropdown-item">Testimonial</a>
                            <a href="404.php" class="dropdown-item">404 Page</a>
                        </div>
                    </div> -->
                    <!-- <a href="contact.php" class="nav-item nav-link">Contact</a> -->
                </div>
                <div class="d-flex m-3 me-0">
                    <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal" >
                        <i class="fas fa-search "></i>
                    </button>
                    <a href="cart.php" class="position-relative me-4 my-auto">
                        <i class="fa fa-shopping-cart  fa-2x text-success"></i>
                        <?php
                            if (isset($_SESSION["MAND"])) {
                                $query = "SELECT COUNT(MASP) AS SoLuong FROM giohang WHERE MAND = '{$_SESSION['MAND']}'";
                                $result = mysqli_query($conn, $query);
                                $row = mysqli_fetch_assoc($result);
                                $_SESSION['SLGH'] = $row['SoLuong'];
                                $_SESSION['SLGH'] == "" ? 0 : $_SESSION['SLGH'];
                                echo '<span id="CartCount" class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">' . $_SESSION['SLGH'] . '</span>';

                            }
                            ?>
                
                    </a>
                    <!-- Nếu đã đăng nhập -->
                    <?php if (isset($_SESSION["MAND"])): ?>                
                        <span class="button-wrapper">
                        <a href="logout.php" class="my-auto" style="margin-right: 20px;">
                            <i class="fas fa-sign-out-alt fa-2x text-success"></i>
                        </a>
                        </span>
                        <!-- Nếu chưa đang nhập -->
                    <?php else: ?>
                        <span class="button-wrapper">
                            <a href="login.php" class="my-auto" style="margin-right: 20px;">
                                <i class="fas fa-user fa-2x text-success"></i>
                            </a>
                        </span>

                        <span class="button-wrapper">
                            <a href="register.php" class="my-auto">
                                <i class="fas fa-user-plus fa-2x text-success"></i>
                            </a>
                        </span>
                        <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->
</body>
</html>