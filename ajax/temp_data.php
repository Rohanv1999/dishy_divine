<?php
require('../config.php');


$addr_type = $_POST['newBillingAddressType'];
$first_name= $_POST['newBillingAddressFirstName'];
$last_name= $_POST['newBillingAddressLastName'];
$phone =$_POST['newBillingAddressPhone'];
$email =$_POST['newBillingAddressEmail'];
$flat =$_POST['newBillingAddressFlat'];
$street =$_POST['newBillingAddressStreet'];
$locality =$_POST['newBillingAddressLocality'];
$country =$_POST['newBillingAddressCountry'];
$state =$_POST['newBillingAddressState'];
$city =$_POST['newBillingAddressCity'];
$zip_code =$_POST['newBillingAddressZipCode'];

$tempArr = array(
    "addr_type" => $addr_type,
    "first_name" => $first_name,
    "last_name" => $last_name,
    "phone" => $phone,
    "email" => $email,
    "flat" => $flat,
    "street" => $street,
    "locality" => $locality,
    "country" => $country,
    "state" => $state,
    "city" => $city,
    "zip_code" => $zip_code
  );

  $_SESSION['checkf_data'] = $tempArr;


?>