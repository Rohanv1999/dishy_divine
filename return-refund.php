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
</style>
<section class="faq-box-contain section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mx-auto text-center">
                <div class="faq-contain">
                    <h2 class="m-0">Return & Refund Policy</h2>
                </div>
            </div>
            <div class="col-12">
                <?php
                $temsAndConQ = mysqli_query($con, "SELECT rd.description, rt.title, rd.title_id FROM return_exchange_title rt, return_exchange_desc rd WHERE rd.title_id = rt.id AND rd.status = 'Active'");
                $i = 1;
                $arr = [];
                while ($data = mysqli_fetch_assoc($temsAndConQ)) {

                    if (!in_array($data['title_id'], $arr)) {
                ?>
                        <div class="inner-box">

                            <?php if (strlen($data['title']) > 1) { ?>
                                <h5> <?= $data['title']; ?></h5>
                            <?php } ?>
                        <?php $i++;
                    }
                    array_push($arr, $data['title_id']); ?>
                        <p><?= $data['description']; ?></p>
                    <?php
                } ?>
                        </div>
            </div>

        </div>
</section>

<?php include("includes/footer.php") ?>