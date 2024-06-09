<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link href="img/favio.png" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include ("connect.php");
    ?>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="container topbar bg-success d-none d-lg-block">
            <div class="d-flex justify-content-between">
                <div class="top-info ps-2">
                    <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#"
                            class="text-white">Nha Trang, Khánh Hòa</a></small>
                    <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#"
                            class="text-white">uy.n.62cntt@ntu.edu.vn</a></small>
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
                <a href="index.php" class="navbar-brand"><img src="img/logo.jpg" alt="Minimart Logo" class="img-fluid"
                        style="max-height: 60px; "> </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-success"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto my-2">
                        <a href="product.php" class="nav-item text-dark nav-link">Danh sách sản phẩm</a>
                    </div>
                    <div class="position-relative mx-1 my-3 d-flex justify-content-end">
                        <form action="product.php" method="get">
                            <input class="form-control border-2 border-secondary py-2 px-3 rounded-pill" type="text"
                                placeholder="Tìm kiếm sản phẩm" style="width: 400px; margin-left: auto;" name="id">
                            <button type="submit"
                                class="btn btn-success border-2 border-secondary py-2 px-3 position-absolute rounded-pill text-white h-100"
                                style="top: 0; right: 0%;"> Tìm kiếm</button>
                        </form>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <a <?php if (!isset($_SESSION['MAND'])) { ?> href="login.php" <?php } else { ?> href="cart.php"
                            <?php } ?>
                            class="text-success d-flex flex-column align-items-center mx-3 position-relative">
                            <i class="fa fa-shopping-cart fa-2x"></i>
                            <span>Giỏ hàng</span>
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
                            <a href="user.php" class="text-success d-flex flex-column align-items-center mx-3">
                                <i class="fas fa-user fa-2x"></i>
                                <span>Cá nhân</span>
                            </a>
                            <a href="logout.php" class="text-success d-flex flex-column align-items-center mx-3">
                                <i class="fas fa-sign-out-alt fa-2x"></i>
                                <span>Đăng xuất</span>
                            </a>
                        <?php else: ?>
                            <!-- Nếu chưa đăng nhập -->
                            <a href="login.php" class="text-success d-flex flex-column align-items-center mx-3">
                                <i class="fas fa-sign-in-alt fa-2x"></i>
                                <span>Đăng nhập</span>
                            </a>
                            <a href="register.php" class="text-success d-flex flex-column align-items-center mx-3">
                                <i class="fas fa-user-plus fa-2x"></i>
                                <span>Đăng ký</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
        </div>
        </nav>
    </div>
    </div>
    <!-- Navbar End -->
</body>

</html>