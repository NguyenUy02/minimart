<?php include 'header.php'; ?>
<title>Đăng nhập</title>

    <!-- Poster Start -->
<div class="container-fluid py-5 mb-5 hero-header">
    <div class="container py-5 d-flex justify-content-center align-items-center">
        <div class="col-md-12 col-lg-4">
            <form action="login_Check.php" method="post">
                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger">
                        <?php echo $_GET['error']; ?>
                    </div>
                <?php } ?>
                <div class="mb-3">
                    <label for="SDT" class="form-label">Số điện thoại đăng nhập</label>
                    <input type="text" name="SDT" id="SDT" class="form-control" placeholder="Số điện thoại"
                        value="<?php echo isset($_GET['SDT']) ? $_GET['SDT'] : ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="MATKHAU" class="form-label">Mật khẩu</label>
                    <input type="password" name="MATKHAU" id="MATKHAU" class="form-control" placeholder="Mật khẩu">
                </div>
                <div class="mb-3 d-flex justify-content-center">
                    <input type="submit" name="submit" class="btn btn-success btn-block mt-2" value="Đăng nhập" />
                </div>
            </form>
        </div>
    </div>
    <p class="text-center  mt-4" style="font-size:20px">Chưa có tài khoản? <a href="register.php" class="text-success">Đăng ký</a></p>
</div>
    
    <!-- Poster End -->

<?php include 'footer.php' ?>
<style>
    form{
        color: black;
    }
</style>