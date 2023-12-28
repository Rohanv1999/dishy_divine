<?php include 'header.php' ?>

<div id="page-content">
    <!--Home slider-->
    <section class="slideshow slideshow-wrapper">
        <div class="home-slideshow">
            <?php
            foreach ($homePage->slider() as $slider) {
                if ($slider['click'] == 'yes') {
                    $catInfo = explode("_", $slider['subcat_id']);
            ?>
                    <div class="slide">
                        <div class="blur-up lazyload">
                            <a href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&id=<?= $catInfo[0]; ?>_id@<?= $catInfo[1]; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>">
                                <img src="asset/image/banners/<?= $slider['image'] ?>" alt=""></a>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="slide">
                        <div class="blur-up lazyload">
                            <img class="blur-up lazyload desktop-hide" data-src="asset/image/banners/<?= $slider['image'] ?>" src="asset/image/banners/<?= $slider['image'] ?>" alt="HIGH CONVERTING" title="HIGH CONVERTING" />
                        </div>
                    </div>
            <?php }
            } ?>

        </div>
    </section>
    <!--End Home slider-->


  <!--Collection Slider Section-->
    <section class="section collection-slider-full pt-4 pb-4">
        <div class="container">
            <div class="section-header">
                <h2>Discover the Best Categories</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $i = 1;
                    $newArrivalCatId = $homePage->categories('');
                    if (empty($newArrivalCatId)) {
                        echo "<img  class='mx-auto my-auto d-block' src='asset/image/not-found.png' style='width: 300px;' alt=''>";
                    }
                    ?>
                </div>
            </div>

            <div class="collection-grid-slider">
                <!--<?php $allCats = $homePage->categories(''); ?>-->
                <?php
                //show New Arrival category

                foreach ($homePage->menu() as $categories) { //Fetch New Products Category
                    $catid = $categories['id'];

                ?>
                    <div class="collection-item">
                        <a href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&id=cat_id@<?= $categories['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="collection-grid-link">
                            <div class="img">
                                <img class="blur-up lazyload" data-src="asset/image/category/<?= $categories['cat_image']; ?>" src="asset/image/category/<?= $categories['cat_image']; ?>" alt="categories" />
                            </div>
                            <div class="details">
                                <h3 class="collection-item-title"><?= $categories['cat_name']; ?></h3>
                            </div>
                        </a>
                    </div>
                <?php
                } ?>
            </div>
        </div>
    </section>
    <!--Collection Slider Section-->


 

    <!--Best Seller With Tabs-->
    <section class="section product-slider tab-slider-product">
        <div class="container">
             <div class="row align-items-center mb-4">
                <div class="col-lg-4 col-12">
                    <div class="section-header text-left">
                        <h2>New Arrivals</h2>
                        <p>Browse the huge variety of our New Arrivals</p>
                    </div>
                </div>
                <div class="col-lg-8 col-12">
                <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                    <?php $allCats = $homePage->categories('new_arrivals');
                    $j = 1;
                    foreach ($allCats as $cat) {
                        $active = '';
                        if ($j == 1)
                            $active = ' active';
                        $string = preg_replace('/\s+/', '', $cat['cat_name']); // Replaces all spaces with hyphens.

                        $catSlug = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
                        $j++;
                    ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= $active ?>" id="<?= $catSlug; ?>-tab3" data-bs-toggle="pill" data-bs-target="#<?= $catSlug; ?>3" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><?= $cat['cat_name']; ?></button>
                        </li>
                    <?php } ?>
                </ul>
                </div>
            </div>
           
            <div class="tabs-listing">
                <div class="tab-content" id="pills-tabContent">
                    <?php if (empty($allCats)) {
                        echo "<img  class='mx-auto my-auto d-block' src='asset/image/not-found.png' style='width: 300px;' alt=''>";
                    } ?>
                    <!-- tab foreach  -->
                    <?php
                    $i = 1;
                    foreach ($allCats as $cat) {
                        $string = preg_replace('/\s+/', '', $cat['cat_name']); // Replaces all spaces with hyphens.

                        $catSlug = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
                        ($i == 1) ? $class = 'active show' : $class = '';
                    ?>
                        <div class="tab-pane fade show <?= $class; ?>" id="<?= $catSlug; ?>3" role="tabpanel" aria-labelledby="<?= $catSlug; ?>-tab3">
                            <div class="grid-products">
                                <div class="row">

                                    <?php
                                    // print_r($homePage->productsByCategoryAndType($categories['id'], 'new_arrivals'));die();
                                    //show New Arrival Products
                                    $i2 = 1;
                                    foreach ($homePage->productsByCategoryAndType($cat['id'], 'new_arrivals') as $product) {
                                        $issubcategory = mysqli_fetch_assoc(mysqli_query($con, "SELECT c.issubcategory FROM category c  WHERE c.id=" . $product['cat_id']))['issubcategory'];


                                        if ($issubcategory == 'Yes') {
                                            // echo "SELECT classtype_id FROM subcategory WHERE id=".$product['subcat_id'];
                                            $query1 = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM subcategory WHERE id=" . $product['subcat_id']))['classtype_id']);
                                        } elseif ($issubcategory == 'No') {
                                            $query1 = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM category WHERE id=" . $product['cat_id']))['classtype_id']);
                                        }
                                        // print_r($issubcategory);
                                        // print_r( $product['cat_id']);
                                        // die();
                                        // print_r($product['subcat_id']);
                                        // print_r($query1);
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

                                        $randamValue = rand();

                                    ?>
                                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 item">
                                          <div class="hny_products">
                                              
                                       
                                            <div class="product-image">
                                                <!-- start product image -->
                                                <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $product['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="product-img">
                                                    <!-- image -->
                                                    <?php
                                                    //show Product Image
                                                    $images = $homePage->image('product', $product['product_code']);

                                                    if ($images == "") {
                                                    ?>
                                                        <img class="primary blur-up lazyload" data-src="assets/img/product/pr-1.jpeg" src="assets/img/product/pr-1.jpeg" alt="image" title="">
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
                                                            <span class="lbl on-sale" id="modelPer<?= $randamValue . $product['id'] ?>"><?= $off; ?>% Off</span>
                                                        <?php } ?>
                                                    </div>
                                                </a>
                                                <!-- end product image -->

                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <ul>
                                                        <li>
                                                            <!--Quick View Button-->
                                                            <?php if (!$cart->productExistInCart($product['id'])) { ?>
                                                                <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $product['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" title="Quick View" class="btn-icon" >
                                                                   <i class="fa fa-solid fa-cart-shopping"></i>
                                                                    <span class="tooltip-label">Buy Now</span>
                                                                </a>
                                                            <?php } else { ?>
                                                                <a href="cart.php" title="View Cart" class="btn-icon">
                                                                    <i class="fa fa-solid fa-cart-shopping"></i>
                                                                    <span class="tooltip-label">View Cart</span>
                                                                </a>
                                                            <?php } ?>
                                                            <!--End Quick View Button-->
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                          
                                            <div class="product-details text-left">
                                                <!-- product name -->
                                                <div class="product-name">
                                                    <div class="rating">
                                                        <?php $catq = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM category WHERE id = " . $product['cat_id']));
                                                        if (!empty($catq)) {
                                                            $catName = $catq['cat_name'];
                                                        } else {
                                                            $catName = '';
                                                        } ?>
                                                        <span><?= $catName; ?></span>
                                                    </div>
                                                    <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $product['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>"><?= $product['product_name']; ?></a>
                                                </div>
                                                <!-- End product name -->
                                                <!-- product price -->
                                                <div class="product-price">
                                                    <div class="product-price" id="modelPrice<?= $randamValue . $product['id'] ?>">
                                                        <?php
                                                        $isdeal = $homePage->isDealByProduct($product['id']);
                                                        if (!empty($isdeal)) {
                                                            if ($isdeal[0]['stock'] != 0) {
                                                        ?>
                                                                <span class="price"><?= $currency; ?><?= $isdeal[0]['price']; ?></span>
                                                                <span class="old-price"><?= $currency; ?><?= $product['price']; ?></span>

                                                                <?php
                                                            } else {
                                                                if (($product['price'] == $product['discount']) || ($product['discount'] == 0)) { ?>
                                                                    <span class="price"><?= $currency; ?><?= $product['price']; ?></span>
                                                                <?php
                                                                } else { ?>
                                                                    <span class="price"><?= $currency; ?><?= $product['discount']; ?></span>
                                                                    <span class="old-price"><?= $currency; ?><?= $product['price']; ?></span>
                                                                <?php
                                                                }
                                                            }
                                                        } else {
                                                            if (($product['price'] == $product['discount']) || ($product['discount'] == 0)) { ?>
                                                                <span class="price"><?= $currency; ?><?= $product['price']; ?></span>
                                                            <?php
                                                            } else { ?>
                                                                <span class="price"><?= $currency; ?><?= $product['discount']; ?></span>
                                                                <span class="old-price"><?= $currency; ?><?= $product['price']; ?></span>

                                                        <?php
                                                            }
                                                        } ?>

                                                    </div>
                                                </div>

                                                <!-- End product price -->
                                            </div>
                                         </div>
                                        </div>
                                    <?php $i2++;
                                    } ?>
                                </div>
                            </div>
                        </div>
                    <?php $i++;
                    } ?>

                </div>
            </div>
        </div>
    </section>
    <!--End Best Seller With Tabs-->


   <!--Banner Masonary-->
    <section class="collection-banners style1 d-none d-md-block d-lg-block">
        <div class="container">
            <div class="grid-masonary banner-grid grid-mr-20">
                <div class="grid-sizer col-md-4 col-lg-4"></div>
                <div class="row">
                    <?php
                    //show Offer Image Three
                    foreach ($homePage->getOfferImage(3) as $header) {  //Fetch New Products Category 
                    ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 banner-item cl-item">
                                            <div class="collection-grid-item">
                            <?php
                            if ($header['click'] == 'yes') {
                                $catInfo = explode("_", $header['cat_id']);
                            ?>
                                <a href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&id=<?= $catInfo[0]; ?>_id@<?= $catInfo[1]; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>">
                                    <div class="img" style="position: relative; overflow: hidden;">
                                        <img class="blur-up lazyload" data-src="asset/image/offer/<?= $header['image'] ?>" src="asset/image/offer/<?= $header['image'] ?>" alt="SUMMER" title="offer-banner" width="450" height="450" />
                                        <h4 style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff;"><?= $header['text_image'] ?></h4>
                                    </div>
                                </a>
                            <?php } else { ?>
                                <div class="img" style="position: relative; overflow: hidden;">
                                <img src="asset/image/offer/<?= $header['image'] ?>" alt="offer">
                                <h4 style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff;"> <?= $header['text_image'] ?></h4>
                                </div>
                            <?php } ?>
                        </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!--End Banner Masonary-->
  
    <!--Top Picks On Fashion Product Slider-->
    <section class="section product-slider">
        <div class="container">
            <div class="row">
                <div class="section-header col-12">
                    <h2>Best Selling</h2>
                    <p>Explore an extensive array of our best-selling products!</p>
                </div>
                <?php
                $hotCatId = $homePage->productsByType1('top');
                ?>
            </div>
            <div class="productSlider grid-products">
                <?php
                //show New Arrival Products
                foreach ($homePage->productsByType1('top') as $product) {
                    $issubcategory = mysqli_fetch_assoc(mysqli_query($con, "SELECT c.issubcategory FROM category c  WHERE c.id=" . $product['cat_id']))['issubcategory'];
                    if ($issubcategory == 'Yes') {
                        // echo "SELECT classtype_id FROM subcategory WHERE id=".$product['subcat_id'];
                        $query1 = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM subcategory WHERE id=" . $product['subcat_id']))['classtype_id']);
                    } elseif ($issubcategory == 'No') {
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
                    $randamValue = rand();
                ?>
                    <div class="item hny_products">
                        <!-- start product image -->
                        <div class="product-image">
                            <!-- start product image -->
                            <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $product['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="product-img">
                                <!-- image -->
                                <?php
                                //show Product Image
                                $images = $homePage->image('product', $product['product_code']);

                                if ($images == "") {
                                ?>
                                    <img class="primary blur-up lazyload" data-src="assets/img/product/pr-1.jpeg" src="assets/img/product/pr-1.jpeg" alt="image" title="">
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
                                        <span class="lbl on-sale" id="modelPer<?= $randamValue . $product['id'] ?>"><?= $off; ?>% Off</span>
                                    <?php } ?>
                                </div>
                            </a>
                            <!-- end product image -->

                            <!--Product Button-->
                            <div class="button-set style2">
                                <ul>
                                    <li>
                                        <!--Quick View Button-->
                                        <?php if (!$cart->productExistInCart($product['id'])) { ?>
                                            <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $product['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" title="Quick View" class="btn-icon">
                                                <i class="fa fa-solid fa-cart-shopping"></i>
                                                <span class="tooltip-label">Buy Now</span>
                                            </a>
                                        <?php } else { ?>
                                            <a href="cart.php" title="View Cart" class="btn-icon" >
                                                <i class="fa fa-solid fa-cart-shopping"></i>
                                                <span class="tooltip-label">View Cart</span>
                                            </a>
                                        <?php } ?>
                                        <!--End Quick View Button-->
                                    </li>
                                </ul>
                            </div>
                            <!--End Product Button-->
                        </div>
                        <!-- end product image -->
                        <!--start product details -->
                        <div class="product-details text-left">
                            <!-- product name -->
                            <div class="product-name">
                                <div class="rating">
                                    <?php $catq = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM category WHERE id = " . $product['cat_id']));
                                    if (!empty($catq)) {
                                        $catName = $catq['cat_name'];
                                    } else {
                                        $catName = '';
                                    } ?>
                                    <span><?= $catName; ?></span>
                                </div>
                                <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $product['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>"><?= $product['product_name']; ?></a>
                            </div>
                            <!-- End product name -->
                            <!-- product price -->
                            <div class="product-price">
                                <div class="product-price" id="modelPrice<?= $randamValue . $product['id'] ?>">
                                    <?php
                                    $isdeal = $homePage->isDealByProduct($product['id']);
                                    if (!empty($isdeal)) {
                                        if ($isdeal[0]['stock'] != 0) {
                                    ?>
                                            <span class="price"><?= $currency; ?><?= $isdeal[0]['price']; ?></span>
                                            <span class="old-price"><?= $currency; ?><?= $product['price']; ?></span>

                                            <?php
                                        } else {
                                            if (($product['price'] == $product['discount']) || ($product['discount'] == 0)) { ?>
                                                <span class="price"><?= $currency; ?><?= $product['price']; ?></span>
                                            <?php
                                            } else { ?>
                                                <span class="price"><?= $currency; ?><?= $product['discount']; ?></span>
                                                <span class="old-price"><?= $currency; ?><?= $product['price']; ?></span>
                                            <?php
                                            }
                                        }
                                    } else {
                                        if (($product['price'] == $product['discount']) || ($product['discount'] == 0)) { ?>
                                            <span class="price"><?= $currency; ?><?= $product['price']; ?></span>
                                        <?php
                                        } else { ?>
                                            <span class="price"><?= $currency; ?><?= $product['discount']; ?></span>
                                            <span class="old-price"><?= $currency; ?><?= $product['price']; ?></span>

                                    <?php
                                        }
                                    } ?>

                                </div>
                            </div>

                            <!-- End product price -->
                        </div>
                        <!-- End product details -->
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!--End Top Picks On Fashion Product Slider-->
    
        <!--Parallax Banner-->
    <div class="section parallax-banner-style1 pt-0">
        <div class="hero hero--large hero__overlay bg-size bgFixed background-parallax">
            <img class="bg-img" src="assets/images/offer_bg.png" alt="image">
            <div class="hero__inner">
                <div class="container">
                    <div class="wrap-text text-left text-small font-bold m-0">
                        <h2 class="h2 mega-title">Sale offer 50% off this<br> week</h2>
                        <div class="rte-setting mega-subtitle">Free ground shipping for orders over &#8377;75.00 <br>(before sales tax) </div>
                        <div class="row">
                            <div class="col text-left"><a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $product['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="btn btn-primary w-50 m-0">Buy Now</a></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
            <!--Hot deals Product Slider-->
        <section class="section product-slider">
        <div class="container">
            <div class="row">
                <div class="section-header col-12">
                    <h2>Hot Deal</h2>
                    <p>Explore an extensive array of our best-selling products!</p>
                </div>
                <?php
                $hotCatId = $homePage->productsByType1('hot_deals');
                ?>
            </div>
            <div class="productSlider grid-products">
                <?php
                //show Hot Deal Products
                foreach ($homePage->productsByType1('hot_deals') as $product) {
                    $issubcategory = mysqli_fetch_assoc(mysqli_query($con, "SELECT c.issubcategory FROM category c  WHERE c.id=" . $product['cat_id']))['issubcategory'];
                    if ($issubcategory == 'Yes') {
                        $query1 = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM subcategory WHERE id=" . $product['subcat_id']))['classtype_id']);
                    } elseif ($issubcategory == 'No') {
                        $query1 = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM category WHERE id=" . $product['cat_id']))['classtype_id']);
                    }
                    $classtypeName = array();
                    $primaryClassName = "";
                    $classtype1 = implode(", ", $query1);
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

                    } elseif (count($query1) == 2) {
                        $primaryClassName = ucfirst($classtypeName[0]['name']);
                        if ($query1[0] == $classtypeName[0]['id']) {
                            $primaryClassName = ucfirst($classtypeName[1]['name']);
                        }
                    } elseif (count($query1) == 1 && $query1[0] != 16) {
                        $primaryClassName = ucfirst($classtypeName[0]['name']);
                    }
                    $randamValue = rand();
                ?>
                    <div class="item hny_products">
                        <!-- start product image -->
                        <div class="product-image">
                            <!-- start product image -->
                            <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $product['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" class="product-img">
                                <!-- image -->
                                <?php
                                //show Product Image
                                $images = $homePage->image('product', $product['product_code']);

                                if ($images == "") {
                                ?>
                                    <img class="primary blur-up lazyload" data-src="assets/img/product/pr-1.jpeg" src="assets/img/product/pr-1.jpeg" alt="image" title="">
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
                                        <span class="lbl on-sale" id="modelPer<?= $randamValue . $product['id'] ?>"><?= $off; ?>% Off</span>
                                    <?php } ?>
                                </div>
                            </a>
                            <!-- end product image -->

                            <!--Product Button-->
                            <div class="button-set style2">
                                <ul>
                                    <li>
                                        <!--Quick View Button-->
                                        <?php if (!$cart->productExistInCart($product['id'])) { ?>
                                            <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $product['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" title="Quick View" class="btn-icon" >
                                                <i class="fa fa-solid fa-cart-shopping"></i>
                                                <span class="tooltip-label">Buy Now</span>
                                            </a>
                                        <?php } else { ?>
                                            <a href="cart.php" title="View Cart" class="btn-icon " >
                                                <i class="fa fa-solid fa-cart-shopping"></i>
                                                <span class="tooltip-label">View Cart</span>
                                            </a>
                                        <?php } ?>
                                        <!--End Quick View Button-->
                                    </li>
                                </ul>
                            </div>
                            <!--End Product Button-->
                        </div>
                        <!-- end product image -->
                        <!--start product details -->
                        <div class="product-details text-left">
                            <!-- product name -->
                            <div class="product-name">
                                <div class="rating">
                                    <?php $catq = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM category WHERE id = " . $product['cat_id']));
                                    if (!empty($catq)) {
                                        $catName = $catq['cat_name'];
                                    } else {
                                        $catName = '';
                                    } ?>
                                    <span><?= $catName; ?></span>
                                </div>
                                <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $product['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>"><?= $product['product_name']; ?></a>
                            </div>
                            <!-- End product name -->
                            <!-- product price -->
                            <div class="product-price">
                                <div class="product-price" id="modelPrice<?= $randamValue . $product['id'] ?>">
                                    <?php
                                    $isdeal = $homePage->isDealByProduct($product['id']);
                                    if (!empty($isdeal)) {
                                        if ($isdeal[0]['stock'] != 0) {
                                    ?>
                                            <span class="price"><?= $currency; ?><?= $isdeal[0]['price']; ?></span>
                                            <span class="old-price"><?= $currency; ?><?= $product['price']; ?></span>

                                            <?php
                                        } else {
                                            if (($product['price'] == $product['discount']) || ($product['discount'] == 0)) { ?>
                                                <span class="price"><?= $currency; ?><?= $product['price']; ?></span>
                                            <?php
                                            } else { ?>
                                                <span class="price"><?= $currency; ?><?= $product['discount']; ?></span>
                                                <span class="old-price"><?= $currency; ?><?= $product['price']; ?></span>
                                            <?php
                                            }
                                        }
                                    } else {
                                        if (($product['price'] == $product['discount']) || ($product['discount'] == 0)) { ?>
                                            <span class="price"><?= $currency; ?><?= $product['price']; ?></span>
                                        <?php
                                        } else { ?>
                                            <span class="price"><?= $currency; ?><?= $product['discount']; ?></span>
                                            <span class="old-price"><?= $currency; ?><?= $product['price']; ?></span>

                                    <?php
                                        }
                                    } ?>

                                </div>
                            </div>

                            <!-- End product price -->
                        </div>
                        <!-- End product details -->
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!--End Hot deals Product Slider-->




    <!--Store Feature-->
    <section class="store-features style1 py-0">
        <div class="container">
            <div class="row">
                <div class="section-header col-12">
                    <h2>Why shop with us?</h2>
                </div>
            </div>
            <div class="row store-info">
                <div class="col mb-3 my-sm-3 text-center">
                    <i class="an an-shield rounded-circle mb-4"></i>
                    <h5 class="body-font">Products Quality</h5>
                    <p class="sub-text">Comprehensive quality control and affordable prices</p>
                </div>

                <div class="col mb-3 my-sm-3 text-center">
                    <i class="an an-ship-fast rounded-circle mb-4"></i>
                    <h5 class="body-font">Fast Shipping</h5>
                    <p class="sub-text">Fast and convenient door to door delivery</p>
                </div>
                <div class="col mb-3 my-sm-3 text-center">
                    <i class="an an-award rounded-circle mb-4"></i>
                    <h5 class="body-font">Payment Security</h5>
                    <p class="sub-text">More than 8 different secure payment methods</p>
                </div>
                <div class="col mb-3 my-sm-3 text-center">
                    <i class="an an-chat rounded-circle mb-4"></i>
                    <h5 class="body-font">Dedicated Support</h5>
                    <p class="sub-text">24/7 Customer Service - We’re here & happy to help!</p>
                </div>
            </div>
        </div>
    </section>
    <!--End Store Feature-->
</div>
<!--End Body Container-->

<?php include('includes/footer.php') ?>