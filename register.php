<?php include 'header.php'; ?>
<title>Đăng Ký</title>

    <!-- Poster Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                <form method="POST" action="register_check.php">
                    <?php if (isset($_GET['error'])) { ?>
                        <div class="alert alert-danger">
                            <?php echo $_GET['error']; ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($_GET['success'])) { ?>
                        <p class="alert alert-success">
                            <?php echo $_GET['success']; ?>
                        </p>
                    <?php } ?>

                    <div class="form-group">
                        <label for="TENND">Họ và tên</label>
                        <input type="text" class="form-control" name="TENND" id="TENND" value="<?php if (isset($_GET['TENND']))
                            echo $_GET['TENND'] ?>">
                            <!-- <small class="form-text text-muted">Chúng tôi sẽ không chia sẻ tài khoản của bạn cho bất kỳ ai
                                khác.</small> -->

                        </div>

                        <div class="form-group">
                            <label for="SDT">Số điện thoại đăng nhập</label>
                            <input type="text" class="form-control" name="SDT" id="SDT" value="<?php if (isset($_GET['SDT']))
                            echo $_GET['SDT'] ?>">
                            <!-- Validation message here -->
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="MATKHAU">Mật khẩu</label>
                                <input type="password" class="form-control" name="MATKHAU" id="MATKHAU">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="CONFIRM-MATKHAU">Nhập lại mật khẩu</label>
                                <input type="password" class="form-control" id="CONFIRM-MATKHAU" name="CONFIRM-MATKHAU">
                                <div id="password-error" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="GIOITINH">Giới Tính</label>
                            <select class="form-control" name="GIOITINH" id="GIOITINH">
                                <option value="Chọn giới tính"> </option>
                                <option value="Nam" <?php if (isset($_GET['GIOITINH']) && $_GET['GIOITINH'] === 'Nam') echo 'selected' ?>>Nam</option>
                                <option value="Nữ" <?php if (isset($_GET['GIOITINH']) && $_GET['GIOITINH'] === 'Nữ') echo 'selected' ?>>Nữ</option>
                            </select>
                            <!-- Validation message here -->
                        </div>  

                        <div class="form-group">
                            <label for="DIACHI">Địa chỉ</label>
                            <input type="text" class="form-control" name="DIACHI" id="DIACHI" value="<?php if (isset($_GET['DIACHI']))
                            echo $_GET['DIACHI'] ?>">
                            <!-- Validation message here -->
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Đăng ký" class="btn btn-primary btn-block mt-3" id="register-button">
                        </div>
                    </form>
                </div>
                <!-- Banner -->
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active rounded">
                                <img src="img/hero-img-1.png" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Fruites</a>
                            </div>
                            <div class="carousel-item rounded">
                                <img src="img/hero-img-2.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Vesitables</a>
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

<?php include 'footer.php' ?>