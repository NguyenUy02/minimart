<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Kết quả thanh toán VNPAY</title>
        <link href="../img/favio.png" rel="shortcut icon" type="image/x-icon">
        <!-- Bootstrap core CSS -->
        <link href="/vnpay_php/assets/bootstrap.min.css" rel="stylesheet"/>
        <!-- Custom styles for this template -->
        <link href="/vnpay_php/assets/jumbotron-narrow.css" rel="stylesheet">         
        <script src="/vnpay_php/assets/jquery-1.11.3.min.js"></script>
        
    </head>
    
    <body>
    <?php 
        require_once("./config.php"); 
        include '../login_required.php';      
        include("../connect.php");
        
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        ?>
        <!--Begin display -->
        <div class="row justify-content-md-center mt-5 mb-5">
                
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="text-muted">HÓA ĐƠN VNPAY</h3>
                    </div>
                    <div class="table-responsive">
                        <div class="form-group">
                            <label >Mã đơn hàng:</label>
                            <label><?php echo $_GET['vnp_TxnRef'] ?></label>
                        </div>    
                        <div class="form-group">
                            <label>Số tiền:</label>
                            <strong><?php echo number_format($_GET['vnp_Amount'] / 100, 2)?></strong>
                        </div> 
                        <div class="form-group">
                            <label >Nội dung thanh toán:</label>
                            <label><?php echo $_GET['vnp_OrderInfo'] ?></label>
                        </div> 
                        <div class="form-group">
                            <label >Mã phản hồi (vnp_ResponseCode):</label>
                            <label><?php echo $_GET['vnp_ResponseCode'] ?></label>
                        </div> 
                        <div class="form-group">
                            <label >Mã GD Tại VNPAY:</label>
                            <label><?php echo $_GET['vnp_TransactionNo'] ?></label>
                        </div> 
                        <div class="form-group">
                            <label >Mã Ngân hàng:</label>
                            <label><?php echo $_GET['vnp_BankCode'] ?></label>
                        </div> 
                        <div class="form-group">
                            <label >Thời gian thanh toán:</label>
                            <label><?php echo $_GET['vnp_PayDate'] ?></label>
                        </div> 
                        <div class="form-group">
                            <label>Kết quả:</label>
                            <label>
                                <?php
                                if ($secureHash == $vnp_SecureHash) {
                                    if ($_GET['vnp_ResponseCode'] == '00') {
                                        echo "<span style='color:blue'>GD Thanh cong</span>";
                                    } else {
                                        echo "<span style='color:red'>GD Khong thanh cong</span>";
                                    }
                                } else {
                                    echo "<span style='color:red'>Chu ky khong hop le</span>";
                                }
                                ?>

                            </label>
                        </div> 
                        <div class="form-group text-center">
                            <a href="../index.php" class="btn btn-secondary">Trở về trang chủ</a>
                        </div>
                    </div>
                </div> 
                <p>
                    &nbsp;
                </p>
                <footer class="footer text-center">
                    <p>&copy; VNPAY <?php echo date('Y')?></p>
                </footer>
            </div> 
        </div>  
    </body>
</html>
<?php

function LayMaHoaDon($db) {
    // Lấy danh sách các MAND từ bảng HOADON
    $query = "SELECT MAHD FROM hoadon";
    $result = mysqli_query($db, $query);

    // Lấy MAHOADON lớn nhất
    $maMax = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $maHD = $row['MAHD'];
        if ($maHD > $maMax) {
            $maMax = $maHD;
        }
    }

    // Tạo mã ND mới
    $maHD = intval(substr($maMax, 2)) + 1;
    $HD = str_pad($maHD, 4, '0', STR_PAD_LEFT);
    return 'HD' . $HD;
}
if ($secureHash == $vnp_SecureHash) {
    if ($_GET['vnp_ResponseCode'] == '00') {
        $mahd = LayMaHoaDon($conn);

        //Thêm vào bảng hóa đơn
        mysqli_query($conn,"INSERT INTO `hoadon` (`MAHD`, `MAND`, `NGAYTAO`, `TINHTRANGDONHANG`) 
        VALUES ('$mahd', '{$_SESSION['MAND']}', NOW(), 'Đang xử lý');");


        $selectedProducts = $_SESSION['selectedProducts'];
        //Thêm từng chi tiết hóa đơn
        foreach ($selectedProducts as $product) {
            $masp = $product['MASP'];
            $soluong = $product['SOLUONG'];
            
            // Lấy số lượng sản phẩm hiện tại trong bảng SANPHAM
            $soluonghientai_query = mysqli_query($conn,"SELECT SOLUONG FROM sanpham WHERE MASP = '$masp' LIMIT 1");
            $row = mysqli_fetch_assoc($soluonghientai_query);
            $soluonghientai = $row['SOLUONG'];
            
            // Kiểm tra tình trạng đơn hàng
            $tinhtrangdonhang_query = mysqli_query($conn,"SELECT TINHTRANGDONHANG FROM hoadon WHERE MAHD = '$mahd' LIMIT 1");
            $row = mysqli_fetch_assoc($tinhtrangdonhang_query);
            $tinhtrangdonhang = $row['TINHTRANGDONHANG'];
            
            // Nếu tình trạng đơn hàng là "Đã giao thành công" thì trừ số lượng sản phẩm
            if ($tinhtrangdonhang == "Đang giao hàng" || $tinhtrangdonhang == "Đang xử lý" || $tinhtrangdonhang == "Giao hàng thành công") {
                $soluongmoi = $soluonghientai - $soluong;
                
                // Cập nhật số lượng sản phẩm trong bảng SANPHAM
                mysqli_query($conn,"UPDATE sanpham SET SOLUONG = $soluongmoi WHERE MASP = '$masp'");
            }
            else if($tinhtrangdonhang == "Giao hàng thất bại"){
                $soluongmoi = $soluonghientai;
                // Cập nhật số lượng sản phẩm trong bảng SANPHAM
                mysqli_query($conn,"UPDATE sanpham SET SOLUONG = $soluongmoi WHERE MASP = '$masp'");
                }
            
            // Thêm chi tiết hóa đơn vào bảng chitiethoadon
            $dongiaxuat_query = mysqli_query($conn,"SELECT DONGIA FROM giohang WHERE MASP = '$masp' AND MAND = '{$_SESSION['MAND']}' LIMIT 1");
            $row = mysqli_fetch_assoc($dongiaxuat_query);
            $dongia = $row['DONGIA'];
            mysqli_query($conn,"INSERT INTO `chitiethoadon` (`MAHD`, `MASP`, `SOLUONGMUA`, `DONGIAXUAT`) 
        VALUES ('$mahd', '$masp', $soluong,  $dongia)");
        }
        // Xóa sản phẩm đã thanh toán khỏi bảng giỏ hàng
        foreach ($selectedProducts as $product) {
            $masp = $product['MASP'];
            mysqli_query($conn, "DELETE FROM giohang WHERE MASP = '$masp' AND MAND = '{$_SESSION['MAND']}'");
        }
    }
}
?>
<style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .card {
            width: 400px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }

        h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .text-center {
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .btn-primary {
            display: inline-block;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: 1px solid #007bff;
            border-radius: 5px;
            cursor: pointer;
        }

        footer {
            margin-top: 20px;
            font-size: 14px;
            color: #999;
        }
    </style>