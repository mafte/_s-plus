<?php
$class_css  = get_sub_field('class_css');
$id_section = get_sub_field('html_anchor');
?>

<div class="container <?php echo $class_css; ?>" id="<?php echo $id_section; ?>">

    <div class="row">
        <div class="col-12 col-layout">
            <?php include(get_template_directory() . '/ACF/acf-generate-page.php'); ?>
        </div>
    </div>

</div>