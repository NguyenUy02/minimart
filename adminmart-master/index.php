<?php
include 'header_admin.php';
require 'db_connect.php';
?>
<title>AdminMiniMart</title>
<body>
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-7 align-self-center">
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Welcome</h3>
                </div>
                <div class="col-5 align-self-center">
                    <div class="customize-input float-right">
                        <select class="custom-select custom-select-set form-control bg-white border-0 custom-shadow custom-radius">
                            <option selected>Aug 19</option>
                            <option value="1">July 19</option>
                            <option value="2">Jun 19</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="card-group">
                <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">    
                        <div>
                        <?php 
                            $sql_countKH = "SELECT COUNT(*) FROM nguoidung";
                            $kq = mysqli_query($conn, $sql_countKH);
                            $kq = mysqli_fetch_row($kq);
                        ?>    
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium"><?php echo $kq[0] ?></h2>
                                <span
                                    class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">...</span>
                            </div>
                            <h6 class="text-dark font-weight-normal mb-0 w-100 text-truncate">Khách hàng</h6>
                        </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-dark"><i data-feather="user"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                            <?php                 
                                $sql_countHD = "SELECT COUNT(*) FROM hoadon";
                                $kq = mysqli_query($conn, $sql_countHD);
                                $kq = mysqli_fetch_row($kq);
                            ?>
                                <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><sup
                                        class="set-doller"> +</sup><?php echo $kq[0] ?></h2>
                                <h6 class="text-dark font-weight-normal mb-0 w-100 text-truncate">Tổng đơn đặt hàng
                                </h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-dark"><i data-feather="file-plus"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">...</h2>
                                    <span
                                        class="badge bg-danger font-12 text-white font-weight-medium badge-pill ml-2 d-md-none d-lg-block">...</span>
                                </div>
                                <h6 class="text-dark font-weight-normal mb-0 w-100 text-truncate">Sản phẩm bán được</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-dark"><i data-feather="file-plus"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <?php 
                            $sql_countSP = "SELECT COUNT(*) FROM sanpham";
                            $kq = mysqli_query($conn, $sql_countSP);
                            $kq = mysqli_fetch_row($kq);
                        ?>
                            <div>
                                <h2 class="text-dark mb-1 font-weight-medium"><?php echo $kq[0] ?></h2>
                                <h6 class="text-dark font-weight-normal mb-0 w-100 text-truncate">Sản phẩm</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-dark"><i data-feather="grid"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
      
</body>

<?php
include 'footer_admin.php'
?>