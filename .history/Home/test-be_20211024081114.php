<?php
include("./connection.php");
session_start();

if (isset($_GET['order-prd'])) {
    if (isset($_POST['prd_quantity']) && isset($_GET['id'])) {
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
/*===================================*/
