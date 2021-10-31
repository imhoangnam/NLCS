<?php
include("connection.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="./asset/base.css">
    <link rel="stylesheet" type="text/css" href="./asset/main1.css">
    <link rel="stylesheet" href="./asset/fonts/fontawesome-free-5.15.4/css/all.min.css">
</head>

<body>
    <div class="main">
        <div class="grid_full-width wrapper">
            <!-- =========== Sidebar =========== -->
            <?php
            include("sidebar.php");
            ?>

            <!-- =========== Container =========== -->
            <div class="container">
                <div class="container-title">
                    <h2>Thêm khách hàng</h2>
                </div>

                <div class="main_insert-content">
                    <!-- <form action="customer_ins-processing.php" class="customer_insert-form" method="POST" role="form"> -->
                    <form id="form-ins-customer" class="customer_insert-form" method="POST" role="form">
                        <div class="main_form">
                            <div class="main-form_left">
                                <div class="form-input">
                                    <label class="form_label">Họ và tên khách hàng(*):</label>
                                    <input id="customer_name" type="text" class="form_input" name="customer_name">
                                    <span id="error-customer_name" class="error-message"></span>
                                </div>
                                <div class="form-input">
                                    <label class="form_label">Địa chỉ(*):</label>
                                    <input id="customer_address" type="text" class="form_input" name="customer_address">
                                    <span id="error-customer_address" class="error-message"></span>
                                </div>
                                <div class="form-input">
                                    <label class="form_label">Số điện thoại(*):</label>
                                    <input id="customer_phone" type="text" class="form_input" name="customer_phone">
                                    <span id="error-customer_phone" class="error-message"></span>
                                </div>
                                <div class="form-input">
                                    <label class="form_label">Email:</label>
                                    <input id="customer_email" type="text" class="form_input" name="customer_email">
                                    <span id="error-customer_email" class="error-message"></span>
                                </div>
                            </div>
                            <div class="main-form_right">
                                <div class="form-input">
                                    <label class="form_label">Giới tính:</label>
                                    <input id="customer_sex" type="text" class="form_input" name="customer_sex">
                                </div>
                                <div class="form-input">
                                    <label class="form_label">Mật khẩu(*):</label>
                                    <input id="customer_password" type="password" class="form_input" name="customer_password">
                                    <span id="error-customer_password" class="error-message"></span>
                                </div>
                                <div class="form-input">
                                    <label class="form_label">Nhập lại mật khẩu(*):</label>
                                    <input id="customer_repassword" type="password" class="form_input" name="customer_repassword">
                                    <span id="error-customer_repassword" class="error-message"></span>
                                </div>
                            </div>
                        </div>
                        <button id="submit" type="submit" class="button form-success_btn" name="submit" onclick="return validateCustomer();">Thêm khách hàng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- =============== SCRIPT =============== -->
    <script src="./asset/jquery/jquery.js"></script>
    <script src="./asset/jquery/main.js"></script>
    <script>
        function showErr(key, message) {
            document.getElementById("error-" + key).innerHTML = message;
        }
        // Validate Form
        function validateCustomer() {
            var name = getElement("customer_name");
            var address =  getElement("customer_address");
            var phone =  getElement("customer_phone");
            var email =  getElement("customer_email");
            var password =  getElement("customer_password");
            var repassword =  getElement("customer_repassword");
            alert(name);
            alert(address);
            alert(phone);
            alert(email);
            alert(password);
            alert(repassword);

            var flag = true;

            if (name != "") {
                if (!/[a-zA-Z0-9]/.test(name)) {
                    flag = false;
                    message = "Vui lòng nhập vào họ tên";
                    showErr("customer_name", message);
                } else {
                    showErr("customer_name", "");
                }
            } else {
                flag = false;
                message = "Vui lòng nhập vào họ tên";
                showErr("customer_name", message);
            }

            if (address == "") {
                flag = false;
                message = "Vui lòng nhập vào địa chỉ";
                showErr("customer_address", message);
            } else {
                showErr("customer_address", "");
            }

            if (phone != "") {
                if (!/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im.test(phone)) {
                    flag = false;
                    message = "Vui lòng kiểm tra lại số điện thoại";
                    showErr("customer_phone", message);
                } else {
                    showErr("customer_phone", "");
                }
            } else {
                flag = false;
                message = "Vui lòng nhập vào số điện thoại";
                showErr("customer_phone", message);
            }

            if (email != "") {
                if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
                    flag = false;
                    message = "Vui lòng kiểm tra email"
                    showErr("customer_email", message);
                } else {
                    showErr("customer_email", "");
                }
            } else {
                flag = false;
                message = "Vui lòng nhập vào địa chỉ"
                showErr("customer_email", message);
            }

            if (password == "") {
                flag = false;
                message = "Vui lòng nhập vào mật khẩu";
                showErr("customer_password", message);
            } else {
                showErr("customer_password", "");
            }
            if (repassword != "") {
                if (repassword != password) {
                    flag = false;
                    message = "Vui lòng kiểm tra lại Mật khẩu nhập lại";
                    showErr("customer_repassword", message);
                } else {
                    showErr("customer_repassword", "");
                }
            } else {
                flag = false;
                message = "Trường này không được để trống";
                showErr("customer_repassword", message);
            }
            return flag;
        }

        // Ajax
        // Insert Customer
        $("#form-ins-customer").submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "./process.php?ins-customer",
                data: $(this).serializeArray(),
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == "0") {
                        alert(response.message);
                        console.log(response.message);
                    } else {
                        alert(response.message);
                        location.reload();
                    }
                }
            });
        });
    </script>

</body>

</html>