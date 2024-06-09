<?php
session_start();
if(!isset($_SESSION['MAAD']) && !isset($_SESSION['MANV']))
{
    header("Location: ../../../../login.php");
    exit();
}
include 'db_connect.php';
$userType = isset($_SESSION['MAAD']) ? 'MAAD' : 'MANV';
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <link href="assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="dist/css/style.min.css" rel="stylesheet">   
</head>
<style>
    body, a, span, li, p, h1, h2, h3, h4, h5, h6 {
        color: #000000;
        font-family: Arial, sans-serif;
    }
</style>
<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md">
                <div class="navbar-header" data-logobg="skin6">
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <div class="navbar-brand">
                        <a href="index.php">
                            <b class="logo-icon">
                                <img src="assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                                <img src="assets/images/logo-icon.png" alt="homepage" class="light-logo" />
                            </b>
                            <span class="logo-text">
                                <img src="assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                                <img src="assets/images/logo-light-text.png" class="light-logo" alt="homepage" />
                            </span>
                        </a>
                    </div>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
                        <?php
                            $count = "SELECT COUNT(*) FROM hoadon WHERE TINHTRANGDONHANG = 'Đang xử lý'";
                            $result = mysqli_query($conn, $count);
                            $row = mysqli_fetch_row($result);
                            $countOrders = $row[0];
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="#" id="bell" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span><i data-feather="bell" class="svg-icon"></i></span>
                                <span class="badge badge-danger notify-no rounded-circle"><?php echo $countOrders; ?></span>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav float-right">                       
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="assets/images/users/profile-pic.jpg" alt="user" class="rounded-circle"
                                    width="40">
                                <span class="ml-2 d-none d-lg-inline-block"><span>Hello,</span> 
                                <span class="text-dark">Admin</span></span>
                            </a>                          
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="left-sidebar" data-sidebarbg="skin6" style="border: 1px solid #000;">
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <nav class="sidebar-nav pt-0">
                    <ul id="sidebarnav">
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="index.php"
                                aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                                    class="hide-menu">Trang chủ</span></a>
                        </li>

                        <?php if ($userType == 'MAAD' || $userType == 'MANV') : ?>
                        <li class="nav-small-cap"><span class="hide-menu">Quản lý</span></li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="product.php"
                                aria-expanded="false"><i data-feather="package" class="feather-icon"></i><span
                                    class="hide-menu">Sản phẩm
                                </span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="category.php"
                                aria-expanded="false"><i data-feather="grid" class="feather-icon"></i><span
                                    class="hide-menu">Loại sản phẩm
                                </span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="brand.php"
                                aria-expanded="false"><i data-feather="tag" class="feather-icon"></i><span
                                    class="hide-menu">Thương hiệu
                                </span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="users.php"
                                aria-expanded="false"><i data-feather="user" class="feather-icon"></i><span
                                    class="hide-menu">Tài khoản
                                </span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="orders.php"
                                aria-expanded="false"><i data-feather="list" class="feather-icon"></i><span
                                    class="hide-menu">Hóa đơn
                                </span></a>
                        </li>
                        <!-- <li class="sidebar-item"> <a class="sidebar-link" href="barcode_scanner.php"
                                aria-expanded="false"><i data-feather="eye" class="feather-icon"></i><span
                                    class="hide-menu">Quét thanh toán
                                </span></a>
                        </li> -->
                        <?php endif; ?>

                        <?php if ($userType == 'MAAD') : ?>
                        <li class="nav-small-cap"><span class="hide-menu">Thống kê</span></li>
                        <?php
                            // Lấy số lượng sản phẩm có số lượng < 20
                            $query = "SELECT COUNT(*) as count FROM sanpham WHERE soluong < 20";
                            $result = $conn->query($query);
                            $row = $result->fetch_assoc();
                            $product_count = $row['count'];
                        ?>
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="notification.php"
                                aria-expanded="false"><i data-feather="box" class="feather-icon"></i><span
                                    class="hide-menu">Nhập hàng (<?php echo $product_count; ?>)
                                </span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="statictis.php"
                                aria-expanded="false"><i data-feather="file-text" class="feather-icon"></i><span
                                    class="hide-menu">Thống kê doanh thu
                                </span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="statictis_product.php"
                                aria-expanded="false"><i data-feather="file-text" class="feather-icon"></i><span
                                    class="hide-menu">Sản phẩm bán được
                                </span></a>
                        </li>
                        <?php endif; ?>

                        <li class="nav-small-cap"><span class="hide-menu">Đăng xuất</span></li>                   
                        <li class="sidebar-item"> <a class="sidebar-link" href="logout_admin.php"
                                aria-expanded="false"><i data-feather="log-out" class="feather-icon"></i><span
                                    class="hide-menu">Đăng xuất
                                </span></a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
</body>
</html>
