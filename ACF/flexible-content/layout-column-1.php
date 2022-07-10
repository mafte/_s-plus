<?php
$class_css  = get_sub_field('class_css');
?>

<div <?php echo $atts_globals; ?> class="container <?php echo $class_css; ?>">

    <div class="row">
        <div class="col-12 col-layout">
            <?php include(get_template_directory() . '/ACF/acf-generate-page.php'); ?>
        </div>
    </div>

</div>