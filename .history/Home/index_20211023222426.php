<?php
include("./connection.php");
$sql = "SELECT * FROM SanPham";
$rs = mysqli_query($conn, $sql);

$sql1 = "SELECT * FROM sanpham INNER JOIN loaisanpham on sanpham.MLSP = loaisanpham.MLSP WHERE loaisanpham.TenLSP LIKE 'Điện thoại'";
$rs1 = mysqli_query($conn, $sql1);

$sql_brand = "SELECT * FROM NhanHieu";
$rs_brand = mysqli_query($conn, $sql_brand);

$sql_category = "SELECT * FROM LoaiSanPham WHERE NOT LoaiSanPham.TenLSP = 'Điện thoại'";
$rs_category = mysqli_query($conn, $sql_category);

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HNStore</title>
    <!--Reset CSS -->
    <link rel="stylesheet" href="./asset/normalize.css" />
    <!-- CSS and font of Web -->
    <link rel="stylesheet" href="./asset/base.css" />
    <link rel="stylesheet" href="./asset/main.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./asset/fonts/fontawesome-free-5.15.4/css/all.min.css">

</head>

<body>
    <div class="main">

        <?php include("./header.php"); ?>
        <div class="main_container">
            <div class="grid">
                <div class="grid_row main_content">

                    <div class="grid_col-12 ctn-box ctn-mb">
                        <div class="cnt_title">
                            <h2>Khuyến mãi hot</h2>
                            <i class="fas fa-fire-alt"></i>
                        </div>
                        <div class="main_product">
                            <div class="grid_row">

                                <!-- Product Item -->
                                <?php
                                while ($product_sale = mysqli_fetch_array($rs)) {

                                ?>
                                    <div class="grid_col-3">
                                        <div class="product-item">
                                            <a href="./product-detail.php?action=prd-detail&id=<?php echo $product_sale['MSSP']?>" class="product-img">
                                                <div class="product-item_img" style="background-image: url('../img_upload/<?php echo $product_sale['Avatar'] ?>');"></div>
                                            </a>
                                            <h3 class="product-item_name"><?php echo $product_sale['TenSP'] ?></h3>
                                            <div class="product-item_price">
                                                <span class="product-item_price-old"><?php echo number_format($product_sale['Gia'], 0, ',', '.') ?></span>
                                                <span class="product-item_price-new"><?php echo number_format($product_sale['GiaBan'], 0, ',', '.') ?></span>
                                            </div>
                                            <span class="product-item_description"><?php echo $product_sale['MoTa'] ?></span>
                                            <div class="product-item_rating">
                                                <i class="product-item_rating-check fa fa-star"></i>
                                                <i class="product-item_rating-check fa fa-star"></i>
                                                <i class="product-item_rating-check fa fa-star"></i>
                                                <i class="product-item_rating-check fa fa-star"></i>
                                                <i class="product-item_rating-check fa fa-star"></i>
                                                <span class="product-item_rating-reviews">19 lượt đánh giá</span>
                                            </div>
                                            <div class="product-item_sale-off">
                                                <span class="product-item_sale-off-label">GIẢM</span>
                                                <span class="product-item_sale-off-precent">10%</span>
                                            </div>
                                            <div class="product-item_oder">
                                                <a href="./product-detail.php?action=prd-detail&id=<?php echo$product_sale['MSSP']?>" class="button button_general btn product-item_oder-btn">Chi tiết sản phẩm</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php }; ?>

                            </div>
                        </div>
                    </div>
                    <div class="grid_col-12 ctn-box ctn-mb">
                        <div class="cnt_title">
                            <h2>Điện thoại nổi bật</h2>
                        </div>
                        <div class="main_product">
                            <div class="grid_row">

                                <!-- Product Item -->
                                <?php
                                while ($product = mysqli_fetch_array($rs1)) {

                                ?>
                                    <div class="grid_col-3">
                                        <div class="product-item">
                                            <a href="./product-detail.php?id=<?php echo $product['MSSP']?>" class="product-img">
                                                <div class="product-item_img" style="background-image: url('../img_upload/<?php echo $product['Avatar'] ?>');"></div>
                                            </a>
                                            <h3 class="product-item_name"><?php echo $product['TenSP'] ?></h3>
                                            <div class="product-item_price">
                                                <span class="product-item_price-old"><?php echo number_format($product['Gia'], 0, ',', '.') ?></span>
                                                <span class="product-item_price-new"><?php echo number_format($product['GiaBan'], 0, ',', '.') ?></span>
                                            </div>
                                            <span class="product-item_description"><?php echo $product['MoTa'] ?></span>
                                            <div class="product-item_rating">
                                                <i class="product-item_rating-check fa fa-star"></i>
                                                <i class="product-item_rating-check fa fa-star"></i>
                                                <i class="product-item_rating-check fa fa-star"></i>
                                                <i class="product-item_rating-check fa fa-star"></i>
                                                <i class="product-item_rating-check fa fa-star"></i>
                                                <span class="product-item_rating-reviews">19 lượt đánh giá</span>
                                            </div>
                                            <div class="product-item_sale-off">
                                                <span class="product-item_sale-off-label">GIẢM</span>
                                                <span class="product-item_sale-off-precent">10%</span>
                                            </div>
                                            <div class="product-item_oder">
                                            <a href="./product-detail.php" class="button button_general btn product-item_oder-btn">Chi tiết sản phẩm</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php }; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="grid">
                <div class="grid_row">
                    <div class="grid_col-2-4">
                        <h3 class="footer_heading">Chăm sóc khách hàng</h3>
                        <ul class="footer-list">
                            <li class="footer-item">
                                <a href="" class="footer-item_link">Trợ giúp</a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item_link">Email</a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item_link">SĐT hỗ trợ : 0123456789</a>
                            </li>
                        </ul>
                    </div>
                    <div class="grid_col-2-4">
                        <h3 class="footer_heading">HNShop</h3>
                        <ul class="footer-list">
                            <li class="footer-item">
                                <a href="" class="footer-item_link">Giới thiệu</a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item_link">Điều khoản</a>
                            </li>
                        </ul>
                    </div>
                    <div class="grid_col-2-4">
                        <h3 class="footer_heading"></h3>
                    </div>
                    <div class="grid_col-2-4">
                        <h3 class="footer_heading">Danh mục</h3>
                        <ul class="footer-list">
                            <li class="footer-item">
                                <a href="" class="footer-item_link">Giới thiệu</a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item_link">Điều khoản</a>
                            </li>
                        </ul>
                    </div>
                    <div class="grid_col-2-4">
                        <h3 class="footer_heading">Theo dõi chúng tôi</h3>
                        <ul class="footer-list">
                            <li class="footer-item">
                                <a href="" class="footer-item_link">
                                    <i class="fab fa-facebook footer-item_icon"></i>
                                    <span class="footer_facebook-link">Facebook</span>
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="" class="footer-item_link">
                                    <i class="fab fa-instagram footer-item_icon"></i>
                                    <span class="footer_instagram-link">Instagram</span>

                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer_bottom">
                <div class="grid">
                    <p class="footer_title">&copy; 2021 - Design by HoangNam</p>
                </div>
            </div>
        </footer>
    </div>



        <script>

            // // Lấy đối tượng Login
            // var popupLogin = document.getElementById("popupLogin");
            // // Thêm sự kiện cho đối tượng
            // popupLogin.addEventListener('click', function(){
            //     // popupOpen('modalLg');
            //     popupOpen('modalLg');
            // });
            // var popupLoginClose = document.getElementById("lgclose");
            // // Thêm sự kiện cho đối tượng
            // popupLoginClose.addEventListener('click', function(){
            //     // popupClose("modalLg");
            //     popupClose('modalLg');

            // });

            // // Lấy đối tượng Register
            // var popupRegister = document.getElementById("popupRegister");
            // // Thêm sự kiện cho đối tượng
            // popupRegister.addEventListener('click', function(){
            //     // popupOpen('modalLg');
            //     popupOpen('modalRg');
            // });
            // var popupRegisterClose = document.getElementById("rgclose");
            // // Thêm sự kiện cho đối tượng
            // popupRegisterClose.addEventListener('click', function(){
            //     // popupClose("modalLg");
            //     popupClose('modalRg');

            // });
        
        </script>

    <script src="./asset/jquery/main.js"></script>
    <script src="./asset/jquery/jquery.js"></script>
    <script>
// Ajax
$( "#form-login" ).submit(function( event ) {
  event.preventDefault();
  $.ajax({
    type: "POST",
    url: './test-be.php',
    data: $(this).serializeArray(),
    success: function(result){
        console.log('result: ', result);
    }
    });
});
</script>
</body>

</html>