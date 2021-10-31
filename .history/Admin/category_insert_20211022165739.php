<?php
include("./connection.php");
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
                    <h2>Thêm loại sản phẩm</h2>
                </div>

                <div class="main_insert-content">
                    <form action="process.php?action=add-category" class="category_insert-form" method="POST" role="form">
                        <div class="main_form-s">
                            <div class="form-input">
                                <label class="form_label" for="fname">Tên loại sản phẩm(*):</label>
                                <input type="text" class="form_input" id="fname" name="category_name">
                            </div>
                        </div>
                        <input type="submit" class="button form-success_btn" name="submit" value="Thêm loại sản phẩm">
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- <script type="text/javascript" src="./asset/bootstrap/js/bootstrap.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>