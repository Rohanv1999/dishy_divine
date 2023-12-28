<?php include('header.php') ?>
<div id="page-content">
    <!--Collection Banner-->
    <div class="collection-header">
        <div class="collection-hero">
            <div class="collection-hero__image"></div>
            <div class="collection-hero__title-wrapper container">
                <h1 class="collection-hero__title">FAQ</h1>
                <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="index.php"
                        title="Back to the home page">Home</a><span>|</span><span class="fw-bold">FAQ's</span>
                </div>
            </div>
        </div>
    </div>
    <!--End Collection Banner-->

    <!--Main Content-->
    <div class="container">
        <!-- FAQ's Style1 -->
        <div class="row">
            <div class="col-12 col-sm-12 col-md-10 col-lg-10 mx-auto">
                <?php
            // show faq
            $getFAQ = $homePage->getFAQ();
            // echo'<pre>';
            // print_r($getFAQ);
            if (!empty($getFAQ)) {
              foreach ($getFAQ as $faq) {
            ?>

                <div class="accordion" id="accordionFaq">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse<?= $faq['id']; ?>" aria-expanded="false"
                                aria-controls="collapse<?= $faq['id']; ?>"><?= $faq['title']; ?></button>
                        </h2>
                        <div id="collapse<?= $faq['id']; ?>" class="accordion-collapse collapse"
                            aria-labelledby="headingOne" data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                <?php
                        foreach ($faq['description'] as $des) {
                        ?>
                                <p><?= $des['description']; ?> </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
              }
            } ?>
            </div>
        </div>
        <!-- End FAQ's Style1 -->
    </div>
    <!--End Main Content-->
</div>
<!--End Body Container-->
<?php include('includes/footer.php') ?>