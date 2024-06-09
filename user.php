<?php
include 'login_required.php'; 

if (!isset($_SESSION['MAND'])) {
    header("Location: login.php");
    exit();
}
include 'header.php';
$result = mysqli_query($conn, "SELECT * FROM nguoidung 
    WHERE nguoidung.MAND = '{$_SESSION['MAND']}'");
?>
<title>Thông tin cá nhân</title>
<?php if (mysqli_num_rows($result) <> 0): ?>
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
                            <div class="position-relative">
                                <img src="img/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                                    <h3 class="text-secondary fw-bold">. <br> . <br> .</h3>
                                </div>
                            </div>                           
                            <!-- </div> -->
                        </div>
                        <div class="col-lg-9"><H2>Thông tin tài khoản</H2>   
                        <?php
                            // Kiểm tra xem người dùng đã chọn ảnh đại diện mới hay chưa
                            if (isset($_FILES['avatar'])) {
                                $file = $_FILES['avatar'];
                                $uploadDir = 'adminmart-master/assets/images/users/'; // Đường dẫn tới thư mục lưu trữ ảnh đại diện

                                // Kiểm tra và di chuyển tệp tin tải lên vào thư mục lưu trữ
                                if ($file['error'] === UPLOAD_ERR_OK) {
                                    $fileName = 'avatar.jpg'; // Tên tệp tin cố định
                                    $filePath = $uploadDir . $fileName;
                                    move_uploaded_file($file['tmp_name'], $filePath);

                                    // Lưu đường dẫn ảnh đã chọn vào tệp tin
                                    file_put_contents('adminmart-master/assets/images/users/file.txt', $filePath);
                                }
                            }
                            ?>                         
                            <div class="card-body">                         
                                <figure class="icontext">
                                    <div class="d-flex align-items-center">
                                        <div class="icon">
                                            <img class="rounded-circle img-sm border avatar-img" src="<?php echo $row['ANHDAIDIEN'] ? $row['ANHDAIDIEN'] : 'img/avatar.jpg'; ?>" data-id="<?php echo $row['MAND']; ?>">
                                        </div>
                                        <div class="text d-flex flex-column flex-grow-1 ms-3">
                                            
                                                <strong><?php echo $row['TENND']; ?></strong>
                                                <p class="mb-0"><?php echo $row['SDT']; ?></p>
                                                <form method="POST" enctype="multipart/form-data">
                                                    <input type="file" accept="image/*" class="d-none" name="avatar" id="avatar-input">
                                                    <label for="avatar-input" class="btn btn-light btn-sm edit-avatar">Chỉnh sửa</label>
                                                    <button type="submit" class="btn btn-success btn-sm">Lưu</button>
                                                </form>  
                                        </div>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            var avatarImg = $('.icontext .avatar-img');
                                            var avatarInput = $('#avatar-input');
                                            var MAND = '<?php echo $row['MAND']; ?>';

                                            // Kiểm tra nếu đã có ảnh được chọn từ trước
                                            if (localStorage.getItem('selectedAvatar_' + MAND)) {
                                                avatarImg.attr('src', localStorage.getItem('selectedAvatar_' + MAND));
                                            }

                                            avatarInput.change(function() {
                                                var input = this;

                                                if (input.files && input.files[0]) {
                                                    var reader = new FileReader();
                                                    reader.onload = function(e) {
                                                        var newAvatarUrl = e.target.result;
                                                        avatarImg.attr('src', newAvatarUrl);
                                                        localStorage.setItem('selectedAvatar_' + MAND, newAvatarUrl);

                                                        // Gửi đường dẫn ảnh đã chọn lên máy chủ để lưu vào tệp tin
                                                        $.ajax({
                                                            url: 'user_avatar.php', // Đường dẫn đến file PHP xử lý việc lưu ảnh
                                                            type: 'POST',
                                                            data: { avatarUrl: newAvatarUrl },
                                                            success: function(response) {
                                                                // Xử lý kết quả sau khi lưu ảnh thành công
                                                            }
                                                        });
                                                    };
                                                    reader.readAsDataURL(input.files[0]);
                                                }
                                            });
                                        });
                                    </script>
                                </figure>                           
                                <hr>  <!-- gạch ngang -->
                                <p>
                                    <i class="fa fa-map-marker text-muted"></i> &nbsp; Địa chỉ của tôi:<br>
                                    <?php echo $row['DIACHI']; ?>
                                </p>
                                <article class="card-group card-stat">
                                    <figure class="card bg">
                                        <div class="p-3">
                                            <h4 class="title">
                                            <?php
                                            $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM nguoidung 
                                            JOIN hoadon ON nguoidung.MAND = hoadon.MAND
                                            WHERE nguoidung.MAND = '{$_SESSION['MAND']}'");
                                            $row = mysqli_fetch_assoc($result);
                                            $total = $row['total'];
                                            echo $total;
                                            ?>
                                            </h4>
                                            <span>Đơn đặt hàng</span>
                                        </div>
                                    </figure>
                                    <figure class="card bg">
                                        <div class="p-3">
                                            <h4 class="title">
                                            <?php
                                            $query = "SELECT SUM(ct.SOLUONGMUA) AS total
                                            FROM hoadon hd
                                            JOIN chitiethoadon ct ON hd.MAHD = ct.MAHD
                                            join nguoidung on hd.MAND = nguoidung.MAND
                                            WHERE hd.TINHTRANGDONHANG = 'Giao hàng thành công' and nguoidung.MAND = '{$_SESSION['MAND']}'";
                                            $result = mysqli_query($conn, $query);
                                            $row = mysqli_fetch_assoc($result);
                                            $total = $row['total'];
                                            echo isset($total) ? $total : 0;
                                            ?>
                                            </h4>
                                            <span>Sản phẩm đã mua</span>
                                        </div>
                                    </figure>
                                    <figure class="card bg">
                                        <div class="p-3">
                                            <h4 class="title">
                                                <?php
                                                $result = mysqli_query($conn, "SELECT count(hoadon.MAHD) as total
                                                from hoadon join nguoidung on hoadon.MAND = nguoidung.MAND
                                                where hoadon.MAND = '{$_SESSION['MAND']}'and hoadon.TINHTRANGDONHANG = 'Đang giao hàng'");
                                                $row = mysqli_fetch_assoc($result);
                                                $total = $row['total'];
                                                echo isset($total) ? $total : 0;
                                                ?>
                                            </h4>
                                            <span>Đơn hàng đang giao</span>
                                        </div>
                                    </figure>
                                    <figure class="card bg">
                                        <div class="p-3">
                                            <h4 class="title">
                                                <?php
                                                $result = mysqli_query($conn, "SELECT count(hoadon.MAHD) as total
                                                from hoadon join nguoidung on hoadon.MAND = nguoidung.MAND
                                                where hoadon.MAND = '{$_SESSION['MAND']}'and hoadon.TINHTRANGDONHANG = 'Giao hàng thành công'");
                                                $row = mysqli_fetch_assoc($result);
                                                $total = $row['total'];
                                                echo isset($total) ? $total : 0;
                                                ?>
                                            </h4>
                                            <span>Đơn hàng đã giao</span>
                                        </div>
                                    </figure>
                                </article>
                            </div> <!-- card-body .// --><!-- </div> -->                          
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
<?php include 'footer.php' ?>
<style>
    .img-sm {
    width: 75px;
    height: 75px;
}
</style>
