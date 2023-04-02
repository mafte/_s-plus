<?php
// Get fields with $bk array or sub_field() function
// var_dump($bk);

$bk = (object) get_fields();
?>

<section id="<?php echo esc_attr( isset( $block['anchor'] ) ? $block['anchor'] : '' ); ?>" class="bk-hero-page <?php echo esc_attr( isset( $block['className'] ) ? $block['className'] : '' ); ?>">
	<div class="container">

		<div class="row">
			<div class="col-12">
				<div class="bk-hero-page__content">
					<?php if ( $bk->headline ) : ?>
						<h2 class="bk-hero-page__title"><?php echo esc_html( $bk->headline ); ?></h2>
					<?php endif; ?>
					<?php sp_the_resp_img( 'large', $bk->image, 'bk-hero-page__img' ); ?>
				</div>
			</div>
		</div>

	</div>
</section>
