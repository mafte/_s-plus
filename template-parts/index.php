<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s_plus
 */

get_header();
?>

<main id="primary" class="site-main">


    <div class="container">
        <div class="row">
            <div class="col">
                <?php

                echo sp_get_img__resp('large', 83, 'Optional');



                ?>


            </div>
        </div>
        <div class="row cols-24">
            <div class="col">
                <div class="box-green">

                </div>
            </div>
            <div class="col">
                <div class="box-green">

                </div>
            </div>
        </div>
        <div class="row cols-24">
            <div class="col">
                <div class="box-blue">

                </div>
            </div>
            <div class="col">
                <div class="box-blue">

                </div>
            </div>
            <div class="col">
                <div class="box-blue">

                </div>
            </div>
        </div>

        <div class="row cols-24">
            <div class="col">
                <div class="box-red">

                </div>
            </div>
            <div class="col">
                <div class="box-red">

                </div>
            </div>
            <div class="col">
                <div class="box-red">

                </div>
            </div>
            <div class="col">
                <div class="box-red">

                </div>
            </div>
        </div>

        <div class="row cols-24 cols-w-400">
            <div class="col">
                <div class="box-red">

                </div>
            </div>
            <div class="col">
                <div class="box-green">

                </div>
            </div>
            <div class="col">
                <div class="box-red">

                </div>
            </div>
            <div class="col">
                <div class="box-blue">

                </div>
            </div>
            <div class="col">
                <div class="box-red">

                </div>
            </div>
        </div>

    </div>
</main><!-- #main -->

<?php

get_footer();
