      <!--Confirm box-->
      <div class="modal fade" id="alertBox">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">

                  <div class="modal-header">
                      <input type="hidden" class="close" id="closeModelBox" data-dismiss="modal" />
                  </div>

                  <div class="modal-body">
                      <img src="assets/images/alertimg.png" alt="alertinfo" width="100px">
                      <div id="descrip">
                      </div>
                  </div>

                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary btn-rounded btn-icon-right" data-dismiss="modal">Ok</button>
                  </div>
              </div>
          </div>
      </div>
      </div>

      <div class="modal fade" id="confirmModal" style="display: none; z-index: 1050;">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-img">
                      <img src="assets/images/alertimg.png" alt="alertinfo">
                  </div>
                  <div class="modal-body" id="confirmMessage">
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-primary btn-rounded btn-icon-right" id="confirmOk">Ok</button>
                      <button type="button" class="btn btn-primary btn-rounded btn-icon-right" id="confirmCancel">Cancel</button>
                  </div>
              </div>
          </div>
      </div>

      <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog" style="transform: translate(0);">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="modalTitle">Modal title</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="showItems">
                      ...
                  </div>
                  <div class="modal-footer">
                      <a type="button" class="btn btn-secondary" href="index.php">Browse More</a>
                      <a type="button" class="btn btn-primary" id="modalProceedBtn" href="checkout.php">Proceed wihtout these</a>
                  </div>
              </div>
          </div>
      </div>

      <div id="snackbarDefaultNew"></div>

      <div class="footer footer-2">
          <div class="footer-top clearfix">
              <div class="container">
                  <div class="row">
                      <div class="col-12 col-sm-12 col-md-12 col-lg-4 footer-about mb-4 mb-lg-0">
                          <?php
                            //show logo
                            $logo = $homePage->logo();
                            ?>
                          <a href="index.php" class="logo-footer widget-title">
                              <img src="asset/image/logo/<?= $logo['logo'] ?>" alt="logo-footer" width="154" height="43">
                          </a>
                          <p class="mb-1">Welcome to Dishy Divine, your ultimate destination for quality grocery products that elevate your culinary experience! At Dishy Divine, we're passionate about bringing the finest ingredients and essential items to your kitchen, making every meal a delightful affair.</p>
                      </div>
                      <div class="col-12 col-sm-12 col-md-4 col-lg-2 footer-links">
                          <h4 class="h4">Informations</h4>
                          <ul>

                              <li><a href="about.php">About Us</a></li>
                              <li><a href="contact.php">Contact Us</a></li>
                              <li><a href="faq.php">FAQ</a></li>
                              <li><a href="disclaimer.php">Disclaimer</a></li>
                              <li><a href="return-refund.php">Return Refund</a></li>
                              <li><a href="privacy-and-policy.php">Privacy Policy</a></li>
                              <li><a href="term-and-condition.php">Terms &amp; Condition</a></li>
                          </ul>
                      </div>
                      <div class="col-12 col-sm-12 col-md-4 col-lg-2 footer-links">
                          <h4 class="h4">Quick Shop</h4>
                          <ul>
                              <?php
                                // show menu
                                //print_r($homePage->menu());
                                $ab = 1;
                                foreach ($homePage->menu() as $mainMenu) {
                                    if ($mainMenu['subMenu'] == 0) {
                                ?>
                                      <li><a href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&<?= $mainMenu['condition']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>"><?= $mainMenu['cat_name']; ?></a></li>
                                  <?php } else { ?>
                                      <li><a href="listing.php?<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>&<?= $mainMenu['condition']; ?>&<?= $homePage->generateToken(40); ?>=<?= $homePage->generateToken(40); ?>"><?= $mainMenu['cat_name']; ?></a></li>
                              <?php }
                                    if ($ab == 4) {
                                        break;
                                    }
                                    $ab++;
                                } ?>
                          </ul>
                      </div>
                      <div class="col-12 col-sm-12 col-md-4 col-lg-4 footer-contact">
                          <h4 class="h4">Contact Us</h4>
                          <p class="address d-flex align-items-center"><i class="an an-map-marker-al"></i> <?= $homePage->contactInfo('address'); ?></p>
                          <a href="tel:<?= $homePage->contactInfo('phone'); ?>" class="phone d-flex align-items-center">
                              <i class="an an-phone-l"></i> <b class="me-1">Phone:</b> <?= $homePage->contactInfo('phone'); ?></a>

                          <a href="mailto:<?= $homePage->contactInfo('email'); ?>" class="email d-flex align-items-center"><i class="an an-envelope-l"></i> <b class="me-1">Email:</b><?= $homePage->contactInfo('email'); ?></a>

                          <ul class="list-inline social-icons mt-3">
                              <?php
                                // Show social media
                                $social = $homePage->socialMedia();
                                if (!empty($social)) {
                                    foreach ($social as $value) {
                                ?>
                                      <li class="list-inline-item">
                                          <a href="<?= $value['url'] ?>" class="social-link" title="<?= $value['name'] ?>" target="_blank"><i class="<?= $value['icon'] ?>"></i></a>
                                      </li>
                              <?php
                                    }
                                }
                                ?>


                          </ul>
                           <div class="display-table pt-md-3 pt-lg-0">
                              <div class="display-table-cell footer-newsletter">

                                  <form method="post" id="subscribeForm" class="mt-3">
                                      <label class="h4">SUBSCRIBE TO US</label>
                                      <div class="input-group">
                                          <input type="email"
                                              class="brounded-start input-group__field newsletter-input mb-0"
                                              placeholder="Your Email Address" name="userEmail" value="" required>
                                          <span class="input-group__btn">
                                              <button type="submit" class="btn newsletter__submit rounded-end"
                                                  name="submit" ><i class="an an-envelope-l"></i></button>
                                          </span>
                                      </div>
                                  </form>

                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">

                      <div class="col-12 col-sm-12 col-md-6 col-lg-6 copyright-col mt-3 mt-md-4 mt-lg-5">
                          <div class="copytext mb-2 pb-1">Copyright &copy; 2023 Dishy Divine. All Rights Reserved.</div>

                          <img src="assets/images/payment.png" alt="Paypal Visa Payments" />
                      </div>
                      <div class="col-12 col-sm-12 col-md-6 col-lg-6 newsletter-col mt-4 mt-lg-5">
                          <!-- <div class="display-table pe-lg-3">
                              <div class="display-table-cell footer-newsletter">
                                  <form action="#" method="post">
                                      <label class="h4">Newsletter Sign Up</label>
                                      <p>Enter your email to receive daily news and get 20% off coupon for all items.</p>
                                      <div class="input-group">
                                          <input type="email" class="border-0 rounded-0 input-group__field newsletter-input" name="EMAIL" value="" placeholder="Email address" required>
                                          <span class="input-group__btn">
                                              <button type="submit" class="btn newsletter__submit rounded-0" name="commit">Subscribe</button>
                                          </span>
                                      </div>
                                  </form>
                              </div>
                          </div> -->
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!--End Footer-->

      <!--Scoll Top-->
      <span id="site-scroll"><i class="icon an an-arw-up"></i></span>
      <!--End Scoll Top-->


      <!--End MiniCart Drawer-->
      <div class="modalOverly"></div>

      <!--Quickview Popup-->
      <div class="loadingBox">
          <div class="an-spin"><i class="icon an an-spinner4"></i></div>
      </div>
      <!-- scroll to top -->
      <a id="scroll-top" href="#top" title="Top" role="button" class="scroll-top"><i class="d-icon-arrow-up"></i></a>
      <script type="text/javascript">
          var max = 0;
      </script>

      <div id="snackbar">Product Added to cart...</div>
      <div id="snackbar1">Product Added to Wishlist...</div>
      <div id="snackbarDefault">Error Occur...</div>

      <script type="text/javascript">
          var currentPage = '<?= $currentPage ?>';
          var currency = '<?= $currency; ?>';
      </script>
      <!--Jquery 1.12.4-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
      <!--Popper-->
      <script src="js/popper.min.js"></script>

      <!--Imagesloaded-->
      <script src="js/imagesloaded.pkgd.min.js"></script>
      <!--Isotope-->
      <script src="js/isotope.pkgd.min.js"></script>
      <!--Ui js-->
      <script src="js/jquery-ui.min.js"></script>
      <!--Countdown-->
      <script src="js/jquery.countdown.min.js"></script>
      <!--Counterup-->
      <script src="js/jquery.counterup.min.js"></script>
      <!--ScrollUp-->
      <script src="js/jquery.scrollUp.min.js"></script>
      <!--Chosen js-->
      <script src="js/chosen.jquery.js"></script>
      <!--Meanmenu js-->
      <script src="js/jquery.meanmenu.min.js"></script>
      <!--Instafeed-->
      <script src="js/instafeed.min.js"></script>
      <!--EasyZoom-->
      <script src="js/easyzoom.min.js"></script>
      <!--Fancybox-->
      <script src="js/jquery.fancybox.pack.js"></script>
      <!--Nivo Slider-->
      <script src="js/jquery.nivo.slider.js"></script>
      <!--Waypoints-->
      <script src="js/waypoints.min.js"></script>
      <!--Carousel-->
      <script src="js/owl.carousel.min.js"></script>
      <!--Slick-->
      <script src="js/slick.min.js"></script>
      <!--Wow-->
      <script src="js/wow.min.js"></script>
      <!--Plugins-->
      <script src="js/plugins.js"></script>
      <!--Main Js-->
      <script src="js/main.js"></script>
      <script src="js/image-uploader.min.js"></script>
      <script src="record-process/js/record-process.js"></script>
      <script type="text/javascript" src="js/themejs/addtocart.js"></script>

      <!-- Including Jquery -->
      <script src="assets/js/vendor/jquery-min.js"></script>
      <script src="assets/js/vendor/js.cookie.js"></script>
      <script src="assets/js/plugins.js"></script>
      <script src="assets/js/main.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
      <script>
          var currency = '<?= $currency; ?>';

          function userNotLoginAlert() {
              Swal.fire({
                  title: 'You are not logged in!',
                  text: "Please log in to continue.",
                  icon: "warning",
                  buttons: ["Cancel", "Log in"],
              }).then((result) => {
                  if (result.isConfirmed) {
                      window.location.href = "./account.php?";
                  }
              });
          }
      </script>
      <script>
          function openOrderTabSection() {
              $('#my_order_tab_li').addClass('active');
              $("#my_order_tab").click();
          }

          var urlParams = new URLSearchParams(window.location.search);
          var trackorderParam = urlParams.get('trackorder');
          if (trackorderParam === 'y') {

              Swal.fire({
                  title: 'TRACK YOUR ORDER',
                  html: "<h5>Order Track Instruction</h5><ul><li>1 .Open the 'Orders' tab. If you're not sure where it is, please locate and click on the 'Orders' tab.</li><li>2. If you have purchased a product, a list of products will be displayed. Find the product that you want to track.</li><li>3. Click on the product that you want to track.</li></ul>",
                  showCancelButton: false,
                  showConfirmButton: true,
                  onOpen: function() {
                      Swal.showLoading()
                  }
              }).then(function() {
                  openOrderTabSection();
              });
              // Get the current URL
              const currentUrl = window.location.href;
              // Remove the "trackorder" parameter from the query string
              const updatedUrl = currentUrl.replace(/[\?&]trackorder=y/, '');
              // Replace the current URL with the updated URL
              history.replaceState(null, null, updatedUrl);
          }
      </script>
      </div>
      <!--End Page Wrapper-->
      </body>

      </html>