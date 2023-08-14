<?php
//Get fields with $cp array or get_sub_field()
// var_dump($cp);

?>

<!-- CP-IMAGE ************************** -->

<section <?php echo $atts_globals; ?> class="cp-image <?php echo $cp->class_css; ?>">

	<div class="container">
		<div class="row">
			<div class="col">

				<?php sp_the_resp_img( 'large', $cp->image, 'cp-image__item img-fluid-fix' ); ?>

				<?php echo sp_generate_link( $cp->button_link ); ?>

			</div>
		</div>
	</div>
</section>

<!-- ************************** CP-IMAGE -->
