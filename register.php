<?php include 'header.php'; ?>
<title>Đăng Ký</title>

<div class="container-fluid py-5 mb-5 hero-header">
    <div class="container py-5 d-flex justify-content-center" >  
        <form method="POST" action="register_check.php" class="col-12 col-md-4">
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

            <div class="form-group " >
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
            </div>
            <div class="form-group">
                <label for="SDT">Email khôi phục</label>
                <input type="text" class="form-control" name="EMAIL" id="EMAIL" value="<?php if (isset($_GET['EMAIL']))
                echo $_GET['EMAIL'] ?>">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="MATKHAU">Mật khẩu</label>
                    <input type="password" class="form-control" name="MATKHAU" id="MATKHAU">
                </div>
                <div class="form-group">
                    <label for="CONFIRM-MATKHAU">Nhập lại mật khẩu</label>
                    <input type="password" class="form-control" id="CONFIRM-MATKHAU" name="CONFIRM-MATKHAU">
                    <div id="password-error" class="text-danger"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-group col-md-6">
                    <label for="GIOITINH">Giới Tính</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="GIOITINH" id="GIOITINH-nam" value="Nam"
                            <?php if (isset($_GET['GIOITINH']) && $_GET['GIOITINH'] === 'Nam') echo 'checked'; ?>>
                        <label class="form-check-label" for="GIOITINH-nam">Nam </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="GIOITINH" id="GIOITINH-nu" value="Nữ"
                            <?php if (isset($_GET['GIOITINH']) && $_GET['GIOITINH'] === 'Nữ') echo 'checked'; ?>>
                        <label class="form-check-label" for="GIOITINH-nu">Nữ</label>
                    </div>
                </div>  
            </div>

            <div class="form-group">
                <label for="DIACHI">Địa chỉ</label>
                <input type="text" class="form-control" name="DIACHI" id="DIACHI" value="<?php if (isset($_GET['DIACHI']))
                echo $_GET['DIACHI'] ?>">
            </div>

            <div class="form-group">
                <input type="submit" value="Đăng ký" class="btn btn-success btn-block mt-3" id="register-button">
            </div>
        </form>
    </div>
</div>

    <!-- Poster End -->

<?php include 'footer.php' ?>
<style>
    form{
        color: black;
    }
</style>