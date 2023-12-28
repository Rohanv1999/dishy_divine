<?php include("config.php");
ini_set('display_errors', 0);
ini_set('log_errors', 0);
error_reporting(E_ALL);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https://";
else
    $url = "http://";
// Append the host(domain name, ip) to the URL.   
$url .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL   
$url .= $_SERVER['REQUEST_URI'];

//$currentPage=explode('?',explode(BASE_URL,$url)[1])[0];
$currentPage = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);


if (isset($_SESSION['filter']['checked']['cat'])) {
    foreach ($_SESSION['filter']['checked']['cat'] as $key => $item) {
        if (false !== strrpos($item, 'p.subcat_id')) {

            unset($_SESSION['filter']['checked']['cat'][$key]);
            unset($_SESSION['filter']['checked']['class0']);
            unset($_SESSION['filter']['checked']['class1']);
            unset($_SESSION['filter']['checked']['class2']);
            unset($_SESSION['filter']['checked']['brand']);
            unset($_SESSION['filter']['max']);
            unset($_SESSION['filter']['min']);
            unset($_SESSION['classtype_id']);
        }
    }
    foreach ($_SESSION['filter']['checked']['cat'] as $key => $item) {
        if (false !== strrpos($item, 'p.cat_id')) {
            unset($_SESSION['filter']['checked']['cat'][$key]);
            unset($_SESSION['filter']['checked']['class0']);
            unset($_SESSION['filter']['checked']['class1']);
            unset($_SESSION['filter']['checked']['class2']);
            unset($_SESSION['filter']['checked']['brand']);
            unset($_SESSION['filter']['max']);
            unset($_SESSION['filter']['min']);
            unset($_SESSION['classtype_id']);
        }
    }
}

//Fetch Currency
$currency = $homePage->currency();

// unset($_SESSION['filter']);
// unset($_SESSION['classtype_id']);

// session_destroy();
// echo "<pre>";
// print_r($_SESSION);
?>
<!doctype html>
<html lang="en">

<head>
    <!--Required Meta Tags-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="description">
    <?php
    // For meta Content


    if ($currentPage == 'about.php' || $currentPage == 'contact.php') {
        $page = explode('.php', $currentPage)[0];
        $pid = "No";
    } elseif ($currentPage == 'product-detail.php') {
        $page = explode('.php', $currentPage)[0];
        $pid = $_GET['product_id'];
    } else {

        $page = "index";
        $pid = "No";
    }
    $meta = $homePage->meta($page, $pid);

    if (!empty($meta)) { ?>
        <title><?php if (!empty($meta['title'])) echo $meta['title'];
                else "Dishy Divine"; ?></title>
    <?php
    } else {
    ?>
        <title>Dishy Divine : Best Place for Crookery Products</title>

    <?php
    } ?>
    <?php if (!empty($meta)) {
    ?>

        <?php
        if (!empty($meta['metaTags'])) {
            foreach ($meta['metaTags'] as $desc) { ?>
                <meta name="description" content="<?= $desc['meta'] ?>">
        <?php
            }
        } ?>
        <?php
        if (!empty($meta['metaKeys'])) {
            foreach ($meta['metaKeys'] as $key) { ?>
                <meta name="keywords" content="<?= $key['keyword'] ?>">
    <?php
            }
        }
    }
    //End Seo Content
    ?>
    <?php
    //Show Fav Icon
    $favIcon = $homePage->favIcon();
    ?>
    <link rel="shortcut icon" href="asset/image/favIcon/<?= $favIcon; ?>" />
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/css/plugins.css" />
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/responsive.css" />
    <link rel="stylesheet" href="assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .SWLoader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: auto;
            margin-top: 20px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="template-index index-demo2 modal-popup-style">
    <!-- Page Loader -->
    <div id="pre-loader"><img src="assets/images/loader.gif" alt="Loading..." /></div>
    <!-- End Page Loader -->

    <!--Page Wrapper-->
    <div class="page-wrapper">
        <!--Header-->
        <div class="top-info-bar">
            <div class="container">
                <div class="row topBar-slider">
                    <div class="item d-flex flex-row justify-content-lg-start justify-content-center justify-content-md-center justify-content-sm-center col-12 col-sm-6 col-md-4 col-lg-4 text-uppercase">
                        <a href="javascript:;">Cash On Delivery Available</a>
                    </div>
                    <div class="item d-flex flex-row justify-content-center justify-content-md-center justify-content-sm-center col-12 col-sm-6 col-md-4 col-lg-4 text-uppercase center">
                        <marquee style="color: wheat;">Free Shipping On Order Over &#8377;100</marquee>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 text-uppercase">
                        <div class="header-right">

                            <?php
                            // Show social media
                            $social = $homePage->socialMedia();
                            if (!empty($social)) {
                                foreach ($social as $value) {
                            ?>
                                    <a href="<?= $value['url'] ?>" class="help d-lg-show" title="<?= $value['name'] ?>" target="_blank"><i class="<?= $value['icon'] ?>"></i></a>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <header id="header" class="header header-main d-flex align-items-center header-2">
            <div class="container">
                <div class="row">
                    <!--Logo / Menu Toggle-->
                    <div class="col-6 col-sm-6 col-md-6 col-lg-3 align-self-center justify-content-start d-flex">
                        <!--Mobile Toggle-->
                        <button type="button" class="btn--link site-header__menu js-mobile-nav-toggle mobile-nav--open me-3"><i class="fa fa-bars"></i><i class="icon an an-bars-l"></i></button>
                        <!--End Mobile Toggle-->
                         <?php
                        //show logo
                        $logo = $homePage->logo();
                        ?>
                        <div class="logo hny_mobile"><a href="index.php"><img class="logo-img mh-100" src="asset/image/logo/<?= $logo['logo'] ?>" alt="dishy divine" width="140" /></a></div>
                        <!--End Desktop Menu-->
                    </div>
                    <!--End Logo / Menu Toggle-->
                    <!--Main Navigation Desktop-->
                    <div class="col-1 col-sm-1 col-md-1 col-lg-6 align-self-center d-menu-col">
                        <!--Desktop Menu-->
                        <!-- <div class="row">
                            <div class="col-1 col-sm-12 col-md-12 col-lg-12 align-self-center d-menu-col">
                              
                                <nav class="grid__item" id="AccessibleNav">
                                    <ul id="siteNav" class="site-nav medium center hidearrow">
                                        <li><a href="index.php">Home</a></li>
                                        <?php
                                        foreach ($homePage->menu() as $mainMenu) {
                                            if ($mainMenu['subMenu'] == 0) {
                                        ?>
                                                <li><a href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&<?= $mainMenu['condition']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>"><?= $mainMenu['cat_name']; ?></a></li>
                                            <?php } else { ?>
                                                <li class="lvl1 parent dropdown">
                                                    <a for="sub-<?= $mainMenu['id']; ?> href=" listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&<?= $mainMenu['condition']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>"><?= $mainMenu['cat_name']; ?> <i class="an an-angle-down-l"></i></a>
                                                    <ul class="dropdown">
                                                        <?php foreach ($mainMenu['subMenu'] as $subMenu) { ?>
                                                            <li><a href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&id=subcat_id@<?= $subMenu['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="site-nav"><?= $subMenu['sub_cat_name']; ?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                        <?php }
                                        } ?>
                                    </ul>
                                </nav>
                               
                            </div>
                        </div> -->
                        <?php
                        //show logo
                        $logo = $homePage->logo();
                        ?>
                        <div class="logo"><a href="index.php"><img class="logo-img mh-100" src="asset/image/logo/<?= $logo['logo'] ?>" alt="dishy divine" width="140" /></a></div>
                        <!--End Desktop Menu-->
                    </div>
                    <!--End Main Navigation Desktop-->
                    <!--Right Action-->
                    <div class="col-6 col-sm-6 col-md-6 col-lg-3 align-self-center icons-col text-right d-flex justify-content-end">
                        <!--Search-->
                        <div class="site-search iconset"><i class="icon an an-search-l"></i><span class="tooltip-label">Search</span></div>
                        <!--End Search-->
                        <!--Wishlist-->
                        <div class="wishlist-link iconset">
                            <?php
                            if (USER::isLoggedIn()) {
                                $wishListUrl = 'wishlist.php';
                                $onClickFunction = '';
                            } else {
                                $wishListUrl = 'javascript:void(0);';
                                $onClickFunction = 'onClick="userNotLoginAlert()"';
                            }
                            ?>
                            <a href="<?= $wishListUrl ?? '' ?>" <?= $onClickFunction ?>><i class="icon an an-heart-l"></i><span class="tooltip-label">Wishlist</span></a>
                        </div>
                        <!--End Wishlist-->
                        <!--Setting Dropdown-->
                        <div class="user-link iconset">
                            <?php if (USER::isLoggedIn()) { ?>
                                <a href="dashboard.php"> <i class="icon an an-user-2"></i><span class="tooltip-label"><?= $user->headerUser(); ?></span></a>
                            <?php } else { ?>
                                <a href="account.php"><i class="icon an an-user-2"></i><span class="tooltip-label">Account</span></a>
                            <?php } ?>
                        </div>

                        <!--End Setting Dropdown-->
                        <!--Minicart Drawer-->
                        <div class="header-cart iconset">
                            <a href="#" class="site-header__cart btn-minicart" id="cart" data-bs-toggle="modal" data-bs-target="#minicart-drawer">
                                <i class="icon an an-cart-l"></i><span id="cartCount" class="cart-count cart-total cart-add site-cart-count counter d-flex-center justify-content-center position-absolute translate-middle rounded-circle"><?= $cart->totalItemInCart(); ?></span><span class="tooltip-label">Cart</span>
                            </a>
                        </div>


                    </div>
                    <!--End Right Action-->
                    <!--MiniCart Drawer-->
                    <div class="minicart-right-drawer modal right fade" id="minicart-drawer">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!--MiniCart Empty-->
                                <div id="cartEmpty" class="cartEmpty d-flex-justify-center flex-column text-center p-3 text-muted shadow d-none">
                                    <div class="minicart-header d-flex-center justify-content-between w-100">
                                        <h4 class="fs-6 text-transform-none text-black">Shopping Cart</h4>
                                        <a href="javascript:void(0);" class="close-cart" data-bs-dismiss="modal" aria-label="Close"><i class="an an-times-r" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="left" title="Close"></i></a>
                                    </div>
                                </div>
                                <!--End MiniCart Empty-->

                                <!--MiniCart Content-->
                                <div id="cart-drawer" class="block block-cart">
                                    <div class="minicart-header">
                                        <a href="javascript:void(0);" class="close-cart" data-bs-dismiss="modal" aria-label="Close"><i class="an an-times-r" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="left" title="Close"></i></a>
                                        <h4 class="fs-6 text-transform-none text-black">Shopping Cart</h4>
                                    </div>
                                    <div class="minicart-content" id="headerCart">
                                        <div class="row" id="cartDiv">
                                            <div class="col-lg-8">
                                                <div class="products scrollable">
                                                    <?php
                                                    $items = $cart->cartDetail();
                                                    //print_r($items);
                                                    // exit();
                                                    if (isset($items['cartEmpty'])) { ?>
                                                        <div class="cart-list">
                                                            <div class="cart-content" style="color:#000;">
                                                                <div class="no-blog">
                                                                    <img src="assets/images/empty_cart.jpg" width="" alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php  } else { ?>
                                                        <div class="cart-list">
                                                            <?php foreach ($items as $item) {
                                                                if (array_key_exists('product_name', $item)) { ?>

                                                                    <li class="cart-item product product-cart">

                                                                        <div class="cart-media ">
                                                                            <figure class="product-media m-0">
                                                                                <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $item['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>">
                                                                                    <img src="asset/image/product/<?= $item['image']; ?>" alt="product" width="70px">
                                                                                </a>
                                                                            </figure>
                                                                        </div>
                                                                        <div class="cart-info-group">
                                                                            <div class="cart-info">

                                                                                <div class="product-detail">
                                                                                    <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $item['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="product-name"><?= $item['product_name']; ?></a>
                                                                                </div>
                                                                                <?php
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
                                                                                ?>
                                                                                <p class="mb-1">Unit Price - <?= $currency; ?> <?= $price; ?></p>
                                                                                <div class="cart-action-group">
                                                                                    <h6 class="mb-0">
                                                                                        <?php
                                                                                        $totalcrt = $price * $item['quantity'];
                                                                                        ?>
                                                                                        <?= $currency; ?> <?= $totalcrt; ?>
                                                                                    </h6>
                                                                                    <div class="product-action">
                                                                                        <button class="action-minus qty" title="Quantity Minus">
                                                                                            Qty.
                                                                                        </button>

                                                                                        <div class="input-group hny-crt">
                                                                                            <button onclick="decreaseQuantity(this)" class="quantity-minus icon an an-minus-r"></button>
                                                                                            <input class="action-input itemQuantity" title="Quantity Number" type="number" min="<?= $item['minimum']; ?>" max="<?= $item['maximum']; ?>" value="<?= $item['quantity']; ?>" name="itemQuantity" onchange="changeItemQuantity(<?= $item['id']; ?>,this.value,<?= $item['class0']; ?>);">
                                                                                            <button onclick="increaseQuantity(this)" class="quantity-plus icon an an-plus-l"></button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>

                                                            <?php }
                                                            } ?>

                                                        </div>
                                                    <?php } ?>


                                                </div>
                                            </div>




                                            <div class="col-lg-4">
                                                <div class="cart-action p-0 minicart-bottom text-black">
                                                    <div class="shipinfo text-center mb-3 text-uppercase">
                                                        <p class="freeShipMsg"><b>CartEase:</b> Your Ultimate Shopping Companion</p>
                                                    </div>
                                                    <div class="subtotal">
                                                        <span>Total:</span>
                                                        <span class="product-price"><strong class="cartttl"><?= $currency; ?><?= $cart->cartSubTotalAmount(); ?></strong></span>
                                                    </div>

                                                    <?php
                                                    if (isset($items['cartEmpty'])) {
                                                    ?>
                                                        <a href="index.php" class="btn btn-dark w-100"><span>Shop Now</span></a>
                                                    <?php } else { ?>
                                                        <a class="cart-checkout-btn gocheckout btn btn-dark w-100" onclick="checkStock()"><span class="checkout-label">Checkout</span></a>

                                                        <button style="display: none;" type="button" id="productModal" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"> Demo modal</button>


                                                    <?php } ?>

                                                    <a href="cart.php" class="btn btn-primary btn-rounded btn-md mt-3 w-100"><i class="d-icon-bag"></i> View Cart</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!--End MiniCart Content-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Search Popup-->
            <div id="search-popup" class="search-drawer">
                <div class="container">
                    <span class="closeSearch an an-times-l"></span>
                    <form class="form minisearch" id="header-search" action="#" method="get">
                        <label class="label"><span>Search</span></label>
                        <div class="control">
                            <div class="searchField">
                                <form action="javascript:;" class="input-box search-bar productSearch2" method="get">
                                    <button type="submit" title="Search" class="action search" disabled=""><i class="icon an an-search-l"></i></button>
                                    <input type="text" class="input-text search-type" id="search" utocomplete="off" name="search" onfocusout="hidesearchdiv()" placeholder="Search by keyword or #">
                                    <input type="hidden" name="route" value="product/search" />
                                    <div id="autocomplete" class="mysrcdiv" onmouseleave="hidesearchdiva()" onmouseleave="hidesearchdiv()"></div>
                                </form>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--End Search Popup-->
        </header>
        <!--End Header-->
        <!--Mobile Menu-->
        <div class="mobile-nav-wrapper" role="navigation">
            <div class="closemobileMenu"><i class="icon an an-times-l pull-right"></i> Close Menu</div>
            <ul id="MobileNav" class="mobile-nav">
                <li><a href="index.php">Home</a></li>

                <?php
                foreach ($homePage->menu() as $mainMenu) {
                    if ($mainMenu['subMenu'] == 0) {
                ?>
                        <li><a href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&<?= $mainMenu['condition']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>"><?= $mainMenu['cat_name']; ?></a></li>
                    <?php } else { ?>
                        <li class="lvl1 parent megamenu"><a for="sub-<?= $mainMenu['id']; ?>" href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&<?= $mainMenu['condition']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>"><?= $mainMenu['cat_name']; ?> <i class="an an-plus-l"></i></a>
                            <ul>
                                <?php foreach ($mainMenu['subMenu'] as $subMenu) { ?>
                                    <li><a href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&id=subcat_id@<?= $subMenu['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="site-nav"><?= $subMenu['sub_cat_name']; ?> </a> </li>
                                <?php } ?>
                            </ul>
                        </li>
                <?php }
                } ?>


                <li class="help bottom-link">NEED HELP?<a href="tel:<?= $homePage->contactInfo('phone'); ?>"></a>Call: <?= $homePage->contactInfo('phone'); ?></li>
            </ul>
        </div>
        <!--End Mobile Menu-->