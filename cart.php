<?php include('header.php') ?>
<style>
  h3.summary-title.text-left {
    background-color: #fafafa;
    padding: 13px;
    font-family: 'Poppins';
  }
  tr.summary-subtotal {
    border-bottom: 1px solid #c5c5c5;
}
td.summary-subtotal-price {
    text-align: right;
}
td.summary-total-price.ls-s {
    text-align: right;
    font-size: 16px;
    color: black;
    font-weight: 500;
}
</style>
<main class="main cart">
  <div class="collection-header">
    <div class="collection-hero">
      <div class="collection-hero__image"></div>
      <div class="collection-hero__title-wrapper container">
        <h1 class="collection-hero__title">Cart Page </h1>
        <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="index.php" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Cart Page </span></div>
      </div>
    </div>
  </div>
  <div class="cartPage">
    <div id="resetCart">
      <?php
      //show cart List
      $items = $cart->cartDetail();

      if (isset($items['cartEmpty'])) {
      ?>

        <h1 class="text-center">
          <img src="assets/images/empty_cart.jpg" alt="" width="500px">
        </h1>
        <br>
        <div class="text-center cart_submit">
          <a href="index.php"><button type="button" class="btn btn-primary btn-rounded btn-md ml-2">Shop
              Now</button></a>
        </div>
        <br>
      <?php
      } else {
      ?>
        <div class="container mt-7 mb-2">
          <div class="row">
            <div class="col-lg-8 col-md-12 pr-lg-4">
              <table class="shop-table cart-table">
                <thead>
                  <tr>
                    <th><span>Product</span></th>
                    <th></th>
                    <th><span>Unit&nbsp;Price</span></th>
                    <th><span>Quantity</span></th>
                    <th>Total&nbsp;Price</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($items as $item) {
                    $query1 = "";
                    if ($item['class2'] != '')
                      $query1 = '+' . mysqli_fetch_assoc(mysqli_query($con, "SELECT symbol FROM size_class WHERE id=" . $item['class2']))['symbol'];

                  ?>
                    <tr>
                      <td class="product-thumbnail">
                        <figure>

                          <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $item['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>">
                            <img src="asset/image/product/<?= $item['image']; ?>" width="100" height="100" alt="product">
                          </a>
                        </figure>
                      </td>
                      <td class="product-name">
                        <div class="product-name-section">
                          <a href="product-detail.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&product_id=<?= $item['id']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>"><?= $item['product_name']; ?></a>
                          <?php if ($item['symbol'] != '') echo ' - (' . $item['symbol'] . $query1 . ')' ?>
                          <?php if ($item['class1'] != '') echo ', (' . $item['class1'] .')' ?>
                        </div>
                      </td>
                      <td class="product-subtotal">
                        <span class="amount"><?= $currency; ?>


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
                          ?><?= $price; ?></span>
                      </td>

                      <td class="product-quantity">
                        <div class="input-group hny-crt">
                          <button onclick="decreaseQuantity(this)" class="quantity-minus icon an an-minus-r"></button>
                          <input class="action-input itemQuantity" title="Quantity Number" type="number" min="<?= $item['minimum']; ?>" max="<?= $item['maximum']; ?>" value="<?= $item['quantity']; ?>" name="itemQuantity" onchange="changeItemQuantity(<?= $item['id']; ?>,this.value,<?= $item['class0']; ?>);">
                          <button onclick="increaseQuantity(this)" class="quantity-plus icon an an-plus-r"></button>
                        </div>
                      </td>

                      <td class="product-price">
                        <span class="amount" id="productTotal<?= $item['id']; ?>"><?= $currency; ?> <?= ($price * $item['quantity']); ?></span>
                      </td>
                      <td class="product-close">
                        <a onclick="removeFromCart(<?= $item['id']; ?>)" class="product-remove" title="Remove this product">
                          <i class="fas fa-times"></i>
                        </a>
                      </td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
              <div class="cart-actions mb-6 pt-4">
                <a href="index.php" class="btn btn-dark btn-md btn-rounded btn-icon-left mr-4"><i class="d-icon-arrow-left"></i>Continue Shopping</a>
                <button type="submit" class="btn  btn-dark btn-md btn-rounded" onclick="clearCart();">Clear Cart</button>
              </div>

            </div>
            <aside class="col-lg-4 sticky-sidebar-wrapper">
              <div class="sticky-sidebar" data-sticky-options="{'bottom': 20}">
                <div class="summary mb-4">
                  <h3 class="summary-title text-left">Cart Totals</h3>
                  <table class="shipping">
                    <tr class="summary-subtotal">

                      <td>
                        <h4 class="summary-subtitle">Subtotal</h4>
                      </td>

                      <td class="summary-subtotal-price"><?= $currency; ?><span class="cartSubTotalAmount">
                          <?= $cart->cartSubTotalAmount(); ?></span></td>
                    </tr>

                    <tr class="summary-subtotal">
                      <td>
                        <h4 class="summary-subtitle">Subtotal</h4>
                      </td>

                      <td class="summary-subtotal-price"><?= $currency; ?><span> 00.00</span>
                      </td>
                    </tr>

                  </table>
                  <table class="total">
                    <tr class="summary-subtotal">
                      <td>
                        <h4 class="summary-subtitle">Total</h4>
                      </td>

                      <td class="summary-total-price ls-s"><?= $currency; ?> <span class="cartTotalAmount"><strong>
                            <?= $cart->cartTotalAmount(); ?></strong></span></td>
                    </tr>
                  </table>
                  <a class="btn btn-dark btn-rounded btn-checkout checkout-button  btn-sqr" onclick="checkStock()">Proceed to
                    checkout</a>
                </div>
              </div>
            </aside>
          </div>
        </div>

      <?php
      }
      ?>
    </div>
  </div>
  </div>
</main>
<script type="text/javascript">
  var max = 0;
</script>
<?php include('includes/footer.php') ?>