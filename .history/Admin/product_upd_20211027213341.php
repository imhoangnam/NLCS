<?php
include("connection.php");
session_start();
$product_id = $_GET['id'];
$sql = "SELECT * FROM SanPham WHERE SanPham.MSSP = '$product_id';";
$rs = mysqli_query($conn, $sql);

$sql_img = "SELECT * FROM HinhSanPham WHERE HinhSanPham.MSSP = '$product_id';";
$rs_img = mysqli_query($conn, $sql_img);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Main</title>
    <link rel="stylesheet" type="text/css" href="./asset/base.css">
    <link rel="stylesheet" type="text/css" href="./asset/main1.css">
    <link rel="stylesheet" href="./asset/fonts/fontawesome-free-5.15.4/css/all.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="./asset/bootstrap/css/bootstrap.min.css"> -->
</head>

<body>
    <div class="main">
        <div class="grid_full-width wrapper">
            <?php
            include("sidebar.php");
            ?>
            <div class="container">
                <div class="container-title">
                    <h2>Chi tiết sản phẩm</h2>
                </div>

                <div class="product_insert-content">
                    <form action="process.php?action=update-prd" class="product_insert-form" method="POST" enctype="multipart/form-data" role="form">
                        <div class="main_form">
                            <?php while ($product = mysqli_fetch_array($rs)) { ?>
                                <div class="main-form_left">
                                    <div class="form-input">
                                        <label class="form_label">Mã sản phẩm:</label>
                                        <input type="text" class="form_input disable-input" name="product_id" readonly value="<?php echo $product['MSSP'] ?>">
                                    </div>
                                    <div class="form-input">
                                        <label class="form_label">Tên sản phẩm:</label>
                                        <input type="text" class="form_input" name="product_name" value="<?php echo $product['TenSP'] ?>">
                                    </div>
                                    <div class="form-input">
                                        <label class="form_label">Giá</label>
                                        <input type="text" class="form_input" name="product_price" value="<?php echo number_format($product['Gia'], 0, ',', '.') ?>">
                                    </div>
                                    <div class="form-input">
                                        <label class="form_label">Giá bán</label>
                                        <input type="text" class="form_input" name="product_price" value="<?php echo number_format($product['GiaBan'], 0, ',', '.') ?>">
                                    </div>
                                    <div class="form-input">
                                        <label class="form_label">Số lượng hàng</label>
                                        <input type="text" class="form_input" name="product_quantity" value="<?php echo $product['SoLuongHang'] ?>">
                                    </div>
                                    <div class="form-input">
                                        <label class="form_label">Mô tả</label>
                                        <textarea type="text" class="form_textarea" name="product_description"><?php echo $product['MoTa'] ?></textarea>
                                    </div>
                                </div>
                                <div class="main-form_right">
                                    <div class="form-input">
                                        <label class="form_label">Ảnh đại diện sản phẩm:</label>
                                        <div class="prd-avatar">
                                            <img class="prd_img" src="../img_upload/<?php echo $product['Avatar']?>" alt="<?php echo $product['Avatar']?>">
                                        </div>
                                    </div>
                                    <div class="form-input">
                                        <label class="form_label">Thêm ảnh sản phẩm:</label>
                                        <input type="file" class="form_input form_input" name="image_newname">
                                    </div>
                                    <div class="form-input">
                                        <label class="form_label">Loại sản phẩm</label>
                                        <select class="form_input" name="product_category" id="category">
                                            <?php
                                            $prd_cate = $product['MLSP'];
                                            $sql_cate = "SELECT * FROM LoaiSanPham WHERE LoaiSanPham.MLSP = '$prd_cate'";
                                            $rs_cate = mysqli_query($conn, $sql_cate);
                                            while ($categry_prd = mysqli_fetch_array($rs_cate)) { ?>
                                                <option value="<?php echo $categry_prd['MLSP'] ?>"><?php echo $categry_prd['TenLSP'] ?></option>
                                            <?php }; ?>
                                            <?php
                                            $sql1 = "SELECT * FROM LoaiSanPham WHERE NOT LoaiSanPham.MLSP =  '$prd_cate';";
                                            $rs1 = mysqli_query($conn, $sql1);
                                            while ($categry_prd = mysqli_fetch_array($rs1)) { ?>
                                                <option value="<?php echo $categry_prd['MLSP'] ?>"><?php echo $categry_prd['TenLSP'] ?></option>
                                            <?php }; ?>
                                        </select>
                                    </div>
                                    <div class="form-input">
                                        <label class="form_label">Thương hiệu</label>
                                        <select class="form_input" name="product_category" id="category">
                                            <?php
                                            $prd_cate = $product['MSTH'];
                                            $sql_cate = "SELECT * FROM ThuongHieu WHERE ThuongHieu.MSTH = '$prd_cate'";
                                            $rs_cate = mysqli_query($conn, $sql_cate);
                                            while ($categry_prd = mysqli_fetch_array($rs_cate)) { ?>
                                                <option value="<?php echo $categry_prd['MSTH'] ?>"><?php echo $categry_prd['TenTH'] ?></option>
                                            <?php }; ?>
                                            <?php
                                            $sql1 = "SELECT * FROM ThuongHieu WHERE NOT ThuongHieu.MSTH =  '$prd_cate';";
                                            $rs1 = mysqli_query($conn, $sql1);
                                            while ($categry_prd = mysqli_fetch_array($rs1)) { ?>
                                                <option value="<?php echo $categry_prd['MSTH'] ?>"><?php echo $categry_prd['TenTH'] ?></option>
                                            <?php }; ?>
                                        </select>
                                    </div>
                                </div>
                            <?php }; ?>
                        </div>
                        <div class="main-table">
                            <table class="main-table_content detail-table">
                                <thead>
                                    <tr>
                                        <th>Tùy chọn</th>
                                        <th>STT</th>
                                        <th>Tên hình</th>
                                        <th>Hình ảnh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $n = 1;
                                    while ($prd_img = mysqli_fetch_array($rs_img)) { ?>
                                        <tr>
                                            <td>
                                            <a href="./process.php?action=delete-prd-img&prd-id=<?php echo $product_id?>&id=<?php echo $prd_img['MaHinh']; ?>" class="button-edit btn-delete">Xóa</a>
                                            </td>
                                            <td><?php echo $n; ?></td>
                                            <td><?php echo $prd_img['TenHinh'] ?></td>
                                            <td class="prd_td-img">
                                                <div class="prd-img">
                                                    <img class="prd_img" src="../img_upload/<?php echo $prd_img['TenHinh'] ?>" alt="">
                                                </div>
                                            </td>
                                        </tr>
                                    <?php $n++;} ?>
                                </tbody>
                            </table>
                        </div>
                        <input type="submit" class="button form-success_btn" name="submit" value="Cập nhật">
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- <script type="text/javascript" src="./asset/bootstrap/js/bootstrap.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>