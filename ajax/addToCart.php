<?php
require('../config.php');

$data = array();

// session_start();
//print_r($_POST);exit();

$productId = (isset($_POST['productId'])) ? $_POST['productId'] : NULL;
$quantity = (isset($_POST['quantity'])) ? $_POST['quantity'] : 0;
$divId = (isset($_POST['divId'])) ? $_POST['divId'] : NULL;
$currentPage = (isset($_POST['currentPage'])) ? $_POST['currentPage'] : NULL;

// if(!is_int($quantity)){
//     $quantity=1;
// }

if ($_POST['action'] == 'add') {
    if (isset($_POST['productSize'])) {
        if (($_POST['productSize'] != 0)) {
            if (isset($_POST['colorId'])) {
                $color = $_POST['colorId'];
            } else {
                $color = '';
            }

            if (isset($_SESSION['loginid'])) {

                $tableName = "add_cart";
                $cart->count($tableName, "pid='" . $productId . "'");

                $qty = mysqli_fetch_assoc(mysqli_query($con, "SELECT minimum FROM products WHERE id = '$productId'"))['minimum'];

                $recordArr = array(
                    "user_id" => $_SESSION['loginid'],
                    "quantity" => ($quantity == 0) ? $qty : $quantity,
                    "pid" => $productId,
                    "color_id" => $color
                );

                $data['result'] = ($cart->save($tableName, $recordArr)) ? true : false;
            } else {
                if (isset($_SESSION['products'])) {
                    if (in_array($productId, $_SESSION["products"]['id'])) {
                        $key = array_search($productId, $_SESSION['products']['id']);
                        // $_SESSION["products"]['id'][] = $productId;  
                        $_SESSION["products"]['qty'][$key] = $quantity;   ///// If Product ID already Present In array
                    } else {
                        $quantity = mysqli_fetch_assoc(mysqli_query($con, "SELECT minimum FROM products WHERE id = '$productId'"))['minimum'];

                        $_SESSION["products"]['id'][] = $productId;
                        $_SESSION["products"]['qty'][] = $quantity;
                        $_SESSION["products"]['colorId'][] = $color;
                    }
                } else {
                    $quantity = mysqli_fetch_assoc(mysqli_query($con, "SELECT minimum FROM products WHERE id = '$productId'"))['minimum'];

                    $_SESSION["products"]['id'][] = $productId;
                    $_SESSION["products"]['qty'][] = $quantity;
                    $_SESSION["products"]['colorId'][] = $color;
                }

                // session_unset();



            }
            $data['currentPage']  = $currentPage;
            $data['divId'] = $divId;
            $data['productTotal'] = $cart->productTotalAmount($productId, $quantity);
        }  ////END if Action
    } else {
        if (isset($_SESSION['loginid'])) {

            $tableName = "add_cart";
            $cart->count($tableName, "pid='" . $productId . "'");
            $qty = mysqli_fetch_assoc(mysqli_query($con, "SELECT minimum FROM products WHERE id = '$productId'"))['minimum'];
            $recordArr = array(
                "user_id" => $_SESSION['loginid'],
                "quantity" => ($quantity == 0) ? $qty : $quantity,
                "pid" => $productId,
            );

            $data['result'] = ($cart->save($tableName, $recordArr)) ? true : false;
        } else {
            if (isset($_SESSION['products'])) {
                if (in_array($productId, $_SESSION["products"]['id'])) {

                    $key = array_search($productId, $_SESSION['products']['id']);
                    // $_SESSION["products"]['id'][] = $productId;  
                    $_SESSION["products"]['qty'][$key] = $quantity;   ///// If Product ID already Present In array
                } else {
                    $quantity = mysqli_fetch_assoc(mysqli_query($con, "SELECT minimum FROM products WHERE id = '$productId'"))['minimum'];

                    $_SESSION["products"]['id'][] = $productId;
                    $_SESSION["products"]['qty'][] = $quantity;
                }
            } else {
                $quantity = mysqli_fetch_assoc(mysqli_query($con, "SELECT minimum FROM products WHERE id = '$productId'"))['minimum'];

                $_SESSION["products"]['id'][] = $productId;
                $_SESSION["products"]['qty'][] = $quantity;
            }

            // session_unset();



        }
        $data['currentPage']  = $currentPage;
        $data['divId'] = $divId;
        $data['productTotal'] = $cart->productTotalAmount($productId, $quantity);
    }
}



//////// Remove Item From Cart ////////
if ($_POST['action'] == 'remove') {
    $data['result'] = ($cart->removeItemFromCart($productId)) ? "Removed" : "Error Occur";
    $data['productButtonId'] = '#addCart' . $productId;
}
//////// Remove Item From Cart ////////



$data['productId'] = $productId;
if ($productId) {
    $data['cartSubTotalAmount'] = $cart->cartSubTotalAmount();
    $data['cartTotalAmount'] = $cart->cartTotalAmount();
    $data['totalItemInCart'] = $cart->totalItemInCart();
    $data['productCode'] = $cart->productCodeByProductId($productId);
}

// $data['miniMainCartSection'] = $miniMainCartSection;
//////// Record Info Update On UI ////////
// print_r($data);
echo json_encode($data);
