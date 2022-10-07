<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package _s_plus
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();
?>

<main id="main-content" class="site-main">

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>This is the content</h1>
            </div>
        </div>
    </div>

</main><!-- #main -->

<?php

get_footer();
