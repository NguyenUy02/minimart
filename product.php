<?php include 'header.php'; ?>
<title>Sản phẩm</title>
<!-- Poster Start -->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Shop</h1>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">           
                    <div class="col-xl-3">
                        <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                            <label for="fruits">Sắp xếp theo:</label>
                            <select id="fruits" name="fruitlist" class="border-0 form-select-sm bg-light me-3" form="fruitform">
                                <option value="volvo">Nổi bật</option>
                                <option value="saab">Giá giảm</option>
                                <option value="opel">Giá tăng</option>
                                <option value="audi">Phần trăm giảm</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-2">
                        <div class="row g-4">
                            <div class="col-lg-12">
                            <div class="mb-3">
                                <h5>Danh mục sản phẩm</h5>
                                <ul class="list-unstyled fruite-categorie">
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM loaisanpham");
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $TENLSP = $row['TENLSP'];
                                    ?>
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name ">
                                        <a href="#"><i class="fas fa-circle me-2 text-success"></i><span class="text-success"><?php echo $TENLSP; ?></span></a>
                                        </div>
                                    </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4 class="mb-2">Giá</h4>
                                    <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput" min="0" max="500" value="0" oninput="amount.value=rangeInput.value">
                                    <output id="amount" name="amount" min-velue="0" max-value="500" for="rangeInput">0</output>
                                </div>
                            </div>
                            
                            
                            <div class="col-lg-12">
                                <div class="position-relative">
                                    <img src="img/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                    <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                                        <h3 class="text-secondary fw-bold">. <br> . <br> .</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="col-lg-12">
                        <div class="row g-4 justify-content-center">
                        <?php
$result = mysqli_query($conn, "SELECT * FROM sanpham");
if (mysqli_num_rows($result) <> 0) {
    while ($rows = mysqli_fetch_assoc($result)) {
        $gia = $rows['GIA'];
        $sale = $rows['SALE'];
?>

<div class="col-md-6 col-lg-6 col-xl-3">
    <div class="border border-success rounded position-relative fruite-item">
        <div class="fruite-img">
            <img src="img/<?php echo $rows['ANH']; ?>" class="img-fluid w-100 rounded-top" alt="">
        </div>
        <div class="p-4 rounded-bottom">
            <h6><?php echo $rows['TENSP']; ?></h6>
            <p><?php echo $rows['MOTA']; ?></p>
            <div class="d-flex flex-lg-wrap">
                <?php if ($sale > 0) { ?>
                    <p class="text-danger fs-5 fw-bold mb-0"><?php echo $sale . ' đ'; ?></p>
                    <del class="ms-2"><?php echo $gia . ' đ'; ?></del>
                <?php } else { ?>
                    <p class="text-dark fs-5 fw-bold mb-0"><?php echo $gia . ' đ'; ?></p>
                <?php } ?>
            </div>
            <div class="mt-3">
                <a href="#" class="btn border border-success rounded-pill px-3 text-success">
                    <i class="fa fa-shopping-bag me-2 text-success"></i> Thêm vào giỏ</a>
            </div>
        </div>
    </div>
</div>

<?php
    }
}
?>
                            <div class="col-12">
                                <div class="pagination d-flex justify-content-center mt-5">
                                    <a href="#" class="rounded">&laquo;</a>
                                    <a href="#" class="active rounded">1</a>
                                    <a href="#" class="rounded">2</a>
                                    <a href="#" class="rounded">3</a>
                                    <a href="#" class="rounded">4</a>
                                    <a href="#" class="rounded">5</a>
                                    <a href="#" class="rounded">6</a>
                                    <a href="#" class="rounded">&raquo;</a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Poster End -->

<?php include 'footer.php' ?>
<style>
    .fruite-img img {
        width: 100%;
        height: 250px; 
        object-fit: contain; 
    }
</style>