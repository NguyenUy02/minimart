<?php include 'header.php'; ?>
<title>Quên mật khẩu</title>
<?php 
$loi = "";
if (isset($_POST['nutguiyeucau'])) {
    $email = $_POST['email'];
    $conn = mysqli_connect('localhost', 'root', '', 'minimart4');

    mysqli_set_charset($conn, "utf8");

    $sql = "SELECT * FROM nguoidung WHERE EMAIL = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $count = mysqli_num_rows($result);

    if ($count == 0) {
        $loi = "Email bạn nhập chưa đăng ký thành viên với chúng tôi";
    } else {
        $matkhaumoi = substr(md5(rand(0, 999999)), 0, 8);
        $sql = "UPDATE nguoidung SET MATKHAU = ? WHERE EMAIL = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $matkhaumoi, $email);
        mysqli_stmt_execute($stmt);  
        GuiMatKhauMoi($email, $matkhaumoi);
           
       
    }
}

function GuiMatKhauMoi($email, $matkhau){
    require "PHPMailer-master/src/PHPMailer.php"; 
    require "PHPMailer-master/src/SMTP.php"; 
    require 'PHPMailer-master/src/Exception.php'; 

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();  
        $mail->CharSet  = "utf-8";
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'uy.n.62cntt@ntu.edu.vn';
        $mail->Password = '225831327';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;               
        $mail->setFrom('uy.n.62cntt@ntu.edu.vn', 'Uy' ); 
        $mail->addAddress($email); 
        $mail->isHTML(true);  
        $mail->Subject = 'Quênmật khẩu';
        $noidungthu = "<p>Bạn đã quên mật khẩu, Bạn đã gửi yêu cầu gửi mật khẩu mới</p>
            Mật khẩu mới của bạn là: {$matkhau}
            "; 
        $mail->Body = $noidungthu;
        
        $mail->send();
    } catch (Exception $e) {
        echo 'Lỗi: ', $mail->ErrorInfo;
    }
}
?>

<!-- Poster Start -->
<div class="container-fluid py-5 mb-5 hero-header">
    <div class="container py-5 d-flex justify-content-center align-items-center">
        <div class="col-md-12 col-lg-4">
            <form method="post"> 
                <h4 class="text-center">Quên mật khẩu</h4>
                <?php if (!empty($loi)) { ?>
                    <div class="alert alert-danger"><?php echo $loi ?></div>                  
                <?php } ?>
                <div class="mb-3">
                    <label for="email" class="form-label">Nhập email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email"
                        value="<?php if (isset($email)==true) echo $email ?>">
                </div>
                
                <div class="mb-3 d-flex justify-content-center">
                    <button type="submit" name="nutguiyeucau" class="btn btn-success btn-block mt-2" value="nutgui">Gửi yêu cầu</button>
                </div>
            </form>
        </div>
    </div>
</div>
    
<!-- Poster End -->

<?php include 'footer.php' ?>
<style>
    form{
        color: black;
    }
</style>