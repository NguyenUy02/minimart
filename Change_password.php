<?php
include 'login_required.php'; 
include 'header.php';
$result = mysqli_query($conn, "SELECT * FROM nguoidung  WHERE nguoidung.MAND = '{$_SESSION['MAND']}'");
?>
<title>Đổi mật khẩu</title>
<?php if (mysqli_num_rows($result) != 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <h1 class="mb-4 text-white">Thông tin cá nhân</h1>
                <div class="col-lg-12">         
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <!-- <div class="row g-4"> -->
                            <div class="mb-3">
                                <h2>Danh mục tùy chọn</h2>
                                <a class="list-group-item" href="user">Thông tin chung</a>
                                <a class="list-group-item" href="user_orders.php">Lịch sử đơn hàng</a>
                                <a class="list-group-item  active" href="user_changeinfo.php">Chỉnh sửa thông tin cá nhân</a>
                            </div>                          
                                                        
                            <!-- </div> -->
                        </div>
                        <div class="col-lg-9"><H2>Đổi mật khẩu</H2>   
                            <!-- <div class="col-lg-12"> -->                         
                            <div class="card-body">                         
                                <form method="post" action="Changepass_Check.php" class="row text-dark">
                                    <div class="col-md-9">
                                        <div class="form-row">
                                            <div class="col form-group col-md-9 my-3">
                                                <p class="text text-success"><?php if (isset($_GET['success'])) echo $_GET['success'] ?></p>
                                                <label>Nhập mật khẩu hiện tại</label>
                                                <div>
                                                    <small class="text-danger"><?php if (isset($_GET['op_error'])) echo $_GET['op_error'] ?></small>
                                                    <input type="password" class="form-control" name="MATKHAU" id="MATKHAU">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col form-group col-md-9 my-3">
                                                <label>Nhập mật khẩu mới</label>
                                                <div>
                                                    <small class="text-danger" ><?php if (isset($_GET['np_error'])) echo $_GET['np_error'] ?></small>
                                                    <input type="password" class="form-control" name="MATKHAUMOI" id="MATKHAUMOI">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="col form-group col-md-9">                                  
                                            <label>Nhập lại mật khẩu</label>
                                            <div>
                                            <small class="text-danger"><?php if (isset($_GET['c_np_error'])) echo $_GET['c_np_error'] ?></small>
                                                <input type="password" class="form-control" name="CONFIRM_MATKHAU"
                                                    id="CONFIRM_MATKHAU">
                                            </div>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-offset-2 col-md-10">
                                                <input type="submit" value="Lưu" name="saveChanges" class="btn btn-success mt-2 mr-2"
                                                    id="save_info" />
                                                <a href="user_changeinfo.php" class="btn btn-light mt-2">Quay lại</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div> <!-- card-body .// --><!-- </div> -->                          
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
<?php include 'footer.php' ?>