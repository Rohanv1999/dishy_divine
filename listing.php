<?php
include('header.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);
// print_r($_SESSION);
if (isset($_GET['id'])) {
    // $products = $homePage->listingProducts($_GET['id']);
    unset($_SESSION['limitFrom']);
    unset($_SESSION['limitTo']);
    $productDetail = explode("@", $_GET['id']);
    $categoryType = $productDetail[0];
    $listingId = $productDetail[1];
    $classtype_id = array();
    $condition = "p." . $categoryType . "='" . $listingId . "'";
    $maxPrice = $listing->getMax($categoryType, $listingId);
    if ($categoryType == 'cat_id') {
        $issubcategory = mysqli_fetch_assoc(mysqli_query($con, "SELECT c.issubcategory FROM category c  WHERE c.id=" . $listingId))['issubcategory'];
    } else {
        $issubcategory = mysqli_fetch_assoc(mysqli_query($con, "SELECT c.issubcategory FROM category c  WHERE c.id=(select cat_id FROM subcategory WHERE id=$listingId)"))['issubcategory'];
    }
    if ($issubcategory == 'Yes') {
        if ($categoryType == 'cat_id') {
            $query = "SELECT classtype_id FROM subcategory WHERE cat_id=" . $listingId;
            $result = $homePage->getDataArray($query);

            foreach ($result as $r) {
                $class4 = json_decode($r['classtype_id']);
                foreach ($class4 as $v4) {
                    if (!in_array($v4, $classtype_id))
                        $classtype_id[] = $v4;
                }
            }
        } else {
            $classtype_id = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM subcategory WHERE id=" . $listingId))['classtype_id']);
        }
    } elseif ($issubcategory == 'No') {
        $classtype_id = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM category WHERE id=" . $listingId))['classtype_id']);
    } else if (isset($_SESSION['fill']['filter']['cat']) && isset($_SESSION['fill']['class'])) {
        if ($categoryType == 'cat_id') {
            foreach ($_SESSION['fill']['filter']['cat'] as $key1 => $class) {
                if (false !== strrpos($class, 'p.cat_id')) {
                    $cat = explode('p.cat_id=', $class)[1];

                    if (("'" . $listingId . "'") != $cat) {
                        unset($_SESSION['fill']);
                    } else {

                        $_SESSION['filter']['checked'] = $_SESSION['fill']['filter'];
                        $_SESSION['filter']['max'] = $_SESSION['fill']['max'];
                        $_SESSION['filter']['min'] = $_SESSION['fill']['min'];
                    }
                }
            }
        } else {
            foreach ($_SESSION['fill']['filter']['cat'] as $key1 => $class) {
                if (false !== strrpos($class, 'p.subcat_id')) {

                    $subcat = explode('p.subcat_id=', $class)[1];

                    if (("'" . $listingId . "'") != $subcat) {
                        unset($_SESSION['fill']);
                    } else {

                        $_SESSION['filter']['checked'] = $_SESSION['fill']['filter'];
                        $_SESSION['filter']['max'] = $_SESSION['fill']['max'];
                        $_SESSION['filter']['min'] = $_SESSION['fill']['min'];
                    }
                }
            }
        }
    }
    if (isset($_SESSION['filter']['checked']['cat']) && isset($_SESSION['classtype_id'])) {
        if ($categoryType == 'cat_id') {
            foreach ($_SESSION['filter']['checked']['cat'] as $key1 => $class) {
                if (false !== strrpos($class, 'p.cat_id')) {
                    $cat = explode('p.cat_id=', $class)[1];

                    if (("'" . $listingId . "'") != $cat) {
                        unset($_SESSION['filter']['checked']['cat'][$key1]);
                        unset($_SESSION['filter']['checked']['class0']);
                        unset($_SESSION['filter']['checked']['class1']);
                        unset($_SESSION['filter']['checked']['class2']);
                        unset($_SESSION['filter']['checked']['brand']);
                        unset($_SESSION['filter']['max']);
                        unset($_SESSION['filter']['min']);
                        // unset($_SESSION['fill']);
                        foreach ($classtype_id as $v) {
                            if (isset($_SESSION['classtype_id'])) {
                                foreach ($_SESSION['classtype_id'] as $k => $v1) {
                                    if ($v == $v1)
                                        unset($_SESSION['classtype_id']);
                                }
                            }
                        }
                    } else {
                        if (isset($_SESSION['fill'])) {
                            $_SESSION['filter']['checked'] = $_SESSION['fill']['filter'];
                        }
                    }
                }
                //         else
                //         {
                //           
                //         }
            }
        } else {
            foreach ($_SESSION['filter']['checked']['cat'] as $key1 => $class) {
                if (false !== strrpos($class, 'p.subcat_id')) {

                    $subcat = explode('p.subcat_id=', $class)[1];

                    if (("'" . $listingId . "'") != $subcat) {
                        unset($_SESSION['filter']['checked']['cat'][$key1]);
                        unset($_SESSION['filter']['checked']['class0']);
                        unset($_SESSION['filter']['checked']['class1']);
                        unset($_SESSION['filter']['checked']['class2']);
                        unset($_SESSION['filter']['checked']['brand']);
                        unset($_SESSION['filter']['max']);
                        unset($_SESSION['filter']['min']);
                        // unset($_SESSION['fill']);
                        foreach ($classtype_id as $v) {
                            if (isset($_SESSION['classtype_id'])) {
                                foreach ($_SESSION['classtype_id'] as $k => $v1) {
                                    if ($v == $v1)
                                        unset($_SESSION['classtype_id']);
                                }
                            }
                        }
                    } else {
                        if (isset($_SESSION['fill'])) {
                            $_SESSION['filter']['checked'] = $_SESSION['fill']['filter'];
                            $_SESSION['filter']['min'] = $_SESSION['fill']['min'];
                            $_SESSION['filter']['max'] = $_SESSION['fill']['max'];
                        }
                    }
                }
            }
        }

        unset($_SESSION['fill']);
    }

    // $classtype1 = implode(", ", $classtype_id);

    if (isset($_SESSION['classtype_id'])) {
        foreach ($classtype_id as $value) {

            if (!in_array($value, $_SESSION['classtype_id'])) {
                $_SESSION['classtype_id'][] = $value; ////// Add Filter

            }
        }
    } else {
        foreach ($classtype_id as $value) {
            $_SESSION['classtype_id'][] = $value; ////// Add Filter
        }
    }
    if (isset($_SESSION['filter']['checked']['cat'])) {
        if (!in_array($condition, $_SESSION['filter']['checked']['cat'])) {
            $_SESSION['filter']['checked']['cat'][] = $condition; ////// Add Filter

        }
    } else {
        $_SESSION['filter']['checked']['cat'][] = $condition; ////// Add Filter
    }
} else {
    $categoryType = "";
    if ((!isset($_SESSION['filter']['checked'])) || (!isset($_SESSION['classtype_id']))) {
        $_SESSION['filter']['checked'] = $_SESSION['fill']['filter'];
        $_SESSION['filter']['min'] = $_SESSION['fill']['min'];
        $_SESSION['filter']['max'] = $_SESSION['fill']['max'];
        $_SESSION['classtype_id'] = $_SESSION['fill']['class'];
        // unset($_SESSION['fill']);
    }

    // print_r($products);
    // exit();
}
// echo '<pre>';
// print_r($_SESSION);
// exit();
$randamValue = rand();
?>
<style>
    .rtcn {
      background-color: green;
    color: yellow;
    padding: 2px 11px;
    border-radius: 10px;
    margin-right: 8px;
    display: flex;
    align-items: center;
    gap: 5px;
    }

    span.price-regular {
        font-size: 15px;
        font-family: 'Poppins';
    }
.product-details.text-left {
    padding: 0px 10px 20px;
}
    span.price-old {
        color: #c1c1c1;
        text-decoration: line-through;
        font-size: 11px;
    }

    .txtcn {
        color: white;
        margin-right: 2px;
    }

    li {
        list-style: none;
    }

    .nice-select .list {
        top: 2rem !important;

    }

    .product-short .nice-select {
        margin-bottom: 10px;
    }

    .form-group {
        display: block;
        margin-bottom: 15px;
    }

    .form-group input {
        padding: 0;
        height: initial;
        width: initial;
        margin-bottom: 0;
        display: none;
        cursor: pointer;
    }

    .form-group label {
        position: relative;
        cursor: pointer;
    }

    .py-2 {
        padding: 0px 16px;
    }

    .form-select:focus {
        box-shadow: none;
    }

    .bg-white.cart-box.border.rounded.position-relative {
        margin-bottom: 14px;
    }

    .price-input {
        width: 100%;
        display: flex;
        margin: 30px 0 35px;
    }

    .price-input .field {
        display: flex;
        width: 100%;
        height: 45px;
        align-items: center;
    }

    .field input {
        width: 100%;
        height: 80%;
        outline: none;
        font-size: 15px;
        margin-left: 12px;
        border-radius: 5px;
        text-align: center;
        border: 1px solid #999;
        /* -moz-appearance: textfield; */
    }

    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }

    .price-input .separator {
        width: 100px;
        display: flex;
        font-size: 19px;
        align-items: center;
        justify-content: center;
    }

    .slider {
        height: 5px;
        position: relative;
        background: #ddd;
        border-radius: 5px;
    }

    .slider .progress {
        height: 100%;
        left: 0%;
        right: 0%;
        position: absolute;
        border-radius: 5px;
        background: #17a2b8;
    }

    .range-input {
        position: relative;
    }

    .range-input input {
        position: absolute;
        width: 100%;
        height: 5px;
        top: -5px;
        background: none;
        pointer-events: none;
        /* -webkit-appearance: none;
        -moz-appearance: none; */
    }

    input[type="range"]::-webkit-slider-thumb {
        height: 17px;
        width: 17px;
        border-radius: 50%;
        background: #17a2b8;
        pointer-events: auto;
        -webkit-appearance: none;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
    }

    input[type="range"]::-moz-range-thumb {
        height: 17px;
        width: 17px;
        border: none;
        border-radius: 50%;
        background: #17a2b8;
        pointer-events: auto;
        -moz-appearance: none;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
    }



    .form-group a {
        list-style: none;
        color: black;
        text-decoration: none;
    }

    .form-group a:hover {
        color: #FF9A40;
    }

    .range-input {
        position: relative;
    }

    li.arrowlist.curreny-wrap.active a {
        color: black;
    }

    li.arrowlist.curreny-wrap.active {
        background: aliceblue;
    }

    .filter-actions.mb-4 {
        display: none;
    }

    ul.breadcrumb li {
        background-color: aliceblue;
        padding: 0 10px;
        border-radius: 5px;
    }

    nav.toolbox {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .ratings-container {
        display: flex;
        align-items: center;
    }
    
button#filtertoggle, .crossmark {
    display: none !important;
}
@media (max-width:991px) {
    button#filtertoggle, .crossmark {
    display: block !important;
}
    aside.col-lg-3.sidebar.sidebar-fixed.sidebar-toggle-remain.shop-sidebar.sticky-sidebar-wrapper {
        position: absolute;
        background: white;
        left: -900px;
        z-index: 1000000;
        transition: all 0.4s ease-in-out;
        width: 300px;
        height: 100vh;
        top: 1px;
        padding: 31px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }

    aside.col-lg-3.sidebar.sidebar-fixed.sidebar-toggle-remain.shop-sidebar.sticky-sidebar-wrapper.active {
        left: 0px;

    }

    .overlayks {
        position: absolute;
        left: -900px;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        transition: all 0.4s ease-in-out;
        height: 100vh;
        width: 500px;
        top: 0;
    }

    .overlayks.active {
        left: 0;
    }

    .crossmark {
        position: absolute;
        right: 24px;
        padding: 10px;
    }

    .mobile-nav-wrapper.active {
        z-index: 8;
        height: 100vh;
    }

    body.menuOn:after {
        z-index: 4;
    }

    body.menuOn .page-wrapper {
        left: 0px;
    }
}
</style>
<div class="overlayks"></div>
<main id="page-content">
    <!--Collection Banner-->
    <div class="collection-header">
        <div class="collection-hero">
            <div class="collection-hero__image"></div>
            <div class="collection-hero__title-wrapper container">
                <h2 class="collection-hero__title">PRODUCT LISTING</h2>
                <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="index.php" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Shop</span></div>
            </div>
        </div>
    </div>
    <!--End Collection Banner-->

    <div class="page-content mb-10 pb-3">
        <div class="container">
            <div class="row main-content-wrap gutter-lg">
                <aside class="col-lg-3 sidebar sidebar-fixed sidebar-toggle-remain shop-sidebar sticky-sidebar-wrapper">
                    <i class="fa fa-xmark crossmark"></i>
                    <div class="sidebar_tags">
                        <!--Categories-->
                        <div class="sidebar-content">
                            <div class="sticky-sidebar" data-sticky-options="{'top': 10}">
                                <?php
                                $products = $listing->filterProducts();
                                ?>
                                <div class="widget-collapsible mb-4">
                                    <h3 class="widget-title">All Categories</h3>
                                    <div class="sidebar_widget categories filterBox filter-widget">
                                        <div class="widget-content filterDD">
                                            <ul class="clearfix sidebar_categories mb-0">
                                                <?php
                                                //Show categories in filter sidebar
                                                foreach ($homePage->categories('all') as $category) {
                                                    $disabled = ""; //Fetch New Products Category First "arg=$condition" Second "arg=Limit"
                                                    $issubcategory = mysqli_fetch_assoc(mysqli_query($con, "SELECT c.issubcategory FROM category c  WHERE c.id=" . $category['id']))['issubcategory'];
                                                    if ($issubcategory == 'Yes') {
                                                        $fetchSubcat = mysqli_query($con, "SELECT s.* FROM subcategory s, products p WHERE s.trash = 'No' AND s.status = 'Active' AND p.subcat_id = s.id AND s.cat_id = " . $category['id'] . " group by s.id");
                                                        $classtype_id1 = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM subcategory WHERE cat_id=" . $category['id']))['classtype_id']);
                                                    } elseif ($issubcategory == 'No') {
                                                        $classtype_id1 = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM category WHERE id=" . $category['id']))['classtype_id']);
                                                    }
                                                    $classtype2 = implode(", ", $classtype_id1);
                                                    if ($categoryType == 'cat_id') {
                                                        if (($listingId == $category['id']) || (in_array("p.cat_id='" . $category['id'] . "'", $_SESSION['filter']['checked']['cat']))) {
                                                            $disabled = "";
                                                            if ($listingId == $category['id'])
                                                                $disabled = ""; ?>



                                                            <li class="lvl-1">
                                                                <a <?= $disabled; ?> href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&id=cat_id@<?= $category['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="site-nav"><?= $category['cat_name']; ?></a>
                                                         <!--       <?php if ($issubcategory == 'Yes') { ?>
                                                                    <ul class="sublinks">
                                                                        <?php while ($subcat = mysqli_fetch_assoc($fetchSubcat)) { ?>
                                                                            <li class="level2">
                                                                                <a <?= $disabled; ?> href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&id=subcat_id@<?= $subcat['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="site-nav"><?= $subcat['sub_cat_name']; ?></a>
                                                                            </li>
                                                                        <?php } ?>

                                                                    </ul>
                                                                <?php } ?>-->
                                                            </li>
                                                        <?php } else {
                                                        ?>
                                                            <li class="lvl-1">
                                                                <a <?= $disabled; ?> href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&id=cat_id@<?= $category['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="site-nav"><?= $category['cat_name']; ?></a>
                                                              <!--  <?php if ($issubcategory == 'Yes') { ?>
                                                                    <ul class="sublinks">
                                                                        <?php while ($subcat = mysqli_fetch_assoc($fetchSubcat)) { ?>
                                                                            <li class="level2">
                                                                                <a href="#" class="site-nav">Women</a>
                                                                                <a <?= $disabled; ?> href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&id=subcat_id@<?= $subcat['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="site-nav"><?= $subcat['sub_cat_name']; ?></a>
                                                                            </li>
                                                                        <?php } ?>
                                                                    </ul>
                                                                <?php } ?>-->
                                                            </li>

                                                        <?php }
                                                    } else {
                                                        if (in_array("p.cat_id='" . $category['id'] . "'", $_SESSION['filter']['checked']['cat'])) {
                                                            echo '5'; ?>

                                                            <li class="lvl-1 sub-level">

                                                                <a <?= $disabled; ?> href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&id=cat_id@<?= $category['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="site-nav"><?= $category['cat_name']; ?></a>
                                                           <!--     <?php if ($issubcategory == 'Yes') { ?>

                                                                    <ul class="sublinks">
                                                                        <?php while ($subcat = mysqli_fetch_assoc($fetchSubcat)) { ?>
                                                                            <li class="level2">
                                                                                <a <?= $disabled; ?> href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&id=subcat_id@<?= $subcat['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="site-nav"><?= $subcat['sub_cat_name']; ?></a>
                                                                            </li>
                                                                        <?php } ?>

                                                                    </ul>
                                                                <?php } ?>-->
                                                            </li>

                                                        <?php } else { ?>


                                                            <li class="lvl-1 sub-level">
                                                                <a <?= $disabled; ?> href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&id=cat_id@<?= $category['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="site-nav"><?= $category['cat_name']; ?></a>
                                                       <!--         <?php if ($issubcategory == 'Yes') { ?>
                                                                    <ul class="sublinks">
                                                                        <?php while ($subcat = mysqli_fetch_assoc($fetchSubcat)) { ?>
                                                                            <li class="level2">

                                                                                <a <?= $disabled; ?> href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&id=subcat_id@<?= $subcat['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="site-nav"><?= $subcat['sub_cat_name']; ?></a>
                                                                            </li>
                                                                        <?php } ?>

                                                                    </ul>
                                                                <?php } ?>-->
                                                            </li>
                                                <?php }
                                                    }
                                                } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <div class="filterSlider mb-4">
                                    <div id="refreshSlider">
                                        <?php
                                        //print_r($_SESSION);

                                        //show sizes in filter sidebar
                                        $ids = array();
                                        $ids = $_SESSION['filter']['checked']['cat'];
                                        // print_r($homePage->brands($ids));
                                        $brancdds = $homePage->brands($ids);
                                        if (!empty($brancdds)) { ?>
                                            <div class="sidebar-border mb-4">

                                                <div class="widget widget-collapsible">
                                                    <h3 class="widget-title">BRANDS</h3>
                                                    <div class=" ">
                                                        <ul class="brand-menu filter-items">
                                                            <?php
                                                            //print_r($_SESSION);
                                                            foreach ($brancdds as $brand) {
                                                                // unset($_SESSION['filter']);
                                                                // print_r($_SESSION['filter']['checked']);
                                                                if (array_key_exists("brand", $_SESSION['filter']['checked'])) {

                                                                    if (!empty($_SESSION['filter']['checked']['brand'])) {

                                                                        if (in_array("p.brand='" . $brand['brand'] . "'", $_SESSION['filter']['checked']['brand'])) {



                                                            ?>
                                                                            <li><input type="checkbox" class="filterCheckbox" name="filterBrand<?= $brand['brand']; ?>" value="p.brand='<?= $brand['brand']; ?>'" checked onchange="checkboxFilter(this,'brand','');">&nbsp;
                                                                                <?= $brand['brand']; ?> </li>
                                                                        <?php

                                                                        } else {
                                                                        ?>
                                                                            <li><input type="checkbox" class="filterCheckbox" name="filterBrand<?= $brand['brand']; ?>" value="p.brand='<?= $brand['brand']; ?>'" onchange="checkboxFilter(this,'brand','');">&nbsp;
                                                                                <?= $brand['brand']; ?> </li>

                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <li><input type="checkbox" class="filterCheckbox" name="filterBrand<?= $brand['brand']; ?>" value="p.brand='<?= $brand['brand']; ?>'" onchange="checkboxFilter(this,'brand','');">&nbsp;
                                                                            <?= $brand['brand']; ?> </li>

                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <li><input type="checkbox" class="filterCheckbox" name="filterBrand<?= $brand['brand']; ?>" value="p.brand='<?= $brand['brand']; ?>'" onchange="checkboxFilter(this,'brand','');">&nbsp;
                                                                        <?= $brand['brand']; ?> </li>

                                                            <?php
                                                                }
                                                            }


                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <!---->
                                            <?php
                                        }
                                        foreach ($_SESSION['filter']['checked']['cat'] as $catId) {
                                            $productDetail = explode("=", $catId);
                                            $categoryId = $productDetail[1];
                                            $categoryType1 = $productDetail[0];
                                            $classtype_id2 = array();
                                            if ($categoryType1 == 'p.cat_id') {
                                                $issubcategory1 = mysqli_fetch_assoc(mysqli_query($con, "SELECT c.issubcategory FROM category c  WHERE c.id=" . $categoryId))['issubcategory'];
                                                if ($issubcategory1 == 'Yes') {
                                                    $query = "SELECT classtype_id FROM subcategory WHERE cat_id=" . $categoryId;
                                                    $result = $homePage->getDataArray($query);

                                                    foreach ($result as $r) {
                                                        $class4 = json_decode($r['classtype_id']);
                                                        foreach ($class4 as $v4) {
                                                            if (!in_array($v4, $classtype_id2))
                                                                $classtype_id2[] = $v4;
                                                        }
                                                    }
                                                } elseif ($issubcategory1 == 'No') {
                                                    $classtype_id2 = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM category WHERE id=" . $categoryId))['classtype_id']);
                                                }
                                            } else {
                                                $classtype_id2 = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM subcategory WHERE id=" . $categoryId))['classtype_id']);
                                            }
                                            foreach ($classtype_id2 as $val) {
                                                foreach ($_SESSION['classtype_id'] as $class) {
                                                    if ($class != 16 && $val == $class) {
                                                        $classtypeNameQuery1 = mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM classtype WHERE id=$class"))['name'];

                                            ?>

                                                        <!--Widget Brand Start-->
                                                        <div class="sidebar-border">
                                                            <div class="widget widget-collapsible">
                                                                <h3 class="widget-title"><?= strtoupper($classtypeNameQuery1); ?></h3>

                                                                <div class=" ">

                                                                    <ul class="brand-menu filter-items clatype" id="<?= strtolower($classtypeNameQuery1); ?>_ul">
                                                                        <?php
                                                                        //show sizes in filter sidebar
                                                                        $categoryType = $productDetail[0];
                                                                        $listingId = $productDetail[1];
                                                                        foreach ($homePage->sizes1($class, $categoryType, $listingId) as $size) {
                                                                            $c = count($classtype_id2);
                                                                            $type = '';
                                                                            if ($c == 3) {
                                                                                $type = 'class0';
                                                                                if ($classtype_id2[2] == $size['classtype_id'])
                                                                                    $type = 'class2';
                                                                                $id = $size['id'];
                                                                                if ($size['classtype_id'] == $classtype_id2[0]) {
                                                                                    $type = 'class1';
                                                                                    $id = $size['symbol'];
                                                                                }
                                                                            } else if ($c == 2) {
                                                                                $type = 'class0';
                                                                                $id = $size['id'];
                                                                                if ($size['classtype_id'] == $classtype_id2[0]) {
                                                                                    $type = 'class1';
                                                                                    $id = $size['symbol'];
                                                                                }
                                                                            } else if ($c == 1 && $classtype_id2[0] != 16) {
                                                                                $id = $size['id'];
                                                                                $type = 'class0';
                                                                            }

                                                                            if ($size['classtype_id'] == $class) {
                                                                                $sizeingram = $size['symbol'];

                                                                                if (strtolower($classtypeNameQuery1) == 'weight') {
                                                                                    if (strpos($size['symbol'], "GRAM") !== false) {
                                                                                        $sizeingram = trim(explode("GRAM", $size['symbol'])[0]);
                                                                                    }
                                                                                    if (strpos($size['symbol'], "gram") !== false) {
                                                                                        $sizeingram = trim(explode("gram", $size['symbol'])[0]);
                                                                                    }
                                                                                    if (strpos($size['symbol'], "G") !== false) {
                                                                                        $sizeingram = trim(explode("G", $size['symbol'])[0]);
                                                                                    }
                                                                                    if (strpos($size['symbol'], "g") !== false) {
                                                                                        $sizeingram = trim(explode("g", $size['symbol'])[0]);
                                                                                    }
                                                                                    if (strpos($size['symbol'], "kg") !== false) {
                                                                                        $sizeingram = trim(explode("kg", $size['symbol'])[0]);
                                                                                        if ($sizeingram !== '')
                                                                                            $sizeingram = $sizeingram * 1000;
                                                                                        else
                                                                                            $sizeingram = 1000;
                                                                                    }
                                                                                    if (strpos($size['symbol'], "KG") !== false) {
                                                                                        $sizeingram = trim(explode("KG", $size['symbol'])[0]);
                                                                                        if ($sizeingram !== '')
                                                                                            $sizeingram = $sizeingram * 1000;
                                                                                        else
                                                                                            $sizeingram = 1000;
                                                                                    }
                                                                                    if (strpos($size['symbol'], "Kg") !== false) {
                                                                                        $sizeingram = trim(explode("Kg", $size['symbol'])[0]);
                                                                                        if ($sizeingram !== '')
                                                                                            $sizeingram = $sizeingram * 1000;
                                                                                        else
                                                                                            $sizeingram = 1000;
                                                                                    }
                                                                                    if (strpos($size['symbol'], "kG") !== false) {
                                                                                        $sizeingram = trim(explode("kG", $size['symbol'])[0]);
                                                                                        if ($sizeingram !== '')
                                                                                            $sizeingram = $sizeingram * 1000;
                                                                                        else
                                                                                            $sizeingram = 1000;
                                                                                    }
                                                                                    if (strpos($size['symbol'], "kilogram") !== false) {
                                                                                        $sizeingram = trim(explode("kilogram", $size['symbol'])[0]);
                                                                                        if ($sizeingram !== '')
                                                                                            $sizeingram = $sizeingram * 1000;
                                                                                        else
                                                                                            $sizeingram = 1000;
                                                                                    }
                                                                                    if (strpos($size['symbol'], "KILOGRAM") !== false) {
                                                                                        $sizeingram = trim(explode("KILOGRAM", $size['symbol'])[0]);
                                                                                        if ($sizeingram !== '')
                                                                                            $sizeingram = $sizeingram * 1000;
                                                                                        else
                                                                                            $sizeingram = 1000;
                                                                                    }
                                                                                }
                                                                                //Fetch New Products Category First "arg=$condition" Second "arg=Limit"
                                                                                if (array_key_exists($type, $_SESSION['filter']['checked'])) {
                                                                                    if (!empty($_SESSION['filter']['checked'][$type])) {
                                                                                        if (in_array("p." . $type . "='" . $id . "'", $_SESSION['filter']['checked'][$type])) {

                                                                        ?>

                                                                                            <li><input type="checkbox" class="filterCheckbox" sizegram="<?= $sizeingram; ?>" name="filterSize<?= $size['id']; ?>" value="p.<?= $type ?>='<?= $id ?>'" onchange="checkboxFilter(this,'<?= $type; ?>','<?= $class ?>');" checked>&nbsp; <?= $size['symbol']; ?> </li>
                                                                                        <?php
                                                                                        } else {
                                                                                        ?>
                                                                                            <li><input type="checkbox" class="filterCheckbox" sizegram="<?= $sizeingram; ?>" name="filterSize<?= $size['id']; ?>" value="p.<?= $type ?>='<?= $id; ?>'" onchange="checkboxFilter(this,'<?= $type; ?>',<?= $class ?>);">&nbsp;
                                                                                                <?= $size['symbol']; ?> </li>
                                                                                        <?php
                                                                                        }
                                                                                    } else {
                                                                                        ?>
                                                                                        <li><input type="checkbox" class="filterCheckbox" sizegram="<?= $sizeingram; ?>" name="filterSize<?= $size['id']; ?>" value="p.<?= $type ?>='<?= $id; ?>'" onchange="checkboxFilter(this,'<?= $type; ?>','<?= $class ?>');">&nbsp;
                                                                                            <?= $size['symbol']; ?> </li>
                                                                                    <?php
                                                                                    }
                                                                                } else {
                                                                                    ?>

                                                                                    <li><input type="checkbox" class="filterCheckbox" sizegram="<?= $sizeingram; ?>" name="filterSize<?= $size['id']; ?>" value="p.<?= $type; ?>='<?= $id; ?>'" onchange="checkboxFilter(this,'<?= $type; ?>','<?= $class ?>');">&nbsp;
                                                                                        <?= $size['symbol']; ?> </li>

                                                                        <?php
                                                                                }
                                                                            }
                                                                        }


                                                                        ?>

                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                        <!--Widget Brand End-->
                                        <!--Widget Manufacture Start-->


                                    </div>
                                </div>

                                <?php
                                foreach ($_SESSION['filter']['checked']['cat'] as $c) {
                                    $catId = $c;
                                    $productDetail = explode("=", $catId);
                                    $categoryId = $productDetail[1];
                                    $categoryType1 = $productDetail[0];
                                }
                                $ratingFilter = $homePage->ratingFilter($categoryId, $categoryType1);
                                if ($ratingFilter[0]['max_rating'] != 0) { ?>

                                    <div class="sidebar-border widget widget-collapsible">
                                        <h3 class="widget-title">Filter By Customer Rating</h3>
                                        <div class="">
                                            <ul class="brand-menu filter-items">
                                                <div class="d-flex" style="flex-direction: column-reverse">
                                                    <?php
                                                    if ($ratingFilter[0]['max_rating'] != 0) {

                                                        for ($i = 1; $i < $ratingFilter[0]['max_rating']; $i++) { ?>
                                                            <li><input type="checkbox" class="filterCheckbox" name="filterRating<?= $i; ?>" value="p.avg_rating>='<?= $i; ?>'" <?= (isset($_SESSION['filter']['checked']['rating']) && in_array("p.avg_rating>='$i'", $_SESSION['filter']['checked']['rating'])) ? 'checked' : ''; ?> onchange="checkboxFilter(this,'rating', );">&nbsp;&nbsp;<?= $i; ?>&nbsp;<i class="fa fa-star"></i>&nbsp;&&nbsp; above </li>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </ul>

                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="sidebar-border widget widget-collapsible">
                                    <h3 class="widget-title">Discount</h3>
                                    <div class="">
                                        <ul class="brand-menu filter-items</a>">
                                            <li><input type="checkbox" class="filterCheckbox" name="filterDiscount<?= $product['id']; ?>" value="p.price!=p.discount" onchange="checkboxFilter(this,'discount');">&nbsp;Discounted Products</li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                </aside>
                <div class="col-lg-9 main-content">
                    <div class="sticky-content-wrapper">
                        <nav class="toolbox sticky-toolbox sticky-content fix-top">
                            <button type="button"
                                class="btn--link me-3 d-flex justify-content-between align-items-center gap-2"
                                id="filtertoggle">
                                <i class="fa fa-bars"></i>
                            </button>
                            <div class="toolbox-right">
                                <div class="toolbox-item toolbox-show">
                                    <p>Showing <span id="recordFrom"><?= $listing->recordFrom(); ?></span>–<span id="recordTo"><?= $listing->recordTo(); ?></span> Of <span id="totalProducts"><?= $listing->totalProducts(); ?></span> Results</p>
                                </div>
                            </div>
                            <div class="toolbox-left">
                                <div class="toolbox-item toolbox-sort select-box">
                                    <label>Filter By :</label>
                                    <select name="orderby" class="form-control form-select h-auto" id="short" onchange="orderBy(this.value);" tabindex="1">
                                        <option selected="" value="">Select</option>
                                        <option value="and p.top='Yes'">Sort by popularity</option>
                                        <option value="and p.new_arrivals='Yes'">Sort by newness</option>
                                        <option value="ASC">Sort by price: low to high</option>
                                        <option value="DESC">Sort by price: high to low</option>
                                    </select>
                                </div>
                            </div>

                        </nav>
                    </div>
                    <div class="grid-products grid--view-items prd-grid">

                        <div class="row product-wrapper changeFilter" id="filterProductId">
                            <?php
                            //print_r($_SESSION);
                            // $products = $listing->filterProducts();

                            if (empty($products)) {
                            ?>

                                <div class="col-lg-12 col-md-12 item-col2">
                                    <br>

                                    <h1 class="text-center" style="background-color: aliceblue; padding: 72px 0;
                                    border-radius: 5px;"> Oops! No Product Found! </h1>
                                    <br>
                                </div>
                                <?php
                            } else {

                                if (isset($_SESSION['filter']['orderBy']) && ($_SESSION['filter']['orderBy'] != "")) {

                                    if ((explode(' ', $_SESSION['filter']['orderBy'])[0]) != 'and') {
                                        $orderby = explode(' ', $_SESSION['filter']['orderBy'])[0];
                                        $products = $listing->getOrderByProducts($products, $orderby);
                                    }
                                }
                                // echo "<pre>";
                                // print_r($products);
                                $priceArr = [];
                                $j = 0;
                                foreach ($products as $product) {
                                    $issubcategory = mysqli_fetch_assoc(mysqli_query($con, "SELECT c.issubcategory FROM category c  WHERE c.id=" . $product['cat_id']))['issubcategory'];
                                    if ($issubcategory == 'Yes' && $product['subcat_id'] != '') {
                                        $query1 = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM subcategory WHERE id=" . $product['subcat_id']))['classtype_id']);
                                    } else {
                                        $query1 = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM category WHERE id=" . $product['cat_id']))['classtype_id']);
                                    }
                                    $classtypeName = array();
                                    $primaryClassName = "";
                                    $classtype1 = implode(", ", $query1);
                                    // echo $classtype1;
                                    // echo "SELECT id,name FROM classtype WHERE id IN($classtype1) GROUP BY id";
                                    $classtypeNameQuery = mysqli_query($con, "SELECT id,name FROM classtype WHERE id IN($classtype1) GROUP BY id");
                                    while ($row = mysqli_fetch_array($classtypeNameQuery)) {
                                        $classtypeName[] = array('id' => $row['id'], 'name' => $row['name']);
                                        $classtypeId12[] = $row['id'];
                                    }

                                    if ((count($query1)) == 3) {
                                        $k1 = array();
                                        foreach ($classtypeName as $k => $value) {

                                            if ($query1[0] != $value['id']) {
                                                $k1[] = $k;
                                            }
                                        }
                                        $primaryClassName = ucfirst($classtypeName[$k1[0]]['name']) . '+' . ucfirst($classtypeName[$k1[1]]['name']);

                                        // $class="'".$query1[1]."','".$query1[2].",";
                                    } elseif (count($query1) == 2) {
                                        $primaryClassName = ucfirst($classtypeName[0]['name']);
                                        if ($query1[0] == $classtypeName[0]['id']) {
                                            $primaryClassName = ucfirst($classtypeName[1]['name']);
                                        }
                                    } elseif (count($query1) == 1 && $query1[0] != 16) {
                                        $primaryClassName = ucfirst($classtypeName[0]['name']);
                                    }


                                ?>
                                    <div class="col-6 col-sm-6 col-md-4 col-lg-4 item" id="productCard_<?= $j; ?>">
                                        <div class="hny_products">
                                        <!--Start Product Image-->
                                        <div class="product-image">
                                            <!--Start Product Image-->
                                            <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $product['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="product-img">
                                                <?php
                                                //show Product Image
                                                $images = $homePage->image('product', $product['product_code']);
                                                if ($images == "") {
                                                ?>
                                                    <img class="first-img" src="asset/image/logo/<?= $homePage->logo()['logo']; ?>" alt="">
                                                <?php
                                                } else {
                                                    $imageCount = count($images);
                                                ?>
                                                    <img class="primary blur-up lazyload" data-src="asset/image/product/<?= $images[0]['image']; ?>" src="asset/image/product/<?= $images[0]['image']; ?>" alt="image" title="">
                                                <?php
                                                }
                                                ?>
                                                <div class="product-labels">
                                                    <?php
                                                    if (isset($product['price']) && isset($product['discount']) && $product['discount'] < $product['price']) {
                                                        $price = $product['price'];
                                                        $discountedPrice = $product['discount'];

                                                        $off = $homePage->calculateDiscountPercentage($price, $discountedPrice);
                                                    ?>
                                                        <span class="lbl on-sale rounded" id="modelPer<?= $randamValue . $product['id'] ?>"><?= $off; ?>% OFF</span>
                                                    <?php } ?>
                                                </div>
                                                <!-- End product label -->
                                            </a>
                                            <!--End Product Image-->

                                            <!--Product Button-->
                                            <div class="button-set style0 d-none d-md-block">
                                                <ul>
                                                    <li>
                                                        <div class="mywishlistdiv addToWishList<?= $randamValue . $product['id'] ?>">
                                                            <div id="newWish_<?= $product['id'] ?>">
                                                                <?php if (!$wishList->productExistInWishList($product['id'])) { ?>
                                                                    <a class="btn-icon wishlist add-to-wishlist" onclick="addToWishList(<?= $product['id']; ?>,this.id,'<?= $url; ?>')" id="addToWishList<?= $randamValue . $product['id'] ?>" href="javascript:;"><i class="icon an an-heart-l"></i> <span class="tooltip-label top">Add To Wishlist</span></a>

                                                                <?php } else { ?>


                                                                    <a onclick="removeFromWishList(<?= $product['id']; ?>,this.id,'<?= $url; ?>')" id="addToWishList<?= $randamValue . $product['id'] ?>" href="javascript:;"><i class="fa fa-heart" style="background-color:white;padding:8px;color:red;border-radius:4px;border:1px solid #e0e0e0;font-size:16px;"></i> <span class="tooltip-label top">Add To Wishlist</span></a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!--End Product Button-->
                                        </div>
                                        <!--End Product Image-->
                                        <!--Start Product Details-->
                                        <div class="product-details text-left">
                                            <div class="product-cat">
                                                <?php $catName = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM category WHERE id  = '" . $product['cat_id'] . "'"));
                                                if (!empty($catName)) {
                                                    $cat = $catName['cat_name'];
                                                } ?>
                                                <a href="javascript:void(0)"><?= (isset($cat)) ? $cat : ''; ?></a>

                                            </div>
                                            <div class="product-name text-uppercase">
                                                <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $product['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>"><?= $product['product_name']; ?></a>
                                            </div>
                                            <!--End Product Name-->
                                            <!--Product Price-->
                                            <div class="product-price" id="modelPrice<?= $randamValue . $product['id'] ?>">
                                                <?php
                                                $isdeal = $homePage->isDealByProduct($product['id']);
                                                if (!empty($isdeal)) {
                                                    if ($isdeal[0]['stock'] != 0) {
                                                ?>
                                                        <span class="price-regular"><?= $currency; ?><?= $isdeal[0]['price']; ?></span>
                                                        <span class="price-old"><?= $currency; ?><?= $product['price']; ?></span>

                                                        <?php
                                                    } else {
                                                        if (($product['price'] == $product['discount']) || ($product['discount'] == 0)) { ?>
                                                            <span class="price-regular"><?= $currency; ?><?= $product['price']; ?></span>
                                                        <?php
                                                        } else { ?>
                                                            <span class="price-regular"><?= $currency; ?><?= $product['discount']; ?></span>
                                                            <span class="price-old"><?= $currency; ?><?= $product['price']; ?></span>
                                                        <?php
                                                        }
                                                    }
                                                } else {
                                                    if (($product['price'] == $product['discount']) || ($product['discount'] == 0)) { ?>
                                                        <span class="price-regular"><?= $currency; ?><?= $product['price']; ?></span>
                                                    <?php
                                                    } else { ?>
                                                        <span class="price-regular"><?= $currency; ?><?= $product['discount']; ?></span>
                                                        <span class="price-old"><?= $currency; ?><?= $product['price']; ?></span>
                                                <?php
                                                    }
                                                } ?>

                                            </div>

                                            <div class="ratings-container">
                                                <div class="rtcn"><span class="txtcn"><?= $product['avg_rating']; ?></span><i class="an an-star-o"></i> </div>

                                                <?php $totalReviews = mysqli_num_rows(mysqli_query($con, 'SELECT r.id,r.star,r.review_title,r.review,r.userid,r.datentime,u.firstname 
                                           FROM review as r
                                           LEFT JOIN user as u on u.id=r.userid and u.status="Active"
                                                    WHERE r.status="Active" AND r.pid="' . $product['id'] . '"')); ?>
                                                <a href="product-detail.php" class="rating-reviews">( <?= $totalReviews; ?> reviews )</a>
                                            </div>
                                        </div>
                                        <!--End Product Details-->
                                        </div>
                                    </div>
                                <?php
                                    $j++;
                                }

                                if (!empty($priceArr)) {
                                    $minProductPrice = min($priceArr);
                                    $maxProductPrice = max($priceArr);
                                } else {
                                    $minProductPrice = 0;
                                    $maxProductPrice = 0;
                                }

                                ?> <input type="hidden" value="<?= $minProductPrice ?>" id="minPriceHidden">
                                <input type="hidden" value="<?= $maxProductPrice ?>" id="maxPriceHidden">

                            <?php }
                            ?>


                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</main>
<?php include('includes/footer.php') ?>
<script>
    console.log($("#minPriceHidden").val())
    console.log($("#maxPriceHidden").val())

    $(document).ready(function() {
        $('#minPriceInp').val($("#minPriceHidden").val())
        $('#minPriceInp').attr('min', $("#minPriceHidden").val())
        $('#minPriceInp').attr('max', $("#maxPriceHidden").val())

        $('#maxPriceInp').val($('#maxPriceHidden').val());
        $('#maxPriceInp').attr('min', $('#minPriceHidden').val());
        $('#maxPriceInp').attr('max', $('#maxPriceHidden').val());

        $('#maxPrice').val($("#maxPriceHidden").val())
        $('#minPrice').val($("#minPriceHidden").val())
    })
</script>

<script>
    $('.clatype').each(function() {
        var ids = $(this).attr('id');
        var rawNames = $('#' + ids).find('li');
        var sortedNames = [];
        $(rawNames).each(function() {


            if ((ids).includes('weight') || (ids).includes('litre'))
                var names = Number($(this).find('input').attr('sizegram'));
            else
                var names = $(this).find('input').attr('sizegram');

            sortedNames.push(names);

        });
        console.log(sortedNames);
        sortedNames.sort(function(a, b) {
            return a - b
        });
        var sortedItm = '';
        for (var j = 0; j < sortedNames.length; j++) {

            var sortedItm = sortedItm + '<li>' + $('input[sizegram=' + sortedNames[j] + ']').parent('li').html() +
                '</li>';

        }

        $('#' + ids).html(sortedItm);
    });
</script>
<script>
    const rangeInput = document.querySelectorAll(".range-input input"),
        priceInput = document.querySelectorAll(".price-input input"),
        range = document.querySelector(".slider .progress");
    let priceGap = 10;

    priceInput.forEach((input) => {
        input.addEventListener("input", (e) => {
            let minPrice = parseInt(priceInput[0].value),
                maxPrice = parseInt(priceInput[1].value);

            if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
                if (e.target.className === "input-min") {
                    rangeInput[0].value = minPrice;
                    range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
                } else {
                    rangeInput[1].value = maxPrice;
                    range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
                }
            }
        });
    });

    rangeInput.forEach((input) => {
        input.addEventListener("input", (e) => {
            let minVal = parseInt(rangeInput[0].value),
                maxVal = parseInt(rangeInput[1].value);

            if (maxVal - minVal < priceGap) {
                if (e.target.className === "range-min") {
                    rangeInput[0].value = maxVal - priceGap;
                } else {
                    rangeInput[1].value = minVal + priceGap;
                }
            } else {
                priceInput[0].value = minVal;
                priceInput[1].value = maxVal;
                range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
                range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
            }

            var productCard = document.querySelectorAll('[id^="productCard_"]');

            var maxPrice = rangeInput[1].value;
            var minPrice = rangeInput[0].value;

            productCard.forEach(element => {

                var num = $(element).attr('id').split("_")[1];
                var proPrice = Number($('.org-price_' + num).text())

                if (proPrice >= minPrice && proPrice <= maxPrice) {
                    $('#productCard_' + num).show()
                } else {
                    $('#productCard_' + num).hide()
                }

            });

        });
    });
</script>
<script>
$(document).ready(function() {
    $("#filtertoggle").click(function(e) {
        e.preventDefault();
        $(".shop-sidebar").toggleClass("active");
        $(".overlayks").toggleClass("active");
    });

    $(document).on('click', '.overlayks, .crossmark', function(e) {
        if ($('.shop-sidebar').hasClass('active')) {
            e.preventDefault();
            $(".shop-sidebar").toggleClass("active");
            $(".overlayks").toggleClass("active");
        }
    });
});
</script>