<?php

require('../config.php');

//Fetch Currency
$currency = $homePage->currency();

?>
<style>
.sidebar-image img {
    width: 100px!important;
}
</style>
<div class="container-fluid-lg mobile-cnt" id="sectionhtml">
        <div class="row">
            <div class="col-xxl-9 col-xl-8 col-lg-7 wow fadeInUp">
                <div class="row g-4">
                    <div class="col-xl-6 wow fadeInUp">
                        <div class="product-left-box">
                            <div class="row g-2">
                                <div class="col-xxl-10 col-lg-12 col-md-10 order-xxl-2 order-lg-1 order-md-2">
                                    <div class="product-main-2 no-arrow">
                                        <?php
                                            $productId = $_POST['product_id'];
                                            $product = $homePage->getProductById($productId);
                                            $isdeal = $homePage->isDealByProduct($productId);

                                        $a = 1;
                                        if ($product['images'] != 0) {
                                            foreach ($product['images'] as $image) {
                                                $a++;
                                        ?>
                                                <div>
                                                    <div class="slider-image easyzoom easyzoom--overlay easyzoom--with-thumbnails" style="width: 100%;">
                                                        <a href="asset/image/product/<?= $image['image']; ?>">
                                                            <img src="asset/image/product/<?= $image['image']; ?>" class="zoom_topzoom img-fluid image_zoom_cls-<?= $a ?>" style="height: 100%;width: 100%;"/>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php }
                                        } else { ?>
                                            <img src='asset/image/product/image-not-found.jpg'>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="col-xxl-2 col-lg-12 col-md-2 order-xxl-1 order-lg-2 order-md-1">
                                    <div class="left-slider-image-2 left-slider no-arrow slick-top">
                                        <?php
                                        // echo '<pre>';
                                        // print_r($product);
                                        // exit();
                                        $a = 1;
                                        if ($product['images'] != 0) {
                                            foreach ($product['images'] as $image) {
                                                $a++;
                                        ?>
                                                <div>
                                                    <div class="sidebar-image">
                                                        <img src="asset/image/product/<?= $image['image']; ?>" class="img-fluid" alt="">
                                                    </div>
                                                </div>
                                            <?php }
                                        } else { ?>
                                            <img src='asset/image/product/image-not-found.jpg'>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <?php
                                // echo '<pre>';
                                // print_r($product);
                                // exit();
                                $a = 1;
                                if ($product['images'] != 0) {
                                    foreach ($product['images'] as $image) {
                                        $a++;
                                ?>
                                        <div class="swiper-slide">
                                            <div class="swiper-zoom-container">
                                                <img src="asset/image/product/<?= $image['image']; ?>" />
                                            </div>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <img src='asset/image/product/image-not-found.jpg'>
                                <?php } ?>

                               
                            </div>
                            <!--<div class="swiper-button-next"></div>-->
                            <!--<div class="swiper-button-prev"></div>-->
                             <div class="swiper-pagination"></div> 
                        </div>
                    </div>

                    <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.1s">
                        <?php
                        // Show product Name
                        
                        
                        $catInfo = ($product['subcat_id'] == "") ? "cat_" . $product['cat_id'] : "subcat_" . $product['subcat_id'];

                        if ($product['issubcategory'] == 'Yes') {
                            $classtype_id = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM subcategory WHERE id=" . $product['subcat_id']))['classtype_id']);
                        } elseif ($product['issubcategory'] == 'No') {
                            $classtype_id = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM category WHERE id=" . $product['cat_id']))['classtype_id']);
                        }
                        $classtypeName = array();
                        $primaryClassName = "";
                        $classtype1 = implode(", ", $classtype_id);
                        $c=0;
                        if($product['class0']!='')
                        {
                          $c++;  
                        }
                        if($product['class1']!='')
                        {
                          $c++;  
                        }
                        if($product['class2']!='')
                        {
                          $c++;  
                        }
                        if($product['class3']!='')
                        {
                          $c++;  
                        }
                        $classtypeNameQuery = mysqli_query($con, "SELECT id,name FROM classtype WHERE id IN($classtype1) GROUP BY id");
                        while ($row = mysqli_fetch_array($classtypeNameQuery)) {
                            $classtypeName[] = array('id' => $row['id'], 'name' => $row['name']);
                            $classtypeId12[] = $row['id'];
                        }

                        if (($c) == 3) {
                            $k1 = array();
                            foreach ($classtypeName as $k => $value) {

                                if ($classtype_id[0] != $value['id']) {
                                    $k1[] = $k;
                                } else {
                                    $secondId = $k;
                                }
                            }
                            $secondaryClassName = $classtypeName[$secondId]['name'];

                            $primaryClassName = ucfirst($classtypeName[$k1[0]]['name']) . '+' . ucfirst($classtypeName[$k1[1]]['name']);

                            // $class="'".$query1[1]."','".$query1[2].",";
                        } elseif ($c == 2) {

                            $secondaryClassName = $classtypeName[1]['name'];
                            $primaryClassName = $classtypeName[0]['name'];
                            if ($classtype_id[0] == $classtypeName[0]['id']) {
                                $primaryClassName = $classtypeName[1]['name'];
                                $secondaryClassName = $classtypeName[0]['name'];
                            }
                        } elseif ($c == 1 || $classtype_id[0] != 16) {
                            $primaryClassName = $classtypeName[0]['name'];
                        }


                        $colorName = "";
                        if ($c > 1)
                            $colorName = ", " . $product['class1'];
                        if ($product['class2'] != '')
                            $colorName .= ', ' . mysqli_fetch_assoc(mysqli_query($con, "SELECT symbol FROM size_class WHERE id=" . $product['class2']))['symbol'] . ', ' . mysqli_fetch_assoc(mysqli_query($con, "SELECT symbol FROM size_class WHERE id=" . $product['class0']))['symbol'];

                        ?>
                        <div class="right-box-contain">
                            <h6 class="offer-top">30% Off</h6>
                            <h2 class="name"><?= $product['product_name'] . $colorName . ", " . $homePage->getCatName($catInfo); ?></h2>
                            <div class="price-rating">
                                <h3 class="theme-color price"> <?php if (!empty($isdeal)) {
                                                                    if ($isdeal[0]['stock'] != 0) {
                                                                        $datetime1 = date('Y-m-d H:i:s');
                                                                        $datetime2 = $isdeal[0]['enddate'] . ' ' . $isdeal[0]['endtime'];

                                                                        $origin = new DateTime($datetime1);
                                                                        $target = new DateTime($datetime2);
                                                                        $interval = $origin->diff($target);

                                                                        $second = ($interval->y * 365 * 24 * 3600) + ($interval->m * 30 * 24 * 3600) + ($interval->d * 24 * 3600) + $interval->h * 3600 + $interval->i * 60 + $interval->s;

                                                                ?>
                                            <span class="old-price"><?= $currency; ?><?= $product['price']; ?></span>
                                            <span class="new-price  new_pp"><?= $currency; ?><?= $isdeal[0]['price']; ?></span>
                                            <p style="color: #ff0000; font-size: 12px; font-weight: 600; "> Hurry, Only <span style="background-color: #bb3874; color: #fff; padding: 2px 5px; margin: 0 5px;"><?= $isdeal[0]['stock']; ?> ITEMS</span> Left ! </p>
                                            <div class="deal_count">
                                                <p><span id="countdown"></span> Left for this Deal</p>
                                            </div>

                                            <?php } else {
                                                                        if (($product['price'] == $product['discount']) || ($product['discount'] == 0)) { ?>
                                                <span class="price-new new_pp"><?= $currency; ?><?= $product['price']; ?></span>
                                            <?php } else { ?>
                                                <span class="price-new new_pp"><?= $currency; ?><?= $product['discount']; ?></span>
                                                <span class="price-old"><del><?= $currency; ?><?= $product['price']; ?></span>
                                            <?php } ?>
                                        <?php }
                                                                } else {
                                                                    if (($product['price'] == $product['discount']) || ($product['discount'] == 0)) { ?>
                                            <span class="price-new new_pp"><?= $currency; ?><?= $product['price']; ?></span>
                                        <?php } else { ?>
                                            <span class="price-new new_pp"><?= $currency; ?><?= $product['discount']; ?></span>
                                            <span class="price-old"><del><?= $currency; ?><?= $product['price']; ?></span>
                                    <?php }
                                                                } ?>
                                </h3>
                                <div class="product-rating custom-rate">

                                    <span class="review">(<?= $product['totalReview']; ?> Customer Review)</span>
                                </div>
                            </div>

                            <div class="procuct-contain">
                                <p><?php if (strlen($product['description']) > 185){
                                      $str = substr($product['description'], 0, 185) . '...';
                                }
                                else{
                                    $str = $product['description'];
                                }

                                 echo $str;?>
                                </p>
                            </div>

                            <div class="product-packege">
                                <div class="product-title">
                                    <h4>CATEGORY</h4>
                                </div>
                                <ul class="select-packege">
                                    <li>
                                        <a href="javascript:void(0)"><?= $homePage->getCatName($catInfo); ?></a>
                                    </li>
                                </ul>
                            </div>
                            <form method="POST" class="addProductToCart" id="formId<?= $product['id']; ?>">
                                <input type="hidden" id="cartProductId" name="productId" value="<?= $product['id']; ?>">
                                <ul class="cart">
                                    <li>
                                        <div class="number">


                                            <!-- <input type="number" min="<?= $product['minimum']; ?>" max="<?= $product['maximum']; ?>" value="<?= $product['quantity']; ?>" class="itemQuantity" name="itemQuantity" onchange="changeItemQuantity(<?= $product['id']; ?>,this.value,<?= $product['class0']; ?>);" /> -->



                                        </div>
                                    </li>
                                    <li>
                                        <?php if (($classtype_id[0] != 16) && ($c < 3)) { ?>
                                            <div class="quantity">
                                                <?php $productSizes = $homePage->productSizes($product['group_code']); ?>
                                                <select name="productSize" onchange="setCartId(this.value);getProductById();changeurlbyclass(this.value);" class="srb-dis" required>
                                                    <option value="0" disabled>Select <?= ucfirst($primaryClassName); ?></option>
                                                    <?php
                                                   
                                                    if ($c == 2)
                                                        $sizes = $homePage->sizesByClassType($classtype_id[1]);
                                                    elseif (count($classtype_id) == 1 || $classtype_id[0] != 16)
                                                        $sizes = $homePage->sizesByClassType($classtype_id[0]);


                                                    foreach ($sizes as $size) {
                                                        if (in_array($size['id'], $productSizes)) {
                                                            $pId = $homePage->productIdByProductSize($product['group_code'], $size['id']);
                                                    ?>
                                                            <option id="productSize<?= $size['id'] ?>" value="<?= $pId; ?>" <?php if($product['class0']!=''){ if ($size['id'] == $product['class0']) {
                                                                                                                                echo 'selected';
                                                                                                                            }
                                                                                                                            }else
                                                                                                                            { if ($size['id'] == $product['class1']) {
                                                                                                                                echo 'selected';
                                                                                                                            }
                                                                                                                            }?>>
                                                                <?= $size['symbol'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    <?php

                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        <?php } elseif ($c == 3) { ?>
                                            <div class="quantity">
                                                <?php
                                                $productSizes = $homePage->productSizesByGroup($product['group_code']);
                                                ?>
                                                <select name="productSize" onchange="setCartId(this.value);getProductById();changeurlbyclass(this.value);" class="srb-dis" required>
                                                    <option value="0" disabled>Select <?= ucfirst($primaryClassName); ?></option>
                                                    <?php $sizes1 = $homePage->sizesByClassType($classtype_id[1]);
                                                    $sizes = $homePage->sizesByClassType($classtype_id[2]);

                                                    // print_r($sizes);
                                                    foreach ($sizes1 as $v) {
                                                        foreach ($sizes as $size) {
                                                            $people = array('0' => $v['id'], '1' => $size['id']);
                                                            $bFound = (count(array_intersect($productSizes, $people))) ? true : false;


                                                            $condition = 'class0=' . $v['id'] . ' AND class2=' . $size['id'];
                                                            $pId = $homePage->productIdByProductSizes($product['group_code'], $condition);
                                                            $c = '';
                                                            if (empty($pId))
                                                                $c = 'disabled style="background: #f5f5f5;color: red;"';
                                                    ?>
                                                            <option id="productSize<?= $v['id'] . '_' . $size['id'] ?>" value="<?= $pId; ?>" <?= $c; ?> <?php if (($size['id'] == $product['class2']) && ($v['id'] == $product['class0'])) {
                                                                                                                                                            echo 'selected';
                                                                                                                                                        } ?>><?= $v['symbol'] . '+' . $size['symbol'] ?></option>
                                                    <?php

                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        <?php } ?>
                                        <?php
                                        if ($c > 1) {
                                            // echo '<pre>';
                                            // print_r($homePage->getProductSizes($product['product_code']));exit();
                                            $productColors = $homePage->getProductColors($product['group_code']);
                                        ?>
                                            <div class="quantity">
                                                <select id="productColor" name="productColor" onchange="setCartId(this.value);getProductById();changeurlbyclass(this.value);">
                                                    <option value="0" disabled>Select <?= ucfirst($secondaryClassName); ?></option>
                                                    <?php
                                                    foreach ($productColors as $color) {
                                                        echo '<option value="' . $color['id'] . '"';

                                                        echo ($color['class1'] == $product['class1']) ? "selected" : "";

                                                        echo '>' . $color['class1'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        <?php } ?>
                                    </li>
                                    <li class="selectlidtl">

                                        <?php if ($product['stock'] == 'Yes') { ?>
                                            <button class="btn btn-md bg-dark cart-button text-white" type="<?= ($cart->productExistInCart($product['id'])) ? 'button' : 'submit'; ?>" id="formId<?= $productId; ?>Button">
                                                <?= ($cart->productExistInCart($product['id'])) ? 'Already Add' : 'ADD'; ?>
                                            </button>
                                        <?php } else { ?>
                                            <button type="submit" class="btn btn-md bg-dark cart-button text-white" disabled id="formId<?= $productId; ?>Button">
                                                Out Of Stock
                                            </button>
                                        <?php } ?>
                                    </li>

                                </ul>

                            </form>

                        </div>
                    </div>


                </div>
            </div>

            <div class="col-xxl-3 col-xl-4 col-lg-5 d-none d-lg-block wow fadeInUp">
                <div class="right-sidebar-box">
                    <div class="vendor-box">
                        <div class="verndor-contain">
                            <div class="vendor-image">
                                <img src="asset/image/logo/logo.png" class="img-fluid"  alt="">
                            </div>

                            <div class="vendor-name">
                                <h5 class="fw-500">Blantic Co.</h5>

                                <div class="product-rating mt-1">
                                
                                    <span>(<?= $product['totalReview']; ?> Reviews)</span>
                                </div>

                            </div>
                        </div>

                        <?php 
                        $aboutWeb= mysqli_fetch_assoc(mysqli_query($con, "SELECT aboutus FROM aboutus ORDER BY id DESC LIMIT 1"))['aboutus'];
                        ?>
                        <p><?php if (strlen($product['description']) > 185){
                                      $str = substr($product['description'], 0, 185) . '...';
                                }
                                else{
                                    $str = $product['description'];
                                }

                                 echo $str;?>
                                </p>

                        <div class="vendor-list">
                            <ul>
                                <li>
                                    <div class="address-contact">
                                        <i data-feather="map-pin"></i>
                                        <?php $webDetails = mysqli_fetch_assoc(mysqli_query($con, 'SELECT * FROM `footer`'));?>
                                        <h5>Address: <span class="text-content"><?= $webDetails['address'];?> </span></h5>
                                    </div>
                                </li>

                                <li>
                                    <div class="address-contact">
                                        <i data-feather="headphones"></i>
                                        <h5>Contact Seller: <span class="text-content"><?= $webDetails['phone'];?></span></h5>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>



                </div>
            </div>
        </div>
 
        <div class="bottom">
            <div class="product-section-box">
                <ul class="nav nav-tabs custom-nav" id="myTab-1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false">Review</button>
                    </li>
                </ul>

                <div class="tab-content custom-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <div class="product-description">
                            <div class="nav-desh">
                                <p> <?= $product['description']; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                        <div class="reviewdivstg">
                            <div class="bottom-comment" id="setReview">
                                <h2><span>(<?= $product['totalReview']; ?>) review for</span> <?= $product['product_name'] ?></h2>
                                <ul class="comments">
                                    <?php
                                    if ($product['reviews'] != '') {
                                        foreach ($product['reviews'] as $review) {
                                    ?>
                                            <li>
                                                <?php if ($review['images'] != "") { ?>
                                                    <?php foreach ($review['images'] as $image) { ?>
                                                        <img src="asset/image/review/<?= $image; ?>" alt="Blog">
                                                <?php }
                                                } ?>
                                                <h4><?= $review['firstname']; ?></h4>
                                                <span><?= $review['datentime']; ?></span>
                                                <div class="rwvcnt">
                                                    <p><?= $review['review']; ?></p>
                                                </div>
                                                <ul class="reviews">
                                                    <?php
                                                    $n = $review['star'];
                                                    if ($n != "") {
                                                        $whole = floor($n);
                                                        $fraction = $n - $whole;
                                                        for ($i = 0; $i < $whole; $i++) {
                                                    ?>
                                                            <li>
                                                                <i class="bx bxs-star checked"></i>
                                                            </li>
                                                        <?php }
                                                        if ($fraction > 0.25) { ?>
                                                            <li>
                                                                <i class="bx bxs-star"></i>
                                                            </li>
                                                    <?php }
                                                    } ?>
                                                </ul>
                                            </li>
                                    <?php }
                                    } ?>
                                </ul>
                            </div>
                            <div class="bottom-review">
                                <h3>Leave A Review</h3>
                                <form method="POST" class="addReview" id="addReview">
                                    <input type="hidden" name="productId" id="reviewProductId" value="<?= $product['id']; ?>">
                                    <input type="hidden" name="url" id="pageUrl" value="<?= $url; ?>">
                                    <p class="comment-notes">
                                        <span id="email-notes">Your email address will not be published.</span>
                                        Required fields are marked
                                        <span class="required">*</span>
                                    </p>
                                    <div class="form-group">
                                        <div class="comment-form-rating">
                                            <div class="star" style="float:left">
                                                <input class="star star-5" id="star-5" type="radio" name="starRating" />
                                                <label class="star star-5" for="star-5"></label>
                                                <input class="star star-4" id="star-4" type="radio" name="starRating" />
                                                <label class="star star-4" for="star-4"></label>
                                                <input class="star star-3" id="star-3" type="radio" name="starRating" />
                                                <label class="star star-3" for="star-3"></label>
                                                <input class="star star-2" id="star-2" type="radio" name="starRating" />
                                                <label class="star star-2" for="star-2"></label>
                                                <input class="star star-1" id="star-1" type="radio" name="starRating" />
                                                <label class="star star-1" for="star-1"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <textarea name="comment" id="review_comment" rows="4" class="form-control" placeholder="Comments"></textarea>
                                    </div>
                                    <button type="submit" <?php if (!USER::isLoggedIn()) { ?> <?php } ?> class="btn common-btn">
                                        Submit Review

                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    var swiper = new Swiper(".mySwiper", {
      zoom: true,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });

    alert('hi');

  </script>