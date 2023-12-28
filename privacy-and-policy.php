<?php include("header.php") ?>
<style>
  .inner-box {
    margin: 30px 0;
  }

  .inner-box p {
    font-size: 16px;
    line-height: 1.5;
    margin: 15px 0;
    color: #444;
  }

  .faq-box-contain .faq-contain h2 {
    font-weight: 700;
    font-size: calc(28px + (56 - 28) * ((100vw - 320px) / (1920 - 320)));
    line-height: 1.4;
  }

  .faq-box-contain .faq-contain {
    margin-bottom: 0;
    position: sticky;
    top: 92px;
  }

  .section-b-space {
    padding-bottom: calc(30px + (50 - 30) * ((100vw - 320px) / (1920 - 320)));
  }

  section,
  .section-t-space {
    padding-top: calc(30px + (50 - 30) * ((100vw - 320px) / (1920 - 320)));
  }

  h3 {
    font-size: calc(16px + (20 - 16) * ((100vw - 320px) / (1920 - 320)));
    font-weight: 500;
    line-height: 1.2;
    margin: 0;
  }
  .inner-box h2 {
    font-size: 2.2rem;
}
</style>
<section class="faq-box-contain section-b-space">
  <div class="container">
    <div class="row">
      <div class="col-xl-10 mx-auto text-center">
        <div class="faq-contain">
          <h2 class="m-0">Privacy Policy</h2>
        </div>
      </div>
    </div>
    <div class="inner-box">
      <?php
      // show privacy policy
      $privacyAndPolicy = $homePage->getPrivacyAndPolicy();
      // print_r($privacyAndPolicy);
      if (!empty($privacyAndPolicy)) {
        foreach ($privacyAndPolicy as $pAndP) {
      ?>
          <h2><?= $pAndP['title']; ?></h2>
          <?php
          foreach ($pAndP['description'] as $des) {
          ?>
            <p><?= $des[0]; ?></p>
          <?php
          }
          ?>
      <?php
        }
      } ?>
    </div>
  </div>
</section>

<?php include("includes/footer.php") ?>