<?php
include("./connection.php");
session_start();

if (isset($_GET['order-prd'])) {
    if (isset($_POST['prd_quantity']) && isset($_GET['id'])) {
        $prd_quantity = $_POST['prd_quantity'];
        $prd_id = $_GET['id'];
        $err = false;
        $sql = "SELECT * FROM SanPham WHERE SanPham.MSSP = '$prd_id'";
        $rs = mysqli_query($conn, $sql);
        if($rs){
            echo json_encode(array(
                'status' => 1,
                'message' => 'OKE'
            ));
            exit;
        }
        else{
            echo json_encode(array(
                'status' => 0,
                'message' => 'Fail'
            ));
            exit;
        }
    }
}
/*===================================*/
