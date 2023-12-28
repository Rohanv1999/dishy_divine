<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
//$con = mysqli_connect('localhost','root','', 'dishy_divine');

$con = mysqli_connect('localhost','root','', 'dishi_new');
define('BASE_URL', 'https://micodetest.com/dishy-divine/');
include('web-structure/classes/Model.php');
include('web-structure/web-structure-home/HomePage.php');
include('web-structure/web-structure-home/WishList.php');
include('web-structure/web-structure-home/Cart.php');
include('web-structure/web-structure-home/User.php');
include('web-structure/web-structure-home/Listing.php');
include('web-structure/web-structure-home/Dashboard.php');
include('web-structure/web-structure-home/Checkout.php');
include('web-structure/common_helper/core_query.php');
?>