<?php

require('../config.php');
$checkout = new Checkout($con);

$data = array();
$errMessage = array();

// }

// exit();
if(isset($_SESSION['loginid'])){
    $loginId = $_SESSION['loginid'];
}
else{
    $loginId = rand(111111111, 999999999 );
}
date_default_timezone_set('Asia/Kolkata');
$date = date("Y-m-d");
$time = date('H:i:s');
$timeStamp = date("Y-m-d H:i:s");

$orderPlaced = false;
$checkOutStatus = false;
$placeOrder = false;


if (isset($_POST['paymentmethod'])) {
    ////////// New Billing Address Form //////////
    if (isset($_POST['newBillingAddress'])) {
        if (!isset($_POST['newBillingAddressType'])) {
            $errMessage['newBillingAddressType'] = 'Please Select address Type';
        } else {
            $billingAddressType =  $_POST['newBillingAddressType'];
        }

        if (($_POST['newBillingAddressFirstName'] == "") || ($_POST['newBillingAddressFirstName'] == null)) {
            $errMessage['newBillingAddressFirstName'] = 'Field Required';
        } else {
            $billingAddressFirstName =  $_POST['newBillingAddressFirstName'];
        }

        if (($_POST['newBillingAddressLastName'] == "") || ($_POST['newBillingAddressLastName'] == null)) {
            $errMessage['newBillingAddressLastName'] = 'Field Required';
        } else {
            $billingAddressLastName =  $_POST['newBillingAddressLastName'];
        }

        if (($_POST['newBillingAddressCountry'] == "") || ($_POST['newBillingAddressCountry'] == null)) {
            $errMessage['newBillingAddressCountry'] = 'Field Required';
        } else {
            $billingAddressCountry =  $_POST['newBillingAddressCountry'];
        }

        if (($_POST['newBillingAddressFlat'] == "") || ($_POST['newBillingAddressFlat'] == null)) {
            $errMessage['newBillingAddressFlat'] = 'Field Required';
        } else {
            $billingAddressFlat =  $_POST['newBillingAddressFlat'];
        }

        if (($_POST['newBillingAddressStreet'] == "") || ($_POST['newBillingAddressStreet'] == null)) {
            $errMessage['newBillingAddressStreet'] = 'Field Required';
        } else {
            $billingAddressStreet =  $_POST['newBillingAddressStreet'];
        }

        $billingAddressLocality =  $_POST['newBillingAddressLocality'];

        if (($_POST['newBillingAddressCity'] == "") || ($_POST['newBillingAddressCity'] == null)) {
            $errMessage['newBillingAddressCity'] = 'Field Required';
        } else {
            $billingAddressCity =  $_POST['newBillingAddressCity'];
        }

        if (($_POST['newBillingAddressZipCode'] == "") || ($_POST['newBillingAddressZipCode'] == null)) {
            $errMessage['newBillingAddressZipCode'] = 'Field Required';
        } else {
            $billingAddressZipCode =  $_POST['newBillingAddressZipCode'];
        }

        if (($_POST['newBillingAddressState'] == "") || ($_POST['newBillingAddressState'] == null)) {
            $errMessage['newBillingAddressState'] = 'Field Required';
        } else {
            $billingAddressState =  $_POST['newBillingAddressState'];
        }

        if (($_POST['newBillingAddressPhone'] == "") || ($_POST['newBillingAddressPhone'] == null)) {
            $errMessage['newBillingAddressPhone'] = 'Field Required';
        } else {
            $billingAddressPhone =  $_POST['newBillingAddressPhone'];
        }

        if (($_POST['newBillingAddressEmail'] == "") || ($_POST['newBillingAddressEmail'] == null)) {
            $errMessage['newBillingAddressEmail'] = 'Field Required';
        } else {
            $billingAddressEmail =  $_POST['newBillingAddressEmail'];
        }

        if (empty($errMessage)) {
            $tempArr = array(
              "user_id" => $loginId,
              "first_name" => $billingAddressFirstName,
              "last_name" => $billingAddressLastName,
              "flat" => $billingAddressFlat,
              "street" => $billingAddressStreet,
              "locality" => $billingAddressLocality,
              "city" => $billingAddressCity,
              "zip_code" => $billingAddressZipCode,
              "state" => $billingAddressState,
              "country" => $billingAddressCountry,
              "email" => $billingAddressEmail,
              "phone" => $billingAddressPhone,
              "addr_type" => $billingAddressType
            );


            $checkout->save('user_shipping_addresses', $tempArr); ///// Insert shiping_address table Data
        }


        if ((isset($_POST['newDifferentShippingAddress'])) && ($_POST['newDifferentShippingAddress'] == 'newDifferentShippingAddress')) {
            ////////// New Different Shipping Address Form //////////
            if (!isset($_POST['newDifferentShippingType'])) {
                $errMessage['newDifferentShippingType'] = 'Please Select address Type';
            } else {
                $shippingType =  $_POST['newDifferentShippingType'];
            }

            if (($_POST['newDifferentShippingFirstName'] == "") || ($_POST['newDifferentShippingFirstName'] == null)) {
                $errMessage['newDifferentShippingFirstName'] = 'Field Required';
            } else {
                $shippingFirstName =  $_POST['newDifferentShippingFirstName'];
            }

            if (($_POST['newDifferentShippingLastName'] == "") || ($_POST['newDifferentShippingLastName'] == null)) {
                $errMessage['newDifferentShippingLastName'] = 'Field Required';
            } else {
                $shippingLastName =  $_POST['newDifferentShippingLastName'];
            }

            if (($_POST['newDifferentShippingCountry'] == "") || ($_POST['newDifferentShippingCountry'] == null)) {
                $errMessage['newDifferentShippingCountry'] = 'Field Required';
            } else {
                $shippingCountry =  $_POST['newDifferentShippingCountry'];
            }

            if (($_POST['newDifferentShippingFlat'] == "") || ($_POST['newDifferentShippingFlat'] == null)) {
                $errMessage['newDifferentShippingFlat'] = 'Field Required';
            } else {
                $shippingFlat =  $_POST['newDifferentShippingFlat'];
            }

            if (($_POST['newDifferentShippingStreet'] == "") || ($_POST['newDifferentShippingStreet'] == null)) {
                $errMessage['newDifferentShippingStreet'] = 'Field Required';
            } else {
                $shippingStreet =  $_POST['newDifferentShippingStreet'];
            }

            $shippingLocality =  $_POST['newDifferentShippingLocality'];

            if (($_POST['newDifferentShippingCity'] == "") || ($_POST['newDifferentShippingCity'] == null)) {
                $errMessage['newDifferentShippingCity'] = 'Field Required';
            } else {
                $shippingCity =  $_POST['newDifferentShippingCity'];
            }

            if (($_POST['newDifferentShippingZipCode'] == "") || ($_POST['newDifferentShippingZipCode'] == null)) {
                $errMessage['newDifferentShippingZipCode'] = 'Field Required';
            } else {
                $shippingZipCode =  $_POST['newDifferentShippingZipCode'];
            }

            if (($_POST['newDifferentShippingState'] == "") || ($_POST['newDifferentShippingState'] == null)) {
                $errMessage['newDifferentShippingState'] = 'Field Required';
            } else {
                $shippingState =  $_POST['newDifferentShippingState'];
            }

            if (($_POST['newDifferentShippingPhone'] == "") || ($_POST['newDifferentShippingPhone'] == null)) {
                $errMessage['newDifferentShippingPhone'] = 'Field Required';
            } else {
                $shippingPhone =  $_POST['newDifferentShippingPhone'];
            }

            if (($_POST['newDifferentShippingEmail'] == "") || ($_POST['newDifferentShippingEmail'] == null)) {
                $errMessage['newDifferentShippingEmail'] = 'Field Required';
            } else {
                $shippingEmail =  $_POST['newDifferentShippingEmail'];
            }
            ////////// New Different Shipping Address Form //////////

            if (empty($errMessage)) {
                $tempArr = array(
                  "user_id" => $loginId,
                  "first_name" => $shippingFirstName,
                  "last_name" => $shippingLastName,
                  "flat" => $shippingFlat,
                  "street" => $shippingStreet,
                  "locality" => $shippingLocality,
                  "country" => $shippingCountry,
                  "city" => $shippingCity,
                  "state" => $shippingState,
                  "zip_code" => $shippingZipCode,
                  "email" => $shippingEmail,
                  "phone" => $shippingPhone,
                  "addr_type" => $shippingType
                );

                $checkout->save('user_shipping_addresses', $tempArr); ///// Insert shiping_address table Data
            }
        } else { ////// else Shiping Address as New Billing Address Start
            $shippingType =  (isset($_POST['newBillingAddressType'])) ? $_POST['newBillingAddressType'] : "";
            $shippingFirstName =  $_POST['newBillingAddressFirstName'];
            $shippingLastName =  $_POST['newBillingAddressLastName'];
            $shippingCountry =  $_POST['newBillingAddressCountry'];
            $shippingFlat =  $_POST['newBillingAddressFlat'];
            $shippingStreet =  $_POST['newBillingAddressStreet'];
            $shippingLocality =  $_POST['newBillingAddressLocality'];
            $shippingCity =  $_POST['newBillingAddressCity'];
            $shippingZipCode =  $_POST['newBillingAddressZipCode'];
            $shippingState =  $_POST['newBillingAddressState'];
            $shippingPhone =  $_POST['newBillingAddressPhone'];
            $shippingEmail =  $_POST['newBillingAddressEmail'];
        } ////// else Shiping Address as New Billing Address END
    } ////// newBillingAddressType if END
    ////////// New Billing Address Form //////////

    if ((isset($_POST['newShippingAddress'])) && ($_POST['newShippingAddress'] == 'newShippingAddress')) {
        ////////// New Different Shipping Address Form //////////
        if (!isset($_POST['newShippingAddressType'])) {
            $errMessage['newShippingAddressType'] = 'Please Select address Type';
        } else {
            $shippingType =  $_POST['newShippingAddressType'];
        }

        if (($_POST['newShippingAddressFirstName'] == "") || ($_POST['newShippingAddressFirstName'] == null)) {
            $errMessage['newShippingAddressFirstName'] = 'Field Required';
        } else {
            $shippingFirstName =  $_POST['newShippingAddressFirstName'];
        }

        if (($_POST['newShippingAddressLastName'] == "") || ($_POST['newShippingAddressLastName'] == null)) {
            $errMessage['newShippingAddressLastName'] = 'Field Required';
        } else {
            $shippingLastName =  $_POST['newShippingAddressLastName'];
        }

        if (!isset($_POST['newShippingAddressCountry']) || !empty($_POST['newShippingAddressCountry'])) {
            $errMessage['newShippingAddressCountry'] = 'Field Required';
        } else {
            $shippingCountry =  $_POST['newShippingAddressCountry'];
        }

        if (($_POST['newShippingAddressFlat'] == "") || ($_POST['newShippingAddressFlat'] == null)) {
            $errMessage['newShippingAddressFlat'] = 'Field Required';
        } else {
            $shippingFlat =  $_POST['newShippingAddressFlat'];
        }

        if (($_POST['newShippingAddressStreet'] == "") || ($_POST['newShippingAddressStreet'] == null)) {
            $errMessage['newShippingAddressStreet'] = 'Field Required';
        } else {
            $shippingStreet =  $_POST['newShippingAddressStreet'];
        }

        $shippingLocality =  $_POST['newShippingAddressLocality'];

        if (($_POST['newShippingAddressCity'] == "") || ($_POST['newShippingAddressCity'] == null)) {
            $errMessage['newShippingAddressCity'] = 'Field Required';
        } else {
            $shippingCity =  $_POST['newShippingAddressCity'];
        }

        if (($_POST['newShippingAddressZipCode'] == "") || ($_POST['newShippingAddressZipCode'] == null)) {
            $errMessage['newShippingAddressZipCode'] = 'Field Required';
        } else {
            $shippingZipCode =  $_POST['newShippingAddressZipCode'];
        }

        if (($_POST['newShippingAddressState'] == "") || ($_POST['newShippingAddressState'] == null)) {
            $errMessage['newShippingAddressState'] = 'Field Required';
        } else {
            $shippingState =  $_POST['newShippingAddressState'];
        }

        if (($_POST['newShippingAddressPhone'] == "") || ($_POST['newShippingAddressPhone'] == null)) {
            $errMessage['newShippingAddressPhone'] = 'Field Required';
        } else {
            $shippingPhone =  $_POST['newShippingAddressPhone'];
        }

        if (($_POST['newShippingAddressEmail'] == "") || ($_POST['newShippingAddressEmail'] == null)) {
            $errMessage['newShippingAddressEmail'] = 'Field Required';
        } else {
            $shippingEmail =  $_POST['newShippingAddressEmail'];
        }
        ////////// New Different Shipping Address Form //////////


        if (empty($errMessage)) {
            $tempArr = array(
              "user_id" => $loginId,
              "first_name" => $shippingFirstName,
              "last_name" => $shippingLastName,
              "flat" => $shippingFlat,
              "street" => $shippingStreet,
              "locality" => $shippingLocality,
              "country" => $shippingCountry,
              "city" => $shippingCity,
              "state" => $shippingState,
              "zip_code" => $shippingZipCode,
              "email" => $shippingEmail,
              "phone" => $shippingPhone,
              "addr_type" => $shippingType
            );


            $cart->count('user_shipping_addresses', "
  
  first_name='" . $shippingFirstName . "' AND  
  last_name='" . $shippingLastName . "' AND  
  flat='" . $shippingFlat . "' AND 
  street='" . $shippingStreet . "' AND 
  locality='" . $shippingLocality . "' AND 
  country='" . $shippingCountry . "' AND 
  city='" . $shippingCity . "' AND 
  state='" . $shippingState . "' AND 
  zip_code='" . $shippingZipCode . "' AND 
  email='" . $shippingEmail . "' AND 
  phone='" . $shippingPhone . "' AND 
  addr_type='" . $shippingType . "'
  
  ");
            $checkout->save('user_shipping_addresses', $tempArr); ///// Insert shiping_address table Data
        }
    } else {
        if (isset($_POST['selectShippingAddress'])) {
            if (isset($_POST['shippingAddress'])) {
                $shippingAddress = $checkout->shippingAddressById($_POST['shippingAddress']);

                $shippingType =  $shippingAddress['addr_type'];
                $shippingFirstName =  $shippingAddress['first_name'];
                $shippingLastName =  $shippingAddress['last_name'];
                $shippingCountry =  $shippingAddress['country'];
                $shippingFlat =  $shippingAddress['flat'];
                $shippingStreet =  $shippingAddress['street'];
                $shippingLocality =  $shippingAddress['locality'];
                $shippingCity =  $shippingAddress['city'];
                $shippingZipCode =  $shippingAddress['state'];
                $shippingState =  $shippingAddress['zip_code'];
                $shippingPhone =  $shippingAddress['phone'];
                $shippingEmail =  $shippingAddress['email'];
            } else {
                $errMessage['selectShippingAddress'] = 'Please Select Shipping Address';
            }
        }
    }

    $orderId = $checkout->generateOrderId();

    // print_r($errMessage);
    // exit();
    if (empty($errMessage)) {
        ///////// Apply Coupon code conditions /////////
        if ((isset($_POST['coupanCode'])) && ($_POST['coupanCode'] != '')) {
            $coupanCode = $_POST['coupanCode'];
            $checkout->setCoupan($_POST['coupanCode']);
            $coupanData = $checkout->coupan();

            if ($coupanData['status'] == 'success') {
                $orderPrice = $coupanData['totalPrice'];
                $orderPrice = round($orderPrice);

                $orderCouponTempArr = array(
                  "order_id" => $orderId,
                  "user_id" => $loginId,
                  "coupon_code" => $coupanCode,
                  "totalprice" => $orderPrice,
                  "discount_price" => $coupanData['savePrice'],
                  "date" => $date,
                  "time" => $time,
                  "datetime" => $timeStamp
                );

                $checkout->forcedInsert('order_coupon_code', $orderCouponTempArr); ///// Insert order_coupon_code table Data
            } else {
                $coupanCode = "";
                $orderPrice = $checkout->cartTotalAmount();
                $orderPrice = round($orderPrice);
            }
        } else {
            $coupanCode = "";
            $orderPrice = $checkout->cartTotalAmount();
            $orderPrice = round($orderPrice);
        }

        if ($orderPrice == 0) {    //////// If Order Price = 0;
            die("Order Price is 0");
        }


        if ($_POST['paymentmethod'] == 'cashondelivery') {
            if ($cart->codStatus() == null) {
                $placeOrder = true;
                $paymentType = 'Cash On Delivery';
                $paymentMode = 'COD';
                $data['status'] = 'cod';
                $paymentStatus = 'Pending';
            } else {
                $placeOrder = false;
                $data['status'] = 'failed';
                $data['result'] = 'This order cannot be placed with COD Payment because some of your products are not avialable for COD.';
            }
        } ///// COD if END


        if ($_POST['paymentMethod'] == 'CCGateway') {
            $paramList = array();

            $ORDER_ID = $checkout->encrypt_decrypt($orderId);
            $CUST_ID = $checkout->encrypt_decrypt($loginId);
            $TXN_AMOUNT = $checkout->encrypt_decrypt($orderPrice);

            $ORDER_IDParam = $checkout->encrypt_decrypt('ORDER_ID');
            $CUST_IDParam = $checkout->encrypt_decrypt('CUST_ID');
            $TXN_AMOUNTParam = $checkout->encrypt_decrypt('TXN_AMOUNT');


            // Create an array having all required parameters for creating checksum.
            $paramList[$ORDER_IDParam] = $ORDER_ID;
            $paramList[$CUST_IDParam] = $CUST_ID;
            $paramList[$TXN_AMOUNTParam] = $TXN_AMOUNT;

            $placeOrder = true;
            $paymentType = 'Online';
            $paymentMode = 'CCGateway';
            $paymentStatus = 'Success';
            $data['status'] = 'CCGateway';
            $data['CCData'] = $paramList;
        }
        if ($placeOrder == true) {
            foreach ($checkout->cartDetail() as $item) {
                $trackingId = $checkout->generateTrackingId();
                $isdeal = $homePage->isDealByProduct($item['id']);
                if (!empty($isdeal)) {
                    if ($isdeal[0]['stock'] != 0) {
                        $price = $isdeal[0]['price'];
                    } else {
                        if (($item['price'] == $item['discount']) || ($item['discount'] == 0)) {
                            $price = $item['price'];
                        } else {
                            $price = $item['discount'];
                        }
                    }
                } else {
                    if (($item['price'] == $item['discount']) || ($item['discount'] == 0)) {
                        $price = $item['price'];
                    } else {
                        $price = $item['discount'];
                    }
                }

                $productTotal = $item['quantity'] * $price;
                $gstOnProduct = $checkout->currentGstOnProduct($item['id']);

                $tempArr = array(
                  "user_id" => $loginId,
                  "order_id" => $orderId,
                  "tracking_id" => $trackingId,
                  "productid" => $item['id'],
                  "gst" => $gstOnProduct,
                  "price" => $productTotal,
                  "quantity" => $item['quantity'],
                  "payment_status" => $paymentStatus,
                  "payment_type" => $paymentType,
                  "date" => $date,
                  "time" => $time
                );

        // print_r($tempArr);
        // exit();
                if ($checkout->forcedInsert('order_details', $tempArr)) {    ///// Insert Order Details Data
                    //////// if Order Status is Automatic ////////
                    if ($checkout->orderConfig() == 'Automatic') {
                        $tempArr = array(
                          "user_id" => $loginId,
                          "order_id" => $orderId,
                          "tracking_id" => $trackingId,
                          "tracking_status" => 'Ordered and Approved',
                          "date" => $date,
                          "time" => $time
                        );

                        $orderStatus = $checkout->forcedInsert('order_status', $tempArr);   ///// Insert Order Status Data

                        $tempArr = array(
                          "user_id" => $loginId,
                          "order_id" => $orderId,
                          "tracking_id" => $trackingId,
                          "tracking_status" => 'Your Order has been placed',
                          "date" => $date,
                          "time" => $time
                        );
                        $orderStatus = $checkout->forcedInsert('order_status', $tempArr);   ///// Insert Order Status Data


                        ///////// Manage Stock /////////
                        $isdeal = $homePage->isDealByProduct($item['id']);
                        if (!empty($isdeal)) {
                            if ($isdeal[0]['stock'] != 0) {
                                $dealstock = $isdeal[0]['stock'] - $item['quantity'];

                                $tempArr = array(
                                  "pid" => $item['id'],
                                  "stock" => $dealstock,
                                );
                                $dealstockUpdate = $checkout->dealsave('today_deal', $tempArr);
                            }
                        }

                        $stock = $item['in_stock'] - $item['quantity'];
                        $isStock = ($stock == 0) ? 'No' : 'Yes';
                        $tempArr = array(
                          "id" => $item['id'],
                          "stock" => $isStock,
                          "in_stock" => $stock
                        );
                        $stockUpdate = $checkout->save('products', $tempArr);

                        $tempArr = array(
                          "p_id" => $item['id'],
                          "stock" => $stock,
                          "type" => 'Debit',
                          "created_date" => $date,
                          "created_time" => $time
                        );
                        $stockUpdate = $checkout->forcedInsert('stock', $tempArr);
                        ///////// Manage Stock /////////
                    }
                    //////// if Order Status is Automatic ////////
                }
            } ///// Cart Details if END


            $orderTempArr = array(
              "userid" => $loginId,
              "orderprice" => $orderPrice,
              "promo_code_id" => $coupanCode,
              "payment_type" => $paymentType,
              "payment_mode" => $paymentMode,
              "shipping" => '0',
              "order_id" => $orderId,
              "exp_time" => '',
              "exp_date" => '',
              "coupan_code" => $coupanCode,
              "date" => $date,
              "time" => $time
            );


            $placeOrder = $checkout->forcedInsert('order_tbl', $orderTempArr);
            // print_r($placeOrder);
            // exit();

            if ($placeOrder) { ///// Insert order_tbl table Data
                if ($_POST['paymentMethod'] == 'CCGateway') {
                    $orderTempArr['paymentM'] = 'CCGateway';
                    $data['order_details'] = $orderTempArr;
                }
                $orderPlaced = true;
                $checkOutStatus = true;

                // $data['result'] = 'Order Placed Successfully!';
                $data['orderId'] = $orderId;
            } else {
                $orderPlaced = false;
            }





            //check user address
            $dashboard = new Dashboard($con);
            $userData = $dashboard->getUserDetail();

            if (empty($userData['flat']) && empty($userData['street']) && empty($userData['locality']) && empty($userData['city']) && empty($userData['zipcode']) && empty($userData['state']) && empty($userData['country'])) {
                //user details
                $tempArr = array(
                  "id" => $loginId,
                  "flat" => $billingAddressFlat,
                  "street" => $billingAddressStreet,
                  "locality" => $billingAddressLocality,
                  "city" => $billingAddressCity,
                  "zipcode" => $billingAddressZipCode,
                  "state" => $billingAddressState,
                  "country" => $billingAddressCountry,
                  "addr_type" => $billingAddressType
                );


                $checkout->forcedInsert('user', $tempArr); ///// Update User table Address Details
            //user details
            } else {
                $billingAddressFirstName = $userData['firstname'];
                $billingAddressLastName = $userData['lastname'];
                $billingAddressPhone = $userData['mobile'];
                $billingAddressEmail = $userData['email'];
                $billingAddressFlat = $userData['flat'];
                $billingAddressStreet = $userData['street'];
                $billingAddressLocality = $userData['locality'];
                $billingAddressCity = $userData['city'];
                $billingAddressZipCode = $userData['zipcode'];
                $billingAddressState = $userData['state'];
                $billingAddressCountry = $userData['country'];
                $billingAddressType = $userData['addr_type'];
            }


            $tempArr = array(
              "order_id" => $orderId,
              "user_id" => $loginId,
              "first_name" => $billingAddressFirstName,
              "last_name" => $billingAddressLastName,
              "flat" => $billingAddressFlat,
              "street" => $billingAddressStreet,
              "locality" => $billingAddressLocality,
              "city" => $billingAddressCity,
              "zip_code" => $billingAddressZipCode,
              "state" => $billingAddressState,
              "country" => $billingAddressCountry,
              "email" => $billingAddressEmail,
              "phone" => $billingAddressPhone,
              "o_date" => $date,
              "o_time" => $time,
              "addr_type" => $billingAddressType
            );

            $checkout->forcedInsert('billing_address', $tempArr); ///// Insert billing_address table Address Details

            if (!isset($shippingFirstName) && !isset($shippingLastName) && !isset($shippingFlat) && !isset($shippingStreet) && !isset($shippingLocality) && !isset($shippingCountry) && !isset($shippingCity) && !isset($shippingState) && !isset($shippingZipCode) && !isset($shippingEmail) && !isset($shippingPhone) && !isset($shippingType)) {
                $shippingFirstName = $userData['firstname'];
                $shippingLastName = $userData['lastname'];
                $shippingPhone = $userData['mobile'];
                $shippingEmail = $userData['email'];
                $shippingFlat = $userData['flat'];
                $shippingStreet = $userData['street'];
                $shippingLocality = $userData['locality'];
                $shippingCity = $userData['city'];
                $shippingZipCode = $userData['zipcode'];
                $shippingState = $userData['state'];
                $shippingCountry = $userData['country'];
                $shippingType = $userData['addr_type'];
            }

            $tempArr = array(
              "order_id" => $orderId,
              "user_id" => $loginId,
              "first_name" => $shippingFirstName,
              "last_name" => $shippingLastName,
              "flat" => $shippingFlat,
              "street" => $shippingStreet,
              "locality" => $shippingLocality,
              "country" => $shippingCountry,
              "city" => $shippingCity,
              "state" => $shippingState,
              "zip_code" => $shippingZipCode,
              "email" => $shippingEmail,
              "phone" => $shippingPhone,
              "addr_type" => $shippingType,
              "o_date" => $date,
              "o_time" => $time
            );

            $checkout->forcedInsert('shiping_address', $tempArr); ///// Insert shiping_address table Data
            if ($_POST['paymentMethod'] == 'cod') {
                $cart->clearCart(); ///// Remove All Item From Cart
            }
        }
    ///// errMessage if END
    } else {
        $data['status'] = 'inputErr';
        $data['errMessage'] = $errMessage;      /////// Error Message If Input Fiels is NULL
    }
} else { ///// Payment Method if END
    $data['status'] = 'failed';
    $data['result'] = 'Please Select Payment method';
}
// print_r($data);
// die();
$data['checkOutStatus'] = $checkOutStatus;
echo json_encode($data);