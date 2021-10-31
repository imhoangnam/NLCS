<?php
include("./connection.php");
session_start();



/*===================================*/

// User Register
if (isset($_GET['register']) && isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['password']) && isset($_POST['repassword'])) {
    $customer_id = rand(0,9999).rand(0,9999);
    $customer_name = $_POST['name'];
    $customer_phone = $_POST['phone'];
    $customer_address = $_POST['address'];
    $customer_password = $_POST['password'];
    $customer_repassword = $_POST['repassword'];
    if ($customer_name != "" && $customer_phone != "" && $customer_password != "" && $customer_repassword != "") {
        if ($customer_password == $customer_repassword) {
            $sql = "SELECT * FROM KhachHang WHERE KhachHang.SoDienThoai = '$customer_phone'";
            $rs = mysqli_query($conn, $sql);
            if (mysqli_num_rows($rs) > 0) {
                echo json_encode(array(
                    'status' => 0,
                    'message' => 'Số điện thoại đã được đăng ký'
                ));
                exit;
            } else {
                $sql_insert = "INSERT INTO `khachhang` (`MSKH`, `HoTenKH`, `DiaChi`, `SoDienThoai`,`GioiTinh`,`Email`,`MatKhau`,`TrangThai`) VALUES ('$customer_id', '$customer_name', '$customer_address', '$customer_phone', NULL, NULL,'$customer_password','1');";
                $rs_sqlinsert = mysqli_query($conn, $sql_insert);
                if ($rs_sqlinsert == true) {
                    echo json_encode(array(
                        'status' => 1,
                        'message' => 'Đăng ký tài khoản thành công'
                    ));
                    
                    $sql_login = "SELECT * FROM KhachHang WHERE KhachHang.SoDienThoai = '$customer_phone' AND KhachHang.MatKhau = '$customer_password'";
                    $rs_login = mysqli_query($conn, $sql_login);
                    $data_user = mysqli_fetch_assoc($rs_login);
                    $_SESSION['user'] = $data_user;
                    
                    exit;
                } else {
                    echo json_encode(array(
                        'status' => 0,
                        'message' => 'Đăng ký không thành công'
                    ));
                    exit;
                }
            }
        } else {
            echo json_encode(array(
                'status' => 0,
                'message' => 'Mật khẩu nhập lại không chính xác'
            ));
            exit;
        }
    } else {
        echo json_encode(array(
            'status' => 0,
            'message' => 'Thông tin đăng ký không hợp lệ'
        ));
        exit;
    }
}


// User Login
if (isset($_GET['login'])) {
    if (isset($_POST['phone']) && isset($_POST['password'])) {
        $customer_phone = $_POST['phone'];
        $customer_password = $_POST['password'];
        $err = false;

        if ($customer_phone != "" && $customer_password != "") {
            $sql = "SELECT * FROM KhachHang WHERE KhachHang.SoDienThoai = '$customer_phone' 
            AND KhachHang.MatKhau = '$customer_password'";
            $rs = mysqli_query($conn, $sql);
            if (!$rs) {
                $err = mysqli_error($conn);
            }
            else{
                $data_user = mysqli_fetch_assoc($rs);
                $_SESSION['user'] = $data_user;
            }
    
            if($err != false || mysqli_num_rows($rs) == 0){
                echo json_encode(array(
                    'status' => 0,
                    'message' => 'Thông tin đăng nhập không đúng'
                ));
                exit;
            }else{
                echo json_encode(array(
                    'status' => 1,
                    'message' => 'Đăng nhập thành công'
                ));
                exit;
            }
        }else{
            echo json_encode(array(
                'status' => 0,
                'message' => 'Thông tin đăng nhập không đúng'
            ));
            exit;
        }
    }
}


// User Logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    foreach ($_SESSION['cart'] as $value) {
        $item_id = $value['id'];
        $item_qty = $value['quantity'];

        $sql_prd = "SELECT * FROM SanPham WHERE SanPham.MSSP = '$item_id'";
        $rs_prd = mysqli_query($conn, $sql_prd);
        $data = mysqli_fetch_assoc($rs_prd);
        if ($data) {
            $prd_qty =  $data['SoLuongHang'];
            // echo $prd_qty; exit;

            $update_prd = "UPDATE sanpham  SET sanpham.SoLuongHang = '$prd_qty' + '$item_qty' 
            WHERE sanpham.MSSP = '$item_id';";
            $rs_update = mysqli_query($conn, $update_prd);
        }
    }
    unset($_SESSION['cart']);
    unset($_SESSION['user']);
    header('location: ./index.php');
    exit;
}


// User Update
if(isset($_GET['user']) && $_GET['user'] == 'update'){
    $customer_id = $_GET['id'];
    $new_phone = $_POST['customer-phone'];
    $new_pass = $_POST['customer-newpass'];
    $new_username = $_POST['customer-name'];
    $new_birthday = $_POST['customer-birthday'];
    $new_sex = $_POST['customer-sex'];
    $new_address = $_POST['customer-address'];
    if($new_pass != ""){
        $customer_pass = $_POST['customer-newpass'];
    }else{
        $customer_pass = $_POST['customer-password'];
    }

    $sql = "UPDATE KhachHang SET HoTenKH = '$new_username', DiaChi = '$new_address', SoDienThoai = '$new_phone', MatKhau = '$customer_pass' WHERE KhachHang.MSKH = '$customer_id'";
    $rs = mysqli_query($conn, $sql);
    if($rs){
        header("location: ./customer.php?update=success");
        exit;
    }
    else{
        header("location: ./customer.php?update=fail");
        exit;
    }
}


/*===================================*/



/*===================================*/

// Add to Cart
if (isset($_GET['order-prd']) && isset($_GET['id'])) {
    if (isset($_POST['prd_quantity'])) {
        $prd_quantity = $_POST['prd_quantity'];
        $prd_id = $_GET['id'];
        $err = false;
        $sql = "SELECT * FROM SanPham WHERE SanPham.MSSP = '$prd_id'";
        $rs = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($rs);

        // Check quantity 
        if ($data && ($prd_quantity <= $data['SoLuongHang'])) {
            $old_qty = $data['SoLuongHang'];

            $update_prd = "UPDATE sanpham  SET sanpham.SoLuongHang = '$old_qty' - '$prd_quantity' WHERE sanpham.MSSP = '$prd_id';";
            $rs_update = mysqli_query($conn, $update_prd);

            // Check product
            // Nếu có thì tăng số lương của SP trong giỏ hàng
            if ($rs_update && isset($_SESSION['cart'][$prd_id])) {
                $_SESSION['cart'][$prd_id]['quantity'] += $prd_quantity;
                echo json_encode(array(
                    'status' => 1,
                    'message' => 'Thêm vào giỏ hàng thành công'
                ));
                exit;
            } else {
                $item = [
                    'id' => $data['MSSP'],
                    'name' => $data['TenSP'],
                    'image' => $data['Avatar'],
                    'price' => $data['GiaBan'] > 0 ? $data['GiaBan'] : $data['Gia'],
                    'quantity' => $prd_quantity,

                ];
                $_SESSION['cart'][$prd_id] = $item;
                // echo"<pre>";
                // print_r($_SESSION['cart']);
                // exit;
                echo json_encode(array(
                    'status' => 1,
                    'message' => 'Thêm vào giỏ hàng thành công'
                ));
                exit;
            }
        } else {
            // echo $prd_id; exit;
            echo json_encode(array(
                'status' => 0,
                'message' => 'Số lương mua không hợp lệ'
            ));
            exit;
        }
    }
}
// Cập nhât số lượng của SP trong giỏ hàng
if (isset($_GET['update-cart'])) {
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $value) {
            $prd_id = $_SESSION['cart'][$value['id']]['id'];
            $sql_prd = "SELECT * FROM SanPham WHERE SanPham.MSSP = '$prd_id'";
            $rs_prd = mysqli_query($conn, $sql_prd);

            while ($prd_qty = mysqli_fetch_assoc($rs_prd)) {
                $prd_qtyold = $prd_qty['SoLuongHang'];
                $old_qty = $_SESSION['cart'][$value['id']]['quantity'];
                $new_qty = $_POST['qty' . $value['id']];
                $prd_quantity = $prd_qtyold - ($new_qty - $old_qty);
                // echo $prd_quantity;exit;
                $_SESSION['cart'][$value['id']]['quantity'] = $new_qty;
                $update_prd = "UPDATE SanPham  SET SanPham.SoLuongHang = '$prd_quantity' WHERE SanPham.MSSP = $prd_id";
                $rs_update = mysqli_query($conn, $update_prd);
            }
        }
        if ($rs_update) {
            echo json_encode(array(
                'status' => 1,
                'message' => 'Cập nhật giỏ hàng thành công'
            ));
            exit;
        } else {
            echo json_encode(array(
                'status' => 0,
                'message' => 'Cập nhật giỏ hàng không thành công'
            ));
            exit;
        }
    }
}

// Xóa SP được chọn trong giỏ hàng
if (isset($_GET['action']) && $_GET['action'] == 'delete-cart') {
    $prd_id = $_GET['id'];
    $sql = "SELECT * FROM SanPham WHERE SanPham.MSSP = '$prd_id'";
    $rs = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($rs);
    $old_qty =  $data['SoLuongHang'];

    if (isset($_SESSION['cart'][$prd_id])) {
        $item_qty =  $_SESSION['cart'][$prd_id]['quantity'];

        $update_prd = "UPDATE sanpham  SET sanpham.SoLuongHang = '$old_qty' + '$item_qty' 
        WHERE sanpham.MSSP = '$prd_id';";
        $rs_update = mysqli_query($conn, $update_prd);
        if ($rs_update) {
            unset($_SESSION['cart'][$prd_id]);
            header("location: ./cart.php?notify=success");
            exit;
        }
    } else {
        header("location: ./cart.php");
        exit;
    }
}

// Xóa tất cả sản phẩm trong giỏ hàng
if (isset($_GET['action']) && $_GET['action'] == 'delall-cart') {
    // echo $order_id; exit;
    foreach ($_SESSION['cart'] as $value) {
        $item_id = $value['id'];
        $item_qty = $value['quantity'];

        $sql_prd = "SELECT * FROM SanPham WHERE SanPham.MSSP = '$item_id'";
        $rs_prd = mysqli_query($conn, $sql_prd);
        $data = mysqli_fetch_assoc($rs_prd);
        if ($data) {
            $prd_qty =  $data['SoLuongHang'];
            // echo $prd_qty; exit;

            $update_prd = "UPDATE sanpham  SET sanpham.SoLuongHang = '$prd_qty' + '$item_qty' 
            WHERE sanpham.MSSP = '$item_id';";
            $rs_update = mysqli_query($conn, $update_prd);
        }
    }
    if ($rs_update) {
        unset($_SESSION['cart']);
        header("location: ./cart.php?notify=success");
        exit;
    }
}
// echo'<pre>';
// print_r($_SESSION['cart']); exit;


/*===================================*/
// Đặt hàng
if (isset($_GET['order'])) {
    if (isset($_SESSION['cart']) && isset($_SESSION['user'])) {

        // $order_id = rand(0, 9999) . rand(0, 9999);
        $customer_id = $_SESSION['user']['MSKH'];
        $day_order = date("Y-m-d");
        $order_address = $_POST['customer_address'];
        $order_note = $_POST['customer_note'];


        $sql_order = "INSERT INTO `dathang` (`SoDonDH`, `MSKH`, `MSNV`, `NgayDH`, `NgayGH`, `DiaChiGH`, `GhiChu`, `TrangThaiDH`) VALUES (NULL, '$customer_id', NULL, '$day_order', NULL, '$order_address', '$order_note', '0');";
        $rs_order = mysqli_query($conn, $sql_order);
        if ($rs_order) {
            // echo'<pre>';
            // print_r($day_order); 
            // exit;
            $last_id = mysqli_insert_id();
            foreach ($_SESSION['cart'] as $value) {
                $prd_id = $_SESSION['cart'][$value['id']]['id'];
                $prd_qty = $_SESSION['cart'][$value['id']]['quantity'];
                $prd_price = $_SESSION['cart'][$value['id']]['price'];
                $prd_sale = $_POST['prd_sale'];

                $sql_detail = "INSERT INTO `chitietdathang` (`SoDonDH`, `MSSP`, `SoLuong`, `GiaDatHang`, `GiamGia`) VALUES ('$order_id', '$prd_id', '$prd_qty', '$prd_price', NULL); ";
                $rs_detail = mysqli_query($conn, $sql_detail);

            }
            if ($rs_detail) {
                unset($_SESSION['cart']);
                echo json_encode(array(
                    'status' => 1,
                    'message' => 'Mua hàng thành công'
                ));
                exit;
            } else {
                echo json_encode(array(
                    'status' => 0,
                    'message' => 'Mua hàng không thành công'
                ));
                exit;
            }
        }
    }
}

// Hủy đặt hàng
if (isset($_GET['order']) && $_GET['order'] == 'cancel') {
    $order_id = $_GET['id'];
    $sql_detail = "SELECT * FROM ChiTietDatHang WHERE ChiTietDatHang.SoDonDH = '$order_id'";
    $rs_detail = mysqli_query($conn, $sql_detail);
    // echo $order_id; exit;
    while ($item_detail = mysqli_fetch_array($rs_detail)) {
        $prd_id = $item_detail['MSSP'];
        $sql_prd = "SELECT * FROM SanPham WHERE SanPham.MSSP = '$prd_id'";
        $rs_prd = mysqli_query($conn, $sql_prd);

        while ($prd_qty = mysqli_fetch_array($rs_prd)) {
            $prd_qtyold = $prd_qty['SoLuongHang'];
            $old_qty = $item_detail['SoLuong'];
            $prd_quantity = $prd_qtyold + $old_qty;
            // echo $prd_quantity;
            // exit;
            $update_prd = "UPDATE SanPham  SET SanPham.SoLuongHang = '$prd_quantity' WHERE SanPham.MSSP = $prd_id";
            $rs_update = mysqli_query($conn, $update_prd);
        }
    }
    if ($rs_update) {
        $del_detail = "DELETE FROM ChiTietDatHang WHERE ChiTietDatHang.SoDonDH = $order_id";
        $rs_deldetail = mysqli_query($conn, $del_detail);
        $del_order = "DELETE FROM DatHang WHERE DatHang.SoDonDH = $order_id";
        $rs_delorder = mysqli_query($conn, $del_order);
    }
    if ($rs_deldetail && $rs_delorder) {
        header("location: ./order.php?notify=success");
        exit;
    } else {
        header("location: ./order.php?notify=error");
        exit;
    }
}


/*===================================*/
