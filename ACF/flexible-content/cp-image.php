<?php
//Get fields with $cp array or get_sub_field()
// var_dump($cp);

$html_anchor = '';
if ($cp->html_anchor) {
    $html_anchor = 'id="' . $cp->html_anchor . '"';
}
?>

<!-- ************************** CP-IMAGE -->

<section <?php echo $html_anchor; ?> class="cp-image <?php echo $cp->class_css; ?>">
    <?php $imageID =  $cp->image ?>

    <div class="container">
        <div class="row">
            <div class="col">

                <?php echo sp_img_resp('large', $imageID, 'cp-image__item img-fluid-fix'); ?>

            </div>
        </div>
    </div>
</section>

<!-- CP-IMAGE ************************** -->