<?php
$class_css  = get_sub_field('class_css');
$id_section = get_sub_field('html_anchor');
$id_columns = array();
$id_columns[0] = '';
$id_columns[1] = '';

if ($id_section != '') {
    $id_columns[0] = 'id="' . $id_section . '--col-1"';
    $id_columns[1] = 'id="' . $id_section . '--col-2"';
    $id_section = 'id="' . $id_section . '"';
}

?>


<div <?php echo $atts_globals; ?> class="<?php echo $class_css; ?>">

    <div class="container">
        <div class="row">
            <div <?php echo $id_columns[0]; ?> class="col-6 col-layout-1">

                <?php
                if (have_rows('column_1')) : ?>
                    <?php
                    while (have_rows('column_1')) :
                        the_row(); ?>

                        <?php
                        //Get current row
                        $page_builder = get_sub_field('page_builder'); ?>

                        <?php include(get_template_directory() . '/ACF/acf-generate-page.php'); ?>

                    <?php endwhile; ?>
                <?php endif; ?>

            </div>

            <div <?php echo $id_columns[1]; ?> class="col-6 col-layout-2">

                <?php
                if (have_rows('column_2')) : ?>
                    <?php
                    while (have_rows('column_2')) :
                        the_row(); ?>

                        <?php
                        //Get current row
                        $page_builder = get_sub_field('page_builder'); ?>

                        <?php include(get_template_directory() . '/ACF/acf-generate-page.php'); ?>

                    <?php endwhile; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>

</div>