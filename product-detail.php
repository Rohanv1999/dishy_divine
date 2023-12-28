<?php
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https://";
else
    $url = "http://";
// Append the host(domain name, ip) to the URL.   
$url .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL   
$url .= $_SERVER['REQUEST_URI'];

// echo $url;
// exit();
include('header.php');

//Show Product Details
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
    $product = $homePage->getProductById($productId);
    $isdeal = $homePage->isDealByProduct($productId);
    // echo '<pre>';
} else {
?>
    <script type="text/javascript">
        window.location.href = "index.php";
    </script>
<?php
}
?>
<style>
    span.new-price {
        margin-bottom: 1.1rem;
        color: #d26e4b;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.025em;
        line-height: 2;
    }

    span.old-price {
        color: #999;
        padding-left: 5px;
        font-weight: 300;
        text-decoration: line-through;
    }

    .pro_discrptio {
        height: auto;
        overflow-y: auto;
        max-height: 150px;
    }

    .single-product-quantity {
        padding-top: 20px;
    }

    .pro_discrptio ul {
        padding-left: 0px !important;
    }

    .product-comment-content p {
        margin-bottom: 0px;
    }

    .product-comment {
        border-top: 1px solid;
    }

    .comment-rating.ratings-container i {
        color: #e03027;
    }

    .comment figure {
        margin-top: 16px;
    }

    span.comment-reply-title {
        font-size: 20px;
        text-transform: capitalize;
        font-weight: 800;
    }

    p.comment-notes {
        margin-bottom: 0px;
    }

    .ratings-container i {
        color: #e03027;
    }

    .swiper {
        width: 100%;
        height: 300px;
        margin-left: auto;
        margin-right: auto;
    }

    .swiper-slide {
        background-size: cover;
        background-position: center;
    }

    .mySwiper2 {
        height: 80%;
        width: 100%;
    }

    .mySwiper {
        height: 20%;
        box-sizing: border-box;
        padding: 10px 0;
    }

    .mySwiper .swiper-slide {
        width: 25%;
        height: 100%;
        opacity: 0.4;
    }

    .mySwiper .swiper-slide-thumb-active {
        opacity: 1;
    }

    .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
<main class="main mt-6 single-product" id="page-content">
  
    <div class="page-content mt-4 mb-10 pb-6">
        <div class="container">
            <div class="product product-single row mb-2">
                <div class="col-md-6 ">
                    <div class="products-image">
                        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                            <div class="swiper-wrapper">
                                <?php
                                // echo '<pre>';
                                // print_r($product);
                                // exit();
                                $a = 1;

                                if ($product['images'] != 0) {
                                    // print_r($product['images']);
                                    foreach ($product['images'] as $image) {
                                        $a++;
                                ?>
                                        <div class="swiper-slide">
                                            <img src="asset/image/product/<?= $image['image']; ?>" />
                                        </div>
                                    <?php }
                                } else { ?>
                                    <figure class="product-image classfig">
                                        <img src="asset/image/logo/logo-square.png" alt="product image" width="800" height="900" style="background-color: #f2f3f5;" />
                                    </figure>
                                <?php } ?>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        <div thumbsSlider="" class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <?php
                                //SHow Single image
                                if ($product['images'] != 0) {
                                    foreach ($product['images'] as $image) {
                                ?>
                                        <div class="swiper-slide">
                                            <img src="asset/image/product/<?= $image['image']; ?>" />
                                        </div>
                                    <?php }
                                } else { ?>
                                    <div><img class="product-thumb active" src="asset/image/logo/logo-square.png" alt="product image" width="109" height="122" style="background-color: #f2f3f5;" /></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="product-details">
                        <?php
                        // Show product Name
                        $catInfo = ($product['subcat_id'] == "") ? "cat_" . $product['cat_id'] : "subcat_" . $product['subcat_id'];

                        if ($product['issubcategory'] == 'Yes' && $product['subcat_id'] != '') {
                            $classtype_id = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM subcategory WHERE id=" . $product['subcat_id']))['classtype_id']);
                        } else {
                            $classtype_id = json_decode(mysqli_fetch_assoc(mysqli_query($con, "SELECT classtype_id FROM category WHERE id=" . $product['cat_id']))['classtype_id']);
                        }
                        $classtypeName = array();
                        $primaryClassName = "";
                        $classtype1 = implode(", ", $classtype_id);
                        $classtypeNameQuery = mysqli_query($con, "SELECT id,name FROM classtype WHERE id IN($classtype1) GROUP BY id");
                        while ($row = mysqli_fetch_array($classtypeNameQuery)) {
                            $classtypeName[] = array('id' => $row['id'], 'name' => $row['name']);
                            $classtypeId12[] = $row['id'];
                        }

                        if ((count($classtype_id)) == 3) {
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
                        } elseif (count($classtype_id) == 2) {

                            $secondaryClassName = $classtypeName[1]['name'];
                            $primaryClassName = $classtypeName[0]['name'];
                            if ($classtype_id[0] == $classtypeName[0]['id']) {
                                $primaryClassName = $classtypeName[1]['name'];
                                $secondaryClassName = $classtypeName[0]['name'];
                            }
                        } elseif (count($classtype_id) == 1 || $classtype_id[0] != 16) {
                            $primaryClassName = $classtypeName[0]['name'];
                        }


                        $colorName = "";
                        if (count($classtype_id) > 1)
                            $colorName = ", " . $product['class1'];
                        if ($product['class2'] != '')
                            $colorName .= ', ' . mysqli_fetch_assoc(mysqli_query($con, "SELECT symbol FROM size_class WHERE id=" . $product['class2']))['symbol'] . ', ' . mysqli_fetch_assoc(mysqli_query($con, "SELECT symbol FROM size_class WHERE id=" . $product['class0']))['symbol'];

                        ?>
                        <div class="product-navigation">
                            <ul class="breadcrumb breadcrumb-lg">
                                <li><a href="index.php"><i class="fa fa-home"></i></a></li>
                                <li><a href="javascript:void(0)" class="active">Products</a></li>

                            </ul>
                        </div>
                        <h1 class="product-name"><?= $product['product_name'] . $colorName ?></h1>
                        <div class="product-meta">
                            Category: <span class="product-sku"><?= $homePage->getCatName($catInfo); ?></span>

                        </div>
                        <div class="product-price">

                            <?php if (!empty($isdeal)) {
                                if ($isdeal[0]['stock'] != 0) {
                                    $datetime1 = date('Y-m-d H:i:s');
                                    $datetime2 = $isdeal[0]['enddate'] . ' ' . $isdeal[0]['endtime'];

                                    $origin = new DateTime($datetime1);
                                    $target = new DateTime($datetime2);
                                    $interval = $origin->diff($target);

                                    $second = ($interval->y * 365 * 24 * 3600) + ($interval->m * 30 * 24 * 3600) + ($interval->d * 24 * 3600) + $interval->h * 3600 + $interval->i * 60 + $interval->s;

                            ?>


                                    <span class="old-price"><?= $currency; ?><?= $product['price']; ?></span>
                                    <span class="new-price"><?= $currency; ?><?= $isdeal[0]['price']; ?></span>
                                    <p style="color: #ff0000; font-size: 12px; font-weight: 600; "> Hurry, Only <span style="background-color: #bb3874; color: #fff; padding: 2px 5px; margin: 0 5px;"><?= $isdeal[0]['stock']; ?> ITEMS</span> Left ! </p>
                                    <div class="deal_count">
                                        <p><span id="countdown"></span> Left for this Deal</p>
                                    </div>


                                    <?php
                                } else {
                                    if (($product['price'] == $product['discount']) || ($product['discount'] == 0)) { ?>
                                        <span class="new-price"><?= $currency; ?><?= $product['price']; ?></span>
                                    <?php
                                    } else { ?>
                                        <span class="new-price"><?= $currency; ?><?= $product['discount']; ?></span>
                                        <span class="old-price"><?= $currency; ?><?= $product['price']; ?></span>

                                    <?php
                                    } ?>

                                <?php
                                }
                            } else {
                                if (($product['price'] == $product['discount']) || ($product['discount'] == 0)) { ?>
                                    <span class="new-price"><?= $currency; ?><?= $product['price']; ?></span>
                                <?php
                                } else { ?>
                                    <span class="new-price"><?= $currency; ?><?= $product['discount']; ?></span>
                                    <span class="old-price"><?= $currency; ?><?= $product['price']; ?></span>


                                <?php
                                } ?>

                            <?php
                            } ?>

                        </div>
                        <div class="ratings-container">
                            <!--<div class="ratings-full">-->
                            <!--    <span class="ratings" style="width:80%"></span>-->
                            <!--    <span class="tooltiptext tooltip-top"></span>-->
                            <!--</div>-->
                            <?php
                            $n = $product['avg_rating'];
                            $whole = floor($n);
                            $fraction = $n - $whole;

                            for ($i = 0; $i < $whole; $i++) {
                            ?>
                                <i class="fa fa-star"></i>
                            <?php
                            }
                            if ($fraction > 0.25) {
                            ?>
                                <i class="fa fa-star on-color"></i>
                            <?php
                            }
                            ?>
                            <a class="link-to-tab rating-reviews" id="showReview">( <?= $product['totalReview']; ?> reviews )</a>
                        </div>
                        <div class="pro_discrptio">
                            <p class="product-short-desc"><?= $product['description']; ?></p>
                        </div>
                        <!-- <div class="product-form product-qty">
                            <div class="product-form-group">
                                <a href="" class="btn-product btn-cartt text-normal ls-normal font-weight-semi-bold"><i class="d-icon-bag mr-2"></i>Buy Now</a>
                            </div>
                        </div> -->
                        <form method="POST" class="addProductToCart" id="formId<?= $product['id']; ?>">

                            <input type="hidden" name="currentPage" value="<?= $currentPage; ?>">

                            <input type="hidden" id="cartProductId" name="productId" value="<?= $product['id']; ?>">

                            <div class="single-product-quantity">

                                <?php
                                if (count($classtype_id) > 1) {

                                    // echo '<pre>';

                                    // print_r($homePage->getProductSizes($product['product_code']));exit();


                                    $productColors = $homePage->getProductColors($product['group_code']);


                                ?>
                                    <div class="quantity3">
                                        <label class="newss"><?= ucfirst($secondaryClassName) ?></label>
                                        <select id="productColor" name="productColor" onchange="setCartId(this.value);getProductById();changeurlbyclass(this.value);">
                                            <option value="0" disabled>Select <?= ucfirst($secondaryClassName); ?></option>
                                            <?php
                                            foreach ($productColors as $color) {
                                                echo '<option value="' . $color['id'] . '"';

                                                if ($color['class1'] == $product['class1']) {
                                                    echo "selected";
                                                    $spclass = $color['class1'];
                                                }
                                                echo '>' . $color['class1'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                <?php
                                }

                                // echo 'cid is ';
                                // print_r($classtype_id);
                                if (($classtype_id[0] != 16) && (count($classtype_id) < 3)) { ?>
                                    <div class="quantity3">
                                        <label><?= ucfirst($primaryClassName); ?></label>
                                        <?php

                                        $productSizes = $homePage->productSizesByGroup($product['group_code']);

                                        ?>
                                        <select name="productSize" onchange="setCartId(this.value);getProductById();" class="srb-dis" required>
                                            <option value="0" disabled>Select <?= ucfirst($primaryClassName); ?></option>
                                            <?php
                                            if (count($classtype_id) == 2)
                                                $sizes = $homePage->sizesByClassType($classtype_id[1]);
                                            elseif (count($classtype_id) == 1 || $classtype_id[0] != 16)
                                                $sizes = $homePage->sizesByClassType($classtype_id[0]);

                                            // print_r($sizes);

                                            foreach ($sizes as $size) {
                                                if (count($classtype_id) > 1) {
                                                    echo $productsSizes = $homePage->productsSizesByGroup($product['group_code'], $size['id'], $spclass);

                                                    if (in_array($size['id'], $productSizes) && $spclass == $productsSizes) {
                                                        $pId = $homePage->productIdsByProductSize($product['group_code'], $size['id'], $spclass);
                                            ?>
                                                        <option id="productSize<?= $size['id'] ?>" value="<?= $pId; ?>" <?php
                                                                                                                        if ($size['id'] == $product['class0']) {
                                                                                                                            $spid = $pId;
                                                                                                                            echo 'selected';
                                                                                                                        } ?>>
                                                            <?= $size['symbol'] ?></option>
                                                    <?php
                                                    } else {
                                                    ?>
                                                    <?php
                                                    }
                                                } else {
                                                    if (in_array($size['id'], $productSizes)) {
                                                        $pId = $homePage->productIdByProductSize($product['group_code'], $size['id']);
                                                    ?>
                                                        <option id="productSize<?= $size['id'] ?>" value="<?= $pId; ?>" <?php
                                                                                                                        if ($size['id'] == $product['class0']) {
                                                                                                                            $spid = $pId;
                                                                                                                            echo 'selected';
                                                                                                                        } ?>>
                                                            <?= $size['symbol'] ?></option>
                                                    <?php
                                                    } else {
                                                    ?>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            <?php

                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php
                                } elseif (count($classtype_id) == 3) {
                                ?>
                                    <div class="quantity3">
                                        <label><?= ucfirst($primaryClassName); ?></label>
                                        <?php

                                        $productSizes = $homePage->productSizesByGroup($product['group_code']);
                                        ?>
                                        <select name="productSize" onchange="setCartId(this.value);getProductById();" class="srb-dis" required>
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
                                <?php
                                } ?>
                                <?php
                                $randamValue = rand();
                                if ($cart->productExistInCart($product['id'])) { ?>
                                    <div class="btnDiv<?= $productId; ?> mt-3">
                                        <a href="cart.php" class="quantity-button btn btn-cart2" type="button" id="formId<?= $productId; ?>Button"><span>Go To Cart</span></a>

                                        <button type="button" class="quantity-button btn btn-cart2" onclick="removeFromCart(<?= $product['id']; ?>,'addToCart<?= $randamValue . $product['id'] ?>','<?= $primaryClassName; ?>')"><i class="fa fa-trash"></i></button>
                                    </div>
                                    <?php } else {
                                    if ($product['stock'] == 'Yes' && ($product['minimum'] <= $product['in_stock'])) {
                                    ?>
                                        <div class="btnDiv<?= $productId; ?> mt-3">
                                            <button class="quantity-button btn btn-cart2" type="submit" id="formId<?= $productId; ?>Button"><span>Add To Cart</span></button>

                                        </div>

                                    <?php
                                    } else {
                                    ?>

                                        <button class="quantity-button btn btn-cart2" type="button" id="formId<?= $productId; ?>Button"><span>Out Of Stock</span></button>

                                    <?php
                                    }
                                    ?>
                                <?php } ?>



                            </div>
                        </form>
                        <div class="wislist-compare-btn">

                        </div>
                        <hr class="product-divider mb-3">
                        <!--                        <select class="form-select" aria-label="Default select example">-->
                        <!--  <option selected>Open this select menu</option>-->
                        <!--  <option value="1">One</option>-->
                        <!--  <option value="2">Two</option>-->
                        <!--  <option value="3">Three</option>-->
                        <!--</select>-->
                    </div>
                </div>
            </div>
            <!--Product Tabs-->
            <div class="tabs-listing mt-2 mt-md-5">
                <ul class="product-tabs list-unstyled d-flex-wrap border-bottom m-0 d-none d-md-flex">
                    <li rel="description" class="active"><a class="tablink">Description</a></li>
                    <li rel="reviews"><a class="tablink">Reviews</a></li>
                </ul>
                <div class="tab-container">
                    <h3 class="tabs-ac-style d-md-none active" rel="description">Description</h3>
                    <div id="description" class="tab-content">
                        <div class="product-description">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-8 col-lg-8 mb-4 mb-md-0">
                                    <p> <?= $product['description']; ?></p>

                                </div>

                            </div>
                        </div>
                    </div>



                    <h3 class="tabs-ac-style d-md-none" rel="reviews">Review</h3>
                    <div id="reviews" class="tab-content">
                        <div class="row" id="setReview">
                            <div class="col-md-12">
                                <div class="review-page-comment">
                                    <div class="review-comment">
                                        <h5 class="description-title mb-3 font-weight-semi-bold ls-m">(<?= $product['totalReview']; ?>) review <br> <?= $product['product_name'] ?></h5>


                                        <div class="review-form-wrapper">
                                            <div class="review-form">
                                                <span class="comment-reply-title">Add a review </span>
                                                <form method="POST" action="javascript:;" class="addReview" id="addReview">
                                                    <input type="hidden" name="currentPage" value="<?= $currentPage; ?>">
                                                    <input type="hidden" name="productId" id="reviewProductId" value="<?= $product['id']; ?>">
                                                    <input type="hidden" name="url" id="pageUrl" value="<?= $url; ?>">
                                                    <p class="comment-notes">
                                                        <span id="email-notes">Your email address will not be published.</span>
                                                        Required fields are marked
                                                        <span class="required">*</span>
                                                    </p>
                                                    <div class="comment-form-rating">
                                                        <div class="star" style="float:left">
                                                            <input class="star star-5" id="star-5" type="radio" name="starRating" value="5" />
                                                            <label class="star star-5" for="star-5"></label>
                                                            <input class="star star-4" id="star-4" type="radio" name="starRating" value="4" />
                                                            <label class="star star-4" for="star-4"></label>
                                                            <input class="star star-3" id="star-3" type="radio" name="starRating" value="3" />
                                                            <label class="star star-3" for="star-3"></label>
                                                            <input class="star star-2" id="star-2" type="radio" name="starRating" value="2" />
                                                            <label class="star star-2" for="star-2"></label>
                                                            <input class="star star-1" id="star-1" type="radio" name="starRating" value="1" />
                                                            <label class="star star-1" for="star-1"></label>
                                                        </div>

                                                    </div>

                                                    <div class="input-element">
                                                        <div class="comment-form-comment">
                                                            </br>
                                                            </br>
                                                            <div>

                                                                <textarea name="comment" placeholder="Write a product review" id="review_comment" maxlength="500" cols="40" rows="8"></textarea>
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class="comment-submit">
                                                        <button type="submit" class="form-button btn btn-cart2" <?php if (!USER::isLoggedIn()) { ?> <?php } ?>>Submit</button>
                                                    </div>
                                            </div>
                                            </form>
                                        </div>
                                        <div class="spr-reviews mt-5">
                                            <h4 class="spr-form-title text-uppercase mb-3">Customer Reviews</h4>
                                            <div class="review-inner">
                                                <?php
                                                if ($product['reviews'] != '') {
                                                    foreach ($product['reviews'] as $review) {
                                                ?>
                                                        <div class="spr-review">
                                                            <div class="spr-review-header">

                                                                <h5 class="spr-review-header-title mt-1"><?= $review['firstname']; ?></h5>
                                                                <div class="d-flex mb-3" style="gap: 14px; align-items: center;">
                                                                    <span class="spr-review-header-byline">on <strong><?= $review['datentime']; ?></strong></span>
                                                                    <span class="product-review spr-starratings">
                                                                        <span class="reviewLink">
                                                                            <?php
                                                                            $n = $review['star'];
                                                                            if ($n != "") {

                                                                                $whole = floor($n);

                                                                                $fraction = $n - $whole;

                                                                                for ($i = 0; $i < $whole; $i++) {
                                                                            ?>
                                                                                    <i class="icon an an-star"></i>
                                                                                <?php
                                                                                }
                                                                                if ($fraction > 0.25) {
                                                                                ?>
                                                                                    <i class="icon an an-star mx-1"></i>
                                                                            <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </span>
                                                                    </span>
                                                                </div>

                                                            </div>
                                                            <div class="spr-review-content">
                                                                <p class="spr-review-content-body"><?= $review['review']; ?></p>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <?php
            //Show Related Products

            if ($product['subSubCat_id'] != "") {
                $getRelatedId = 'p.subSubCat_id="' . $product['subSubCat_id'] . '"';
            } else if ($product['subcat_id'] != "") {
                $getRelatedId = 'p.subcat_id="' . $product['subcat_id'] . '"';
            } else {
                $getRelatedId = 'p.cat_id="' . $product['cat_id'] . '"';
            }

            $relatedCondition = $getRelatedId . " AND p.product_code <> '" . $product['product_code'] . "'";

            ?>
            <!--You May Also Like Products-->
            <section class="section product-slider pb-0">
                <div class="container">
                    <div class="row">
                        <div class="section-header col-12">
                            <h2 class="text-transform-none">You May Also Like</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <?php
                            $relatedProducts = $homePage->products('related', $relatedCondition);
                            if (empty($relatedProducts)) {
                                echo "<div class='pt-5' style='background-color:#f5f9ff; align-items: center; width:100%; height:250px;'>";
                                echo "<img  class='rounded mx-auto my-auto d-block' src='asset/image/empty-product.png' style='height:50%' alt=''>";
                                echo "<h1 class='h1 text-center'>No Product Found!</h1>";
                                echo "</div>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="productSlider grid-products">
                        <?php

                        foreach ($relatedProducts as $product) {
                            $issubcategory = mysqli_fetch_assoc(mysqli_query($con, "SELECT c.issubcategory FROM category c  WHERE c.id=" . $product['cat_id']))['issubcategory'];
                            if ($issubcategory == 'Yes' && $product['subcat_id'] != '') {
                                // echo "SELECT classtype_id FROM subcategory WHERE id=".$product['subcat_id'];
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
                                                    <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $product['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>" title="Quick View" class="btn-icon quick-view-popup quick-view" data-toggle="modal" data-target="#content_quickview">
                                                        <i class="icon an an-cart-l"></i>
                                                        <span class="tooltip-label">Buy Now</span>
                                                    </a>
                                                <?php } else { ?>
                                                    <a href="cart.php" title="View Cart" class="btn-icon quick-view-popup quick-view" data-toggle="modal" data-target="#content_quickview">
                                                        <i class="icon an an-cart-l"></i>
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

                        <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
            <!--End You May Also Like Products-->
        </div>
    </div>
</main>

<?php include('includes/footer.php') ?>
<script>
    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".mySwiper2", {
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });
</script>
<script>
    function changeurlbyclass(value) {
        var pv = window.location.href.split("product_id=")[1].split("&")[0];
        var url = window.location.href.replace("product_id=" + pv, "product_id=" + value);
        $('.productdetails').load('product-detail.php?product_id=' + value + ' #sectionhtml');
        history.pushState(null, null, url);

        Swal.fire({
            title: "<span>Please Wait... <br> <div class='SWLoader'></div></span>",
            html: "Request under processing, please do not lock the screen or leave the page.",
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: 2500,
        }).then(function() {
            reloadPageAssets('assets/js/slick/slick.js', 'assets/js/slick/custom_slick.js', 'js/easyzoom.min.js', 'assets/css/dist/easyzoom.js');
            reloadPageAssets('assets/js/shareButtons.min.js');
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
            easyzoomInit();

            shareSocialButtonInit();

        });


        setTimeout(function() {
            reloadPageAssets('assets/js/slick/slick.js', 'assets/js/slick/custom_slick.js', 'js/easyzoom.min.js', 'assets/css/dist/easyzoom.js');
            reloadPageAssets('assets/js/shareButtons.min.js');
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
            easyzoomInit();
        }, 1500);

        shareSocialButtonInit();

    }

    function openCartPage() {
        window.open("./cart.php", "_self")
    }
</script>