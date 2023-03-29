<?php
//Get fields with $cp array or get_sub_field()
// var_dump($cp);

?>

<!-- CP-IMAGE ************************** -->

<section <?php echo $atts_globals; ?> class="cp-image <?php echo $cp->class_css; ?>">
    <?php $imageID =  $cp->image ?>

    <div class="container">
        <div class="row">
            <div class="col">

                <?php echo sp_img_resp('large', $imageID, 'cp-image__item img-fluid-fix'); ?>

            </div>
        </div>
    </div>
</section>

<!-- ************************** CP-IMAGE -->