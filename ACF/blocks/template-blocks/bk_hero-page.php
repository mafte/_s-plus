<?php
// Get fields with $bk array or sub_field() function
// var_dump($bk);

$bk            = (object) get_fields();
$text_class    = 'row row_no_image';
$wrapper_class = 'container container_no_image';
$image_class   = 'hero_no_image';

if ($bk->image) :
    $text_class    = 'col-12 col-lg d-flex align-items-center hero-image justify-content-center justify-content-lg-end';
    $wrapper_class = 'row no-gutters';
    $image_class   = 'col-12 col-lg';
endif;
?>

<section id="<?php echo $block['id'] ?>" class="bk-hero-page mb-120 <?php echo $block['className']; ?>">
    <div class="container">
        <div class="<?php echo $wrapper_class; ?>">
            <div class="<?php echo $text_class; ?>">
                <div class="bk-hero-page--content">
                    <p class="bk-hero-page--subtitle"><?php echo $bk->sub_headline; ?></p>
                    <h1 class="bk-hero-page--title"><?php echo $bk->headline; ?></h1>
                </div>
            </div>

            <div class="<?php echo $image_class; ?>">
                <div class="bk-hero-page--image">
                    <img src="<?php echo sp_get_img__url('large', $bk->image); ?>" alt="<?php echo sp_get_img__alt($bk->image); ?>">
                </div>
            </div>
        </div>


    </div>
</section>