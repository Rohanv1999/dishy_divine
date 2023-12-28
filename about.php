<?php include('header.php') ?>
<div id="page-content">
  <!--Collection Banner-->
  <div class="collection-header">
    <div class="collection-hero">
      <div class="collection-hero__image"></div>
      <div class="collection-hero__title-wrapper container">
        <h1 class="collection-hero__title">About Us </h1>
        <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="index.php" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">About Us </span></div>
      </div>
    </div>
  </div>
  <!--End Collection Banner-->

  <!--Main Content-->
  <div class="container">
    <!-- Collection Banner -->
    <div class="collection-header inner-content">
      <div class="collection-hero inner mb-0">
        <div class="collection-hero__image hny">
          <img src="assets/images/about/about-bg.jpg" alt="">
        </div>
        <div class="collection-hero__title-wrapper">
          <h2 class="collection-hero__title text-white position-relative">Welcome to Dishy Divine</h2>
          <p class="collection__subtitle fs-6 text-white position-relative">Who we are</p>
        </div>
      </div>
    </div>
    <!-- Collection Banner -->
    <!--Content Info-->
    <div class="row section">
      <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-3 mb-md-0">
        <h3>Our Vision</h3>
        <?php $ourVision = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM aboutus WHERE id = '1'"))['vision']; ?>
        <p><?= $ourVision; ?></p>
      </div>
      <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        <h3>Our Mission</h3>
        <?php $ourMission = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM aboutus WHERE id = '1'"))['mission']; ?>
        <p><?= $ourMission; ?></p>
      </div>
    </div>
    <!-- End Content Info -->
  </div>

  <!--Who We Are-->
  <div class="container-fluid px-0 clr-f5 about-bnr-text">
    <div class="container section">
      <div class="row g-0 align-items-center">
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 row_text">
          <div class="about-info2 row-text">
            <h3 class="h1 mb-3 fs-26 fw-bold">Who We Are</h3>
            <?php
            // Show about us
            $query = "SELECT * FROM aboutus WHERE id = '1'";
            $querydb = mysqli_query($con, $query);
            $data = mysqli_fetch_array($querydb);

            ?>
            <p class="section-desc text-grey"><?php echo $data['aboutus']; ?></p>

          </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
          <img class="about-info-img blur-up lazyload" data-src="assets/images/about/about.png" src="assets/images/about/about.png" alt="about" />
        </div>
      </div>
    </div>
  </div>
  <!--End Who We Are-->
  <!--Store Feature-->
  <section class="store-features style1 py-0 pt-4 pb-4">
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



</div>
<!--End Body Container-->
<?php include('includes/footer.php') ?>