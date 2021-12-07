<?php
//Get fields with $cp array or get_sub_field()
// var_dump($cp);
?>

<!-- ************************** CP-IMAGE -->

<div class="cp-image <?php echo $cp->class_css; ?>">
    <?php $imageID =  $cp->image ?>

    <img class="cp-image__item img-fluid-fix" src="<?php echo sp_get_img__url('large', $imageID); ?>" alt="<?php echo getImg__alt($imageID); ?>">
</div>

<!-- CP-IMAGE ************************** -->