<?php
include 'login_required.php'; 
include 'header.php';
$result = mysqli_query($conn, "SELECT * FROM nguoidung  WHERE nguoidung.MAND = '{$_SESSION['MAND']}'");
?>
<title>Thay đổi thông tin</title>
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
                                <a class="list-group-item active" href="user.php">Thông tin chung</a>
                                <a class="list-group-item" href="user_orders.php">Lịch sử đơn hàng</a>
                                <a class="list-group-item" href="user_changeinfo.php">Chỉnh sửa thông tin cá nhân</a>
                            </div>                          
                                                        
                            <!-- </div> -->
                        </div>
                        <div class="col-lg-9"><H2>Chỉnh sửa thông tin</H2>   
                            <!-- <div class="col-lg-12"> -->                         
                            <div class="card-body">                         
                                <form method="post" action="update_info.php" class="row">
                                    <div class="col-md-9">
                                        <div class="form-row">
                                            <div class="col form-group display-flex my-3">
                                                <div class="d-flex justify-content-between">
                                                    <label>Họ và tên</label>
                                                    <small class="text-danger">
                                                        <?php if (isset($_GET['tennd_error']))
                                                            echo $_GET['tennd_error'] ?>
                                                        </small>
                                                </div>
                                                <div>
                                                    <input type="text" class="form-control" name="TENND" id="TENND" value="<?php if (isset($row['TENND']))
                                                        echo $row['TENND'] ?>">
                                                </div>
                                            </div>

                                            <div class="col form-group my-3">
                                                <div class="d-flex justify-content-between">
                                                    <label>Giới tính</label>
                                                    <small class="text-danger">
                                                        <?php if (isset($_GET['gioitinh_error'])) echo $_GET['gioitinh_error'] ?>
                                                    </small>
                                                </div>
                                                <div>
                                                    <select class="form-control" name="GIOITINH" id="GIOITINH">
                                                        <option value="">-- Chọn giới tính --</option>
                                                        <option value="Nam" <?php if (isset($row['GIOITINH']) && $row['GIOITINH'] == 'Nam') echo 'selected' ?>>Nam</option>
                                                        <option value="Nữ" <?php if (isset($row['GIOITINH']) && $row['GIOITINH'] == 'Nữ') echo 'selected' ?>>Nữ</option>
                                                    </select>
                                            </div>                                       
                                        </div>
                                        <div class="form-row">
                                            <div class="col form-group my-3">
                                                <div class="d-flex justify-content-between">
                                                    <label>Số điện thoại</label></label>
                                                    <small class="text-danger">
                                                        <?php if (isset($_GET['sdt_error']))
                                                        echo $_GET['sdt_error'] ?>
                                                    </small>
                                                </div>
                                                <div>
                                                    <input disabled type="text" class="form-control" name="SDT" id="SDT" value="<?php if (isset($row['SDT']))
                                                        echo $row['SDT'] ?>">

                                                </div>
                                            </div>
                                            <div class="col form-group my-3">
                                                <div class="d-flex justify-content-between">
                                                    <label>Địa chỉ</label>
                                                    <small class="text-danger">
                                                    <?php if (isset($_GET['diachi_error']))
                                                        echo $_GET['diachi_error'] ?>
                                                    </small>
                                                </div>
                                                <div>
                                                    <input type="text" class="form-control" name="DIACHI" id="DIACHI" value="<?php if (isset($row['DIACHI']))
                                                        echo $row['DIACHI'] ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-offset-2 col-md-10">
                                                <input type="submit" value="Lưu" name="saveChanges"
                                                    class="btn btn-primary mr-2" id="save_info" />
                                                <a href="Change_password.php" class="btn btn-light">Đổi mật khẩu</a>
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