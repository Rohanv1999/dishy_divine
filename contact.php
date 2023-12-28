<?php include('header.php') ?>
<style>
  .p-4 {
    padding: 20px;
  }
</style>
<main class="main">

  <div class="collection-header">
    <div class="collection-hero mb-0">
      <div class="collection-hero__image"></div>
      <div class="collection-hero__title-wrapper container">
        <h1 class="collection-hero__title">Contact Us </h1>
        <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="index.php" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Contact Us</span></div>
      </div>
    </div>
  </div>
  <div class="page-content mt-10 pt-7">
    <section class="contact-section mt-5 mb-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-6 ls-m mb-4">
            <div class="grey-section d-flex align-items-center h-100 justify-content-center">
              <div class="p-4">
                <h4 class="mb-2 text-capitalize">Headquarters</h4>
                <p><?= $homePage->contactInfo('address'); ?></p>
                <h4 class="mb-2 text-capitalize">Phone Number</h4>
                <p>
                  <a href="tel:<?= $homePage->contactInfo('phone'); ?>"><?= $homePage->contactInfo('phone'); ?></a>,
                  <a href="tel:<?= $homePage->contactInfo('telephone'); ?>"><?= $homePage->contactInfo('telephone'); ?></a>
                </p>
                <h4 class="mb-2 text-capitalize">Support</h4>
                <p class="mb-4">
                  <a href="mailto:<?= $homePage->contactInfo('email'); ?>"><span><?= $homePage->contactInfo('email'); ?></span></a><br>
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-9 col-md-8 col-sm-6 d-flex align-items-center mb-4">
            <div class="w-100">
              <form id="contactFormSubmit" method="post">
                <h4 class="ls-m font-weight-bold">Let’s Connect</h4>
                <p>Your email address will not be published. Required fields are
                  marked *</p>
                <div class="contact-input">
                  <div class="row">
                    <div class="col-lg-6 mb-4">
                      <div class="first-name">
                        <input type="text" name="fullName" id="fullName" value="" class="form-control" placeholder="Full Name" required title="Only Alphabet with Space Allow" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)">
                        <div class="err_msg" id="fullNameErrMsg"></div>
                      </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                      <div class="last-name">
                        <input type="text" name="phone" id="phone" value="" class="form-control" length="10" required title="Please enter exactly 10 digits" onkeydown="return ( event.ctrlKey || event.altKey || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) || (95<event.keyCode && event.keyCode<106) || (event.keyCode==8) || (event.keyCode==9) || (event.keyCode>34 && event.keyCode<40) || (event.keyCode==46) )" maxlength="10" placeholder="Enter Your Number">
                        <div class="err_msg" id="phoneErrMsg"></div>
                      </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                      <div class="email">
                        <input type="email" name="email" id="email" value="" class="form-control" placeholder="Email" required maxlength="150">
                        <div class="err_msg" id="emailErrMsg"></div>
                      </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                      <div class="subject">
                        <input type="text" name="subject" id="subject" value="" class="form-control" placeholder="Subject" required maxlength="100">
                        <div class="err_msg" id="subjectErrMsg"></div>
                      </div>
                    </div>
                    <div class="col-lg-12">
                    </div>
                    <div class="contact-message mb-20">

                      <div class="custom-textarea message">
                        <textarea class="form-control" name="message" id="message" required placeholder="Enter Your Message" rows="6" spellcheck="false" data-ms-editor="true" maxlength="3600"></textarea>
                        <span>Max message length: <span id="charsrb">3600</span> Characters</span>
                      </div>
                    </div>
                    <div class="contact-submit mt-2">
                      <button type="submit" class="btn btn-dark btn-rounded contactsbt">Submit <i class="d-icon-arrow-right"></i></button>
                    </div>
                  </div>
                </div>
              </form>
              <p class="form-messege"></p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="grey-section google-map" id="googlemaps">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3560.9587692209875!2d80.99829837476062!3d26.809441434802732!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399be3446b62ffc1%3A0x26d771997179fae7!2sOmaxe%20Residency%201%2COrchid%20A%20%2C!5e0!3m2!1sen!2sin!4v1702041235273!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

  </div>
</main>
<?php include('includes/footer.php') ?>